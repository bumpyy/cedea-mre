<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $address = '';

    public string $phone = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $accept_terms = false;

    protected $messages = [
        'name.required' => 'Nama lengkap harus diisi.',
        'email.unique' => 'Alamat email sudah terdaftar.',
        'email.email' => 'Alamat email tidak valid.',
        'email.required' => 'Alamat email atau nomor handphone harus diisi.',
        'phone.required' => 'Alamat email atau nomor handphone harus diisi.',
        'phone.unique' => 'Nomor handphone sudah terdaftar.',
        'password.confirmed' => 'Kata sandi tidak cocok.',
        'accept_terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
    ];

    protected $validationAttributes = [
        'name' => 'Nama lengkap',
        'phone' => 'Nomor handphone',
        'address' => 'Alamat',
        'email' => 'Alamat email',
        'accept_terms' => 'Syarat & Ketentuan',
    ];

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $baseRule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'address' => ['string', 'max:255'],
            'phone' => ['string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'accept_terms' => ['required', 'accepted'],
        ];

        if (! $this->email) {
            $baseRule = [
                ...$baseRule,
                'phone' => ['required', 'string', 'max:255'],
            ];
        }

        if (! $this->phone) {
            $baseRule = [
                ...$baseRule,
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ];
        }

        $validated = $this->validate([
            ...$baseRule,
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // event(new Registered(($user = User::create($validated))));
        $user = User::create($validated);

        Auth::login($user);

        Session::regenerate();

        redirect(route('dashboard', absolute: false));
    }
}
