<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\OtpService;
use App\Support\PhoneNumber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisteredUserController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService
    ) {}

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $phone = PhoneNumber::toE164($request->string('phone')->toString());

        if (User::query()->where('phone', $phone)->exists()) {
            throw ValidationException::withMessages([
                'phone' => 'يوجد مستخدم مسجل بهذا الرقم بالفعل.',
            ]);
        }

        try {
            $otp = $this->otpService->generateAndStore($phone, 'registration');
        } catch (HttpException $e) {
            throw ValidationException::withMessages([
                'phone' => $e->getMessage(),
            ]);
        }

        $request->session()->put('auth.otp', [
            'purpose' => 'registration',
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->lower()->toString(),
            'phone' => $phone,
            'password' => Hash::make($request->string('password')->toString()),
        ]);

        $status = 'تم إرسال كود التحقق إلى هاتفك.';
        if (config('services.sms.otp_debug')) {
            $status .= " الكود: {$otp}";
        }

        return redirect()->route('otp.show')->with('status', $status);
    }
}
