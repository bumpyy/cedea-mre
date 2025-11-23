<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ProfileInfoDisplay extends Component
{
    public $showToast = false;

    #[On('profileUpdated')]
    public function refreshPost()
    {
        $this->showToast = true;
        // refresh component
    }

    public function render()
    {
        // View ini akan mereload data user dari DB setiap kali di-refresh
        return view('livewire.profile-info-display', [
            'user' => auth()->user(),
        ]);
    }
}
