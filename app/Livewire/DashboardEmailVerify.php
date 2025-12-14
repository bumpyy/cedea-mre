<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DashboardEmailVerify extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            redirect()->intended(default: route('dashboard', absolute: false));

            return;
        }

        $this->resetErrorBag();

        try {
            Auth::user()->sendEmailVerificationNotification();

            Session::flash('status', 'verification-link-sent');
        } catch (\Exception $e) {
            Log::error('Unexpected error sending email verification: '.$e->getMessage());
            throw ValidationException::withMessages([
                'email_not_sent' => 'Gagal mengirim email, Coba lagi nanti', // Show the user-friendly message
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard-email-verify');
    }
}
