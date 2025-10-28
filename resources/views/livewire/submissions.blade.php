<div class="grid gap-6 md:grid-cols-[60%_1fr]">
    <div class="rounded-[2rem] bg-white p-8 max-md:order-2">
        <h2 class="text-cedea-blue text-2xl font-bold">Riwayat Struk Undian Saya</h2>

        <hr class="my-4 h-1 bg-gray-400/50" />

        <div class="flex flex-col gap-4">
            @forelse($userSubmissions as $submission)
                <x-dashboard.receipt-item :submission="$submission" />
            @empty
                <p>Belum ada riwayat undian</p>
            @endforelse

            {{ $userSubmissions->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    <div class="order-1 flex cursor-pointer flex-col gap-4 text-white"
        wire:click="$dispatch('openModal', { component: 'upload-form' })">
        <div class="flex h-full flex-col items-center justify-center rounded-[2rem] bg-white p-8 text-center">
            <img class="text-cedea-red max-w-1/6" src="{{ asset('img/receipt-up.svg') }}" />
            <p class="text-cedea-red text-4xl">
                Upload foto struk disini
            </p>
        </div>

        <div class="text-center">
            <p>silahkan lampirkan</p>
            <p class="font-bold">maksimal 1 struk pembelian (Max 5 MB/struk)</p>
        </div>
    </div>
</div>
