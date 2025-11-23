<div class="rounded-4xl flex flex-col bg-white p-4 md:p-8" class="text-cedea-red mb-8 flex flex-col text-center text-xl"
    x-data="{ uploaded: false, uploading: false }" x-on:filepond-upload-started="uploading = true"
    x-on:filepond-upload-completed="
        uploading = false;
        uploaded = true;
    "
    x-on:filepond-upload-reverted="
    uploading = false;
    uploaded = false;
    "
    x-on:filepond-upload-file-removed="
    uploading = false;
    uploaded = false;
    ">


    @if (auth()->user()->isVerified())
        <form method="POST" wire:submit="submit">
            <x-filepond::upload required wire:model="file" :credits="false" max-file-size="5MB" :accepted-file-types="['image/png', 'image/jpeg', 'image/jpg']" />

            <div class="flex flex-col items-center justify-center">
                <flux:button class="px-8! w-fit bg-amber-400" data-test="submit-button" x-bind:loading="uploading"
                    variant="primary" type="submit">
                    Submit
                </flux:button>
                <flux:error class="" name="file" />
            </div>
        </form>
    @else
        Harap verifikasi akun anda terlebih dahulu
    @endif


    @if (session()->has('submission-error'))
        <div class="mt-4 text-red-600">
            <p>{{ session()->get('submission-error') }}</p>
        </div>
    @endif
</div>
