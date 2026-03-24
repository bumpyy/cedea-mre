<?php

namespace App\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Submissions extends Component
{
    use WithPagination;

    public $submissionSubmitted = false;

    #[Locked]
    public $is_campaign_end = false;

    #[On('submission-created')]
    public function refreshSubmissions()
    {
        // When a new submission is created, we reset the page number
        // to ensure the user sees the new item on page 1.

        $this->resetPage();
        $this->submissionSubmitted = true;

        // Livewire automatically re-runs the render() method after this call.
    }

    public function mount()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $campaign_end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2026-03-25 00:00:00', 'Asia/Jakarta');

        if ($now->gte($campaign_end_date)) {
            return $this->is_campaign_end = true;
        }

        if (auth()->user()->isVerified() && ! auth()->user()->isDisqualified()) {
            if (request()->query('verified') === '1') {
                $this->dispatch('openModal', component: 'upload-form');
            }
        }
    }

    public function render()
    {
        return view('livewire.submissions', [
            'userSubmissions' => auth()->user()->submissions()->latest()->paginate(3),
        ]);
    }
}
