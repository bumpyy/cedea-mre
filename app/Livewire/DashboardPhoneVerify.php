<?php

namespace App\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Component;

class DashboardPhoneVerify extends Component
{
    #[Locked]
    public bool $openOtpForm = false;

    #[Locked]
    public string $otpCode = '';

    public function sendOtp(): void
    {
        auth()->user()->createOneTimePassword();
    }

    public function resendOtp(): void
    {
        auth()->user()->sendOneTimePassword();
    }

    public function render()
    {
        return view('livewire.dashboard-phone-verify');
    }
}
