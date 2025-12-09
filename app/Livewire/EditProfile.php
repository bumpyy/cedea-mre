<?php

namespace App\Livewire;

use App\Rules\IndonesianPhoneNumber;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class EditProfile extends Component
{
    // public $name;

    // public $email;

    // public $phone;

    // #[Locked]
    // public $phone_formatted;

    public $address;

    public $social = [];

    public $current_password = '';

    public $new_password = '';

    public $new_password_confirmation = '';

    protected $messages = [
        // 'phone.required' => 'Nomor WhatsApp wajib diisi.',
        // 'phone.max' => 'Nomor WhatsApp tidak boleh lebih dari 15 karakter.',
        // 'name.required' => 'Nama lengkap harus diisi.',
        // 'email.unique' => 'Alamat email sudah terdaftar.',
        // 'email.email' => 'Alamat email tidak valid.',
        // 'email.required' => 'Alamat email atau nomor WhatsApp harus diisi.',
        // 'phone_formatted.required' => 'Alamat email atau nomor WhatsApp harus diisi.',
        // 'phone_formatted.unique' => 'Nomor WhatsApp sudah terdaftar.',
        'new_password.confirmed' => 'Kata sandi tidak cocok.',
    ];

    public function mount()
    {
        $user = auth()->user();

        // $this->name = $user->name;
        // $this->email = $user->email;
        // $this->phone = $user->phone;

        $this->address = $user->address;

        $socialData = $user->social ?? [];

        $this->social = [
            'x' => $socialData['x'] ?? '',
            'tiktok' => $socialData['tiktok'] ?? '',
            'instagram' => $socialData['instagram'] ?? '',
            'facebook' => $socialData['facebook'] ?? '',
        ];
    }

    public function save()
    {
        $user = auth()->user();

        $passwordChanged = ! empty($this->new_password);

        // 1. Validasi
        $rules = [
            // 'name' => ['required', 'string', 'max:191'],
            // 'email' => ['required', 'email', 'max:191', Rule::unique('users')->ignore($user->id)],
            // Menggunakan Rule kustom
            // 'phone_formatted' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($user->id), new IndonesianPhoneNumber],

            'address' => ['nullable', 'string', 'max:191'],
            'social.x' => ['nullable', 'string', 'max:100'],
            'social.tiktok' => ['nullable', 'string', 'max:100'],
            'social.instagram' => ['nullable', 'string', 'max:100'],
            'social.facebook' => ['nullable', 'string', 'max:100'],
        ];
        if ($passwordChanged) {
            $rules['current_password'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (! Hash::check($value, $user->password)) {
                    $fail('Kata Sandi Lama salah.');
                }
            }];

            $rules['new_password'] = ['required', 'min:8', 'confirmed'];
            $rules['new_password_confirmation'] = ['required_with:new_password'];
        }

        $this->validate($rules);
        // $this->phone_formatted = formatPhoneNumber($this->phone);

        // $phoneChanged = ($user->phone_formatted !== $this->phone_formatted);
        // $emailChanged = ($user->email !== $this->email);

        // $user->name = $this->name;
        // $user->email = $this->email;

        $user->address = $this->address;
        $user->social = $this->social;

        // $user->phone = $this->phone;

        // if ($emailChanged) {
        //     $user->email_verified_at = null;
        // }

        // if ($phoneChanged) {
        //     $user->phone_verified_at = null;
        // }

        if ($passwordChanged) {
            $user->password = Hash::make($this->new_password);
        }

        $user->save();

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        Flux::modal('edit-profile')->close();
        $this->dispatch('profileUpdated');
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }
}
