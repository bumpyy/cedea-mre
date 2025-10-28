<?php

namespace App\Livewire;

use App\Models\Submission;
use LivewireUI\Modal\ModalComponent;

class ViewSubmission extends ModalComponent
{
    public function mount($id)
    {
        try {
            $this->submission = Submission::where('user_id', auth()->id())->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return redirect()->route('submissions.index')->with('error', 'Submission not found');
        }
    }

    public function render()
    {
        return view('livewire.view-submission', [
            'submission' => $this->submission,
        ]);
    }
}
