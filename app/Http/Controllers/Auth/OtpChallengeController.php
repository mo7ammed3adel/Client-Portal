<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\OtpService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OtpChallengeController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService
    ) {}

    public function show(Request $request): View|RedirectResponse
    {
        $challenge = $request->session()->get('auth.otp');

        if (! is_array($challenge)) {
            return redirect()->route('login');
        }

        return view('auth.otp-challenge', [
            'purpose' => $challenge['purpose'] ?? 'verification',
            'phone' => $challenge['phone'] ?? null,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $challenge = $request->session()->get('auth.otp');

        if (! is_array($challenge) || empty($challenge['phone']) || empty($challenge['purpose'])) {
            return redirect()->route('login');
        }

        try {
            $this->otpService->verify(
                (string) $challenge['phone'],
                $request->string('otp')->toString(),
                (string) $challenge['purpose']
            );
        } catch (HttpException $e) {
            throw ValidationException::withMessages([
                'otp' => $e->getMessage(),
            ]);
        }

        if ($challenge['purpose'] === 'registration') {
            return $this->completeRegistration($request, $challenge);
        }

        return $this->completeLogin($request, $challenge);
    }

    public function resend(Request $request): RedirectResponse
    {
        $challenge = $request->session()->get('auth.otp');

        if (! is_array($challenge) || empty($challenge['phone']) || empty($challenge['purpose'])) {
            return redirect()->route('login');
        }

        try {
            $otp = $this->otpService->generateAndStore((string) $challenge['phone'], (string) $challenge['purpose']);
        } catch (HttpException $e) {
            throw ValidationException::withMessages([
                'otp' => $e->getMessage(),
            ]);
        }

        $status = 'تم إرسال كود التحقق إلى هاتفك.';
        if (config('services.sms.otp_debug')) {
            $status .= " الكود: {$otp}";
        }

        return back()->with('status', $status);
    }

    /**
     * @param array<string, mixed> $challenge
     */
    private function completeRegistration(Request $request, array $challenge): RedirectResponse
    {
        $email = (string) ($challenge['email'] ?? '');
        $phone = (string) ($challenge['phone'] ?? '');

        if (User::query()->where('email', $email)->orWhere('phone', $phone)->exists()) {
            $request->session()->forget('auth.otp');

            throw ValidationException::withMessages([
                'otp' => 'هذا الحساب مسجل بالفعل. من فضلك سجل الدخول.',
            ]);
        }

        $user = User::create([
            'name' => (string) $challenge['name'],
            'email' => $email,
            'phone' => $phone,
            'phone_verified_at' => now(),
            'password' => (string) $challenge['password'],
            'role' => 'client',
        ]);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->forget('auth.otp');
        $request->session()->regenerate();

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * @param array<string, mixed> $challenge
     */
    private function completeLogin(Request $request, array $challenge): RedirectResponse
    {
        $user = User::query()->find($challenge['user_id'] ?? null);

        if (! $user) {
            $request->session()->forget('auth.otp');

            return redirect()->route('login');
        }

        if ($user->phone_verified_at === null) {
            $user->forceFill(['phone_verified_at' => now()])->save();
        }

        Auth::login($user, (bool) ($challenge['remember'] ?? false));
        $request->session()->forget('auth.otp');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
