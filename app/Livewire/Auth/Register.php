<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\IndonesianPhoneNumber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public $email;

    public string $address = '';

    public $phone;

    #[Locked]
    public string $phone_formatted;

    public string $password = '';

    public string $password_confirmation = '';

    public bool $accept_terms = false;

    protected $messages = [
        'name.required' => 'Nama lengkap harus diisi.',
        'email.unique' => 'Alamat email sudah terdaftar.',
        'email.email' => 'Alamat email tidak valid.',
        'email.required' => 'Alamat email atau nomor handphone harus diisi.',
        'phone_formatted.required' => 'Alamat email atau nomor handphone harus diisi.',
        'phone_formatted.unique' => 'Nomor handphone sudah terdaftar.',
        'password.confirmed' => 'Kata sandi tidak cocok.',
        'accept_terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
    ];

    protected $validationAttributes = [
        'name' => 'Nama lengkap',
        'phone_formatted' => 'Nomor handphone',
        'address' => 'Alamat',
        'email' => 'Alamat email',
        'accept_terms' => 'Syarat & Ketentuan',
    ];

    #[On('accept-terms')]
    public function acceptTerms(): void
    {
        $this->accept_terms = true;
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        if (! $this->accept_terms) {
            $this->dispatch('openModal', component: 'terms-list');

            return;
        }

        $baseRule = [
            'name' => ['required', 'string', 'max:255'],

            'address' => ['string', 'max:255'],

            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'accept_terms' => ['required', 'accepted'],
        ];

        $phoneRule = ['required', 'string', 'unique:'.User::class, new IndonesianPhoneNumber];
        $emailRule = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];

        // if (! $this->email) {
        //     $baseRule = [
        //         ...$baseRule,
        //         'phone' => $phoneRule,
        //     ];
        //     $this->email = null;
        // }

        // if (! $this->phone) {
        //     $baseRule = [
        //         ...$baseRule,
        //         'email' => $emailRule,
        //     ];

        //     $this->phone = null;
        // }

        // if ($this->email && $this->phone) {
        //     $baseRule = [
        //         ...$baseRule,
        //         'email' => $emailRule,
        //         'phone' => $phoneRule,
        //     ];
        // }

        $baseRule = [
            ...$baseRule,
            'email' => $emailRule,
            'phone_formatted' => $phoneRule,
        ];

        $this->phone_formatted = formatPhoneNumber($this->phone);

        $validated = $this->validate([
            ...$baseRule,
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['phone'] = $this->phone;

        if ($this->email) {
            event(new Registered(($user = User::create($validated))));
        } else {
            $user = User::create($validated);
        }

        Auth::login($user);

        Session::regenerate();

        redirect(route('dashboard', absolute: false));
    }
}
