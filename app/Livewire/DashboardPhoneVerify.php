<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Spatie\OneTimePasswords\Enums\ConsumeOneTimePasswordResult;

class DashboardPhoneVerify extends Component
{
    #[Locked]
    public bool $showOtpForm = false;

    public string $otpCode = '';

    public function resetForm(): void
    {
        $this->reset();
    }

    public function handleShowOtpForm(): void
    {
        $this->showOtpForm = true;
        $this->sendOtp();
    }

    public function sendOtp(): void
    {
        $this->resendOtp();
    }

    public function resendOtp(): void
    {

        if (Auth::user()->hasVerifiedPhone()) {
            $this->showOtpForm = false;
            redirect()->intended(default: route('dashboard', absolute: false));

            return;
        }

        // TODO: Handle whatsapp api to send otp
        auth()->user()->createOneTimePassword();
    }

    public function verifyOtp(): void
    {
        if (env('MOCK_PHONE_OTP', false)) {
            $result = $this->otpCode == '482915' ? ConsumeOneTimePasswordResult::Ok : ConsumeOneTimePasswordResult::IncorrectOneTimePassword;
        } else {
            $result = Auth::user()->consumeOneTimePassword($this->otpCode);
        }

        if ($result->isOk()) {
            $this->showOtpForm = false;
            Auth::user()->markPhoneAsVerified();
            redirect()->intended(default: route('dashboard', absolute: false));
        }

        throw ValidationException::withMessages([
            'one_time_password' => $result->validationMessage(),
        ]);

    }

    public function render()
    {
        return view('livewire.dashboard-phone-verify');
    }
}
