<?php

namespace App\Livewire\Auth;

use App\Models\User; // Pastikan Model User diimport
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class ResetPassword extends Component
{
    #[Locked]
    public string $token = '';

    public string $emailOrPhone = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        // Tangkap query ?email=... atau ?phone=...
        // Prioritaskan 'email', jika tidak ada ambil 'phone', jika tidak ada string kosong.
        $this->emailOrPhone = request()->query('email', request()->query('phone', ''));
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'emailOrPhone' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $isEmail = isEmail($this->emailOrPhone);
        $userColumn = $isEmail ? 'email' : 'phone_formatted';

        $user = User::where($userColumn, $this->emailOrPhone)->first();

        if (! $user) {
            $this->addError('emailOrPhone', __('passwords.user'));

            return;
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $this->emailOrPhone)
            ->first();

        if (! $record || ! Hash::check($this->token, $record->token)) {
            $this->addError('emailOrPhone', __('passwords.token'));

            return;
        }

        $user->forceFill([
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $this->emailOrPhone)->delete();

        event(new PasswordReset($user));

        Session::flash('status', __('passwords.reset'));

        redirect()->route('login');
    }
}
