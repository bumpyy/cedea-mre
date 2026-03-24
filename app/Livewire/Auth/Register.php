<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\IndonesianPhoneNumber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    #[Locked]
    public $is_campaign_end = false;

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
        'email.required' => 'Alamat email atau nomor WhatsApp harus diisi.',
        'phone_formatted.required' => 'Alamat email atau nomor WhatsApp harus diisi.',
        'phone_formatted.unique' => 'Nomor WhatsApp sudah terdaftar.',
        'password.confirmed' => 'Kata sandi tidak cocok.',
        'accept_terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
    ];

    protected $validationAttributes = [
        'name' => 'Nama lengkap',
        'phone_formatted' => 'Nomor WhatsApp',
        'address' => 'Alamat',
        'email' => 'Alamat email',
        'accept_terms' => 'Syarat & Ketentuan',
    ];

    #[On('accept-terms')]
    public function acceptTerms(): void
    {
        $this->accept_terms = true;
    }

    public function showTermsModal(): void
    {
        $this->dispatch('open-modal', id: 'terms');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {

        if ($this->is_campaign_end) {
            $this->reset();

            return;
        }

        if (! $this->accept_terms) {
            $this->showTermsModal();

            return;
        }

        $baseRule = [
            'name' => ['required', 'string', 'max:190'],

            'address' => ['string', 'max:190'],

            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'accept_terms' => ['required', 'accepted'],
        ];

        $phoneRule = ['required', 'string', 'unique:'.User::class, new IndonesianPhoneNumber];
        $emailRule = ['required', 'string', 'lowercase', 'email', 'max:190', 'unique:'.User::class];

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

        if (! is_null($this->phone)) {
            $this->phone_formatted = formatPhoneNumber($this->phone);
        }

        $validated = $this->validate([
            ...$baseRule,
        ]);

        // $validated['password'] = Hash::make($validated['password']);
        $validated['phone'] = $this->phone;

        $user = User::create($validated);

        // try {
        //     event(new Registered($user));
        // } catch (\Throwable $e) {
        //     Log::error('Registration email failed: '.$e->getMessage());
        //     // session()->flash('warning', 'Account created, but verification email could not be sent.');
        // }

        Auth::login($user);

        Session::regenerate();

        redirect(route('dashboard', absolute: false));
    }

    public function mount()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $campaign_end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2026-03-25 00:00:00', 'Asia/Jakarta');
        $this->is_campaign_end = false;

        if ($now->gte($campaign_end_date)) {
            return $this->is_campaign_end = true;
        }
    }

    public function render()
    {

        if ($this->is_campaign_end) {
            return view('livewire.auth.register-closed');
        }

        return view('livewire.auth.register');

    }
}
