<div class="flex flex-col rounded-[2rem] bg-white p-8">
    <div class="text-cedea-red mb-8 flex flex-col text-center text-xl">
        <h2>Silahkan lampirkan</h2>
        <p class="font-bold">maksimal 1 struk pembelian (Max 5MB/struk)</p>
        @error('file')
            <p class="mt-2 text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <form method="POST" wire:submit="submit">
        <x-filepond::upload required wire:model="file" />


        <div class="flex items-center justify-center">
            <flux:button class="w-fit bg-amber-400 !px-8" data-test="submit-button" variant="primary" type="submit">
                Submit
            </flux:button>
        </div>
    </form>
    @if (session()->has('submission-error'))
        <div class="mt-4 text-red-600">
            <p>{{ session()->get('submission-error') }}</p>
        </div>
    @endif
</div>
