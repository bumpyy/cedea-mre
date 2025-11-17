<?php

namespace App\Livewire;

use App\Models\User;
use App\Rules\IndonesianPhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserProfileDashboard extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public array $social = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->address = Auth::user()->address;
        $this->social = Auth::user()->social;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:190'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:190',
                Rule::unique(User::class)->ignore($user->id),
            ],

            'phone' => ['required', 'string', 'max:190', new IndonesianPhoneNumber],
            'address' => ['required', 'string', 'max:190'],

            'social' => ['array'],

        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function render()
    {
        return view('livewire.user-profile-dashboard');
    }
}
