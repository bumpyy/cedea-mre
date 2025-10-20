<?php

namespace App\Livewire;

use App\Enum\SubmissionStatusEnum;
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
        try {
            $submission = auth()->user()->submissions()->create([
                'status' => SubmissionStatusEnum::PENDING,
            ]);

            $this->file->store('submissions', 'public');

            $media = $submission->addMedia($this->file->getPathname())
                ->toMediaCollection('submissions');

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
