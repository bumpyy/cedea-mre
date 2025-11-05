<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string')]
    public string $emailOrPhone = '';

    #[Validate('string')]
    public string $password = '';

    public ?User $user;

    public bool $remember = false;

    #[Locked]
    public bool $showOtpForm = false;

    #[Locked]
    public bool $usingPhone = false;

    public string $otpCode;

    public function login(): void
    {
        if ($this->showOtpForm) {
            $this->loginOtp($this->otpCode);

            return;
        }

        if ($this->password) {
            $this->loginPassword();

            return;
        }

        $this->user = User::where('email', $this->emailOrPhone)->orWhere('phone', $this->emailOrPhone)->first();

        if (! $this->user) {
            throw ValidationException::withMessages([
                'emailOrPhone' => __('auth.failed'),
            ]);
        }

        if (isEmail($this->emailOrPhone)) {
            $this->usingPhone = false;
            $this->user->sendOneTimePassword();
        } else {
            $this->usingPhone = true;
        }

        $this->showOtpForm = true;
    }

    public function resendOtp(): void
    {
        $this->user->sendOneTimePassword();
    }

    private function toggleShowOtpForm(): void
    {
        $this->showOtpForm = ! $this->showOtpForm;
    }

    private function toggleUsingPhone(): void
    {
        $this->usingPhone = ! $this->usingPhone;
    }

    public function resetForm(): void
    {
        $this->reset();
    }

    /**
     * Handle an incoming authentication request.
     */
    private function loginPassword(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
            ]);

            redirect(route('two-factor.login'));

            return;
        }

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Handle an incoming authentication request.
     */
    private function loginOtp($oneTimePassword): void
    {
        $this->ensureIsNotRateLimited();

        $result = $this->user->attemptLoginUsingOneTimePassword($oneTimePassword, remember: $this->remember);

        if ($result->isOk()) {
            // it is best practice to regenerate the session id after a login
            Session::regenerate();

            redirect()->intended(route('dashboard', absolute: false));
        }

        throw ValidationException::withMessages([
            'one_time_password' => $result->validationMessage(),
        ]);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        if (filter_var($this->emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $this->emailOrPhone];
        } else {
            $credentials = ['phone' => $this->emailOrPhone];
        }

        $user = Auth::getProvider()->retrieveByCredentials([...$credentials, 'password' => $this->password]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'emailOrPhone' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'emailOrPhone' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->emailOrPhone).'|'.request()->ip());
    }
}
