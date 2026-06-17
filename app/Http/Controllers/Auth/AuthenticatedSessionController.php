<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService
    ) {}

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = $request->user();

        if ($user?->isClient()) {
            if (! $user->phone) {
                Auth::guard('web')->logout();

                throw ValidationException::withMessages([
                    'email' => 'This client account needs a phone number before OTP login can be used.',
                ]);
            }

            try {
                $otp = $this->otpService->generateAndStore($user->phone, 'login');
            } catch (HttpException $e) {
                Auth::guard('web')->logout();

                throw ValidationException::withMessages([
                    'email' => $e->getMessage(),
                ]);
            }

            Auth::guard('web')->logout();

            $request->session()->put('auth.otp', [
                'purpose' => 'login',
                'user_id' => $user->id,
                'phone' => $user->phone,
                'remember' => $request->boolean('remember'),
            ]);

            $status = 'OTP sent to your phone.';
            if (config('services.sms.otp_debug')) {
                $status .= " Code: {$otp}";
            }

            return redirect()->route('otp.show')->with('status', $status);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
