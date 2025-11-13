<?php

namespace App\Livewire;

use App\Models\Submission;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class ViewSubmission extends ModalComponent
{
    public $submission;

    public function mount($uuid)
    {
        try {
            $this->submission = Submission::where('user_id', auth()->id())
                ->where('uuid', $uuid)
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error($e->getMessage(), [
                'submission_id' => $uuid,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('dashboard')->with('error', 'Submission not found');
        }
    }

    public function render()
    {
        return view('livewire.view-submission', [
            'submission' => $this->submission,
        ]);
    }
}
