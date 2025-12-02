<div class="text-cedea-red rounded-4xl flex flex-col bg-white p-4 text-center text-xl md:p-8">
    @if (auth()->user()->isVerified())
        <form wire:submit="submit">
            <x-filepond::upload required wire:model="file" max-file-size="5MB" :accepted-file-types="['image/png', 'image/jpeg', 'image/jpg']" />

            <div class="flex flex-col items-center justify-center">
                @if ($file)
                    <flux:button class="px-8! w-fit bg-amber-400" data-test="submit-button" variant="primary"
                        type="submit">
                        Submit
                    </flux:button>
                @endif
                <flux:error class="" name="file" />
            </div>
        </form>
    @else
        Harap verifikasi akun anda terlebih dahulu
    @endif
</div>
