<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        if (auth()->user()->isDisqualified()) {
            $this->addError('file', 'Anda telah didisqualifikasi');

            return;
        }

        if (! auth()->user()->isVerified()) {
            $this->addError('file', 'Verifikasi Akun Dulu');

            return;
        }

        if ($this->file) {

            if (! file_exists($this->file->getRealPath())) {
                $this->addError('file', 'File kadaluarsa atau tidak ditemukan. Silakan upload ulang.');

                Log::warning('File Submission Failed', [
                    'message' => 'File kadaluarsa atau tidak ditemukan.',
                    'file' => $this->file ? $this->file->getRealPath() : null,
                ]);

                return;
            }

            DB::beginTransaction();

            try {

                $submission = auth()->user()->submissions()->create();

                $submission->addMedia($this->file)
                    ->toMediaCollection('submissions');

                DB::commit();

                Log::info('File Submission Success', [
                    'message' => 'File uploaded successfully.',
                    'user_id' => auth()->id(),
                    'file_name' => $this->file->getClientOriginalName() ?? 'N/A',
                ]);

                $this->reset('file');

                $this->closeModalWithEvents([
                    Submissions::class => 'submission-created',
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();

                Log::error('File Submission Error', [
                    'message' => 'An error occurred while uploading the file.',
                    'exception_message' => $th->getMessage(), // Detailed error message
                    'stack_trace' => $th->getTraceAsString(), // Full stack trace (very useful for debugging)
                    'user_id' => auth()->id(), // Contextual information
                    'file_name' => $this->file->getClientOriginalName() ?? 'N/A',
                ]);

                $this->addError('file', 'Gagal upload submission, coba lagi nanti.');
            }
        } else {
            $this->addError('file', 'Upload dulu');
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
