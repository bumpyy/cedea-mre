<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        $otp = auth()->user()->createOneTimePassword();

        // TODO: Handle whatsapp api to send otp
        // TODO: clean up
        try {
            $response = Http::withHeaders([
                'Qiscus-App-Id' => config('qiscus.app_id'),
                'Qiscus-Secret-Key' => config('qiscus.secret_key'),
            ])->post(config('qiscus.base_url').'/whatsapp/v1/'.config('qiscus.app_id').'/'.config('qiscus.channel_id').'/messages', [
                'to' => auth()->user()->phone,
                'type' => 'template',
                'template' => [
                    'namespace' => config('qiscus.otp_namespace'),
                    'name' => config('qiscus.otp_template_name'),
                    'language' => [
                        'policy' => 'deterministic',
                        'code' => 'id',
                    ],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $otp->password,
                                ],
                            ],
                        ],
                        [
                            'type' => 'button',
                            'sub_type' => 'url',
                            'index' => '0',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $otp->password,
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            if (! $response->successful()) {
                Log::error($response->status().': '.$response->body());
                throw ValidationException::withMessages([
                    'one_time_password' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw ValidationException::withMessages([
                'one_time_password' => $e->getMessage(),
            ]);
        }
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
