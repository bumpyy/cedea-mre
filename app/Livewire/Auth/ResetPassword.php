<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component; // Don't forget this import

#[Layout('components.layouts.auth')]
class ResetPassword extends Component
{
    #[Locked]
    public string $token = '';

    public string $emailOrPhone = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->emailOrPhone = request()->query('email', request()->query('phone', ''));
    }

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

        $expiration = config('auth.passwords.users.expire', 60);
        if (Carbon::parse($record->created_at)->addMinutes($expiration)->isPast()) {
            $this->addError('emailOrPhone', __('passwords.token'));

            return;
        }

        $user->forceFill([
            'password' => $this->password,
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $this->emailOrPhone)->delete();

        event(new PasswordReset($user));

        Session::flash('status', __('passwords.reset'));

        redirect()->route('login');
    }
}
