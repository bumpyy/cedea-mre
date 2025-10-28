<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Submissions extends Component
{
    use WithPagination;

    #[On('submission-created')]
    public function refreshSubmissions()
    {
        // When a new submission is created, we reset the page number
        // to ensure the user sees the new item on page 1.
        $this->resetPage();

        // Livewire automatically re-runs the render() method after this call.
    }

    public function render()
    {
        return view('livewire.submissions', [
            'userSubmissions' => auth()->user()->submissions()->latest()->paginate(3),
        ]);
    }
}
