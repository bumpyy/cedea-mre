<?php

namespace App\Livewire;

use App\Enum\SubmissionStatusEnum;
use App\Models\Submission;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Spatie\LivewireFilepond\WithFilePond;

class UploadForm extends ModalComponent
{
    use WithFilePond;

    public $file;

    public function rules(): array
    {
        return [
            'file' => 'required|mimetypes:image/jpg,image/jpeg,image/png|max:5000',
        ];
    }

    public function validateUploadedFile()
    {
        $this->validate();

        return true;
    }

    public function submit(): void
    {
        $this->validate();

        try {
            $submission = auth()->user()->submissions()->create([
                'status' => SubmissionStatusEnum::PENDING,
                'uuid' => (function () {
                    $uuid = Str::uuid();
                    while (Submission::where('uuid', $uuid)->exists()) {
                        $uuid = Str::uuid();
                    }

                    return $uuid;
                })(),
            ]);

            $submission->addMedia($this->file->getPathname())
                ->toMediaCollection('submissions');

            $this->reset('file');

            $this->closeModalWithEvents([
                Submissions::class => 'submission-created',
            ]);

        } catch (\Throwable $th) {
            $this->addError('file', 'An error occurred while uploading the file: '.$th->getMessage());
        }

    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.upload-form');
    }
}
