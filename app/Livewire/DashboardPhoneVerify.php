<?php

namespace App\Livewire;

use App\Events\PhoneVerified;
use App\Exceptions\WhatsAppException;
use App\Services\QiscusService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;

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
        $this->resendOtp();
    }

    /**
     * Send or resend the OTP.
     */
    public function resendOtp(): void
    {
        if (Auth::user()->hasVerifiedPhone()) {
            $this->showOtpForm = false;
            redirect()->intended(default: route('dashboard', absolute: false));

            return;
        }

        try {
            $otp = auth()->user()->createOneTimePassword();
            app(QiscusService::class)->sendOtp(auth()->user(), $otp->password);
            $this->dispatch('otp-sent');
        } catch (WhatsAppException $e) {
            // Catch the *specific* exception from our service
            Log::warning('Qiscus API failure: '.$e->getMessage());
            throw ValidationException::withMessages([
                'one_time_password' => $e->getMessage(), // Show the user-friendly message
            ]);

        } catch (\Exception $e) {
            // Catch any other *unexpected* errors
            Log::error('Unexpected error sending OTP: '.$e->getMessage());
            throw ValidationException::withMessages([
                'one_time_password' => 'An unexpected error occurred. Please try again.',
            ]);
        }
    }

    public function verifyOtp($otp = null): void
    {
        $code = $otp ?? $this->otpCode;

        if (empty($code) || strlen($code) < 6) {
            Log::warning('Wrong OTP: '.$code);

            throw ValidationException::withMessages([
                'one_time_password' => 'Kode OTP wajib diisi.',
            ]);
        }

        $user = auth()->user();
        $result = $user->consumeOneTimePassword($code);

        if ($result->isOk()) {
            Log::info('User verified phone: '.$user->phone);
            $this->showOtpForm = false;
            $user->markPhoneAsVerified();
            $this->reset('otpCode'); // Clean up
            event(new PhoneVerified(auth()->user()));

            redirect()->intended(route('dashboard', absolute: false).'?verified=1');

            return;
        }

        Log::warning('Wrong OTP: '.$result->validationMessage());
        throw ValidationException::withMessages([
            'one_time_password' => $result->validationMessage(),
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard-phone-verify');
    }
}
