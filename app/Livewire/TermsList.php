<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class TermsList extends ModalComponent
{
    public function acceptTerms(): void
    {
        // $this->closeModalWithEvents([
        //     \App\Livewire\Auth\Register::class => 'accept-terms',
        // ]);

        $this->dispatch('close-modal', id: 'terms');
        $this->dispatch('accept-terms')->to(\App\Livewire\Auth\Register::class);
    }

    public function render()
    {
        return view('components.terms-list', [
            'register' => true,
        ]);
    }
}
