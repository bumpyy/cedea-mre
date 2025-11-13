<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class TermsList extends ModalComponent
{
    public function acceptTerms(): void
    {
        $this->closeModalWithEvents([
            \App\Livewire\Auth\Register::class => 'accept-terms',
        ]);
    }

    public function render()
    {
        return view('components.terms-list', [
            'register' => true,
        ]);
    }
}
