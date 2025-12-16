<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\ResetPasswordRequest;
use App\Rules\IndonesianPhoneNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class ForgotPassword extends Component
{
    public string $emailOrPhone = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'emailOrPhone' => ['required', 'string', isEmail($this->emailOrPhone) ? 'email' : new IndonesianPhoneNumber],
        ]);

        $inputType = isEmail($this->emailOrPhone) ? 'email' : 'phone_formatted';
        $identifier = isEmail($this->emailOrPhone) ? $this->emailOrPhone : formatPhoneNumber($this->emailOrPhone);
        $user = User::where($inputType, isEmail($this->emailOrPhone) ? $this->emailOrPhone : formatPhoneNumber($this->emailOrPhone))->first();

        if (! $user) {
            $this->addError('input', 'User tidak ditemukan.');

            return;
        }

        DB::table('password_reset_tokens')->whereIn('email', [
            $user->email,
            $user->phone_formatted,
        ])->delete();

        $tokenRaw = Str::random(40);
        $tokenHash = Hash::make($tokenRaw);

        DB::table('password_reset_tokens')->insert([
            'email' => $identifier,
            'token' => $tokenHash,
            'created_at' => now(),
        ]);

        $channel = $inputType === 'email' ? 'email' : 'whatsapp';

        try {
            $user->notify(new ResetPasswordRequest($tokenRaw, $channel, $identifier));
            session()->flash('status', "Link reset telah dikirim ke {$channel} Anda.");
        } catch (\Throwable $e) {
            Log::error("Mail Error for {$identifier}: ".$e->getMessage());
            $this->addError('emailOrPhone', 'Gagal mengirim link reset kata sandi. Silakan coba lagi.');

        }

    }
}
