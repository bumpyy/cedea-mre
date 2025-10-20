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
        <button type="submit">Submit</button>
    </form>
    @if (session()->has('submission-error'))
        <div class="mt-4 text-red-600">
            <p>{{ session()->get('submission-error') }}</p>
        </div>
    @endif
</div>
