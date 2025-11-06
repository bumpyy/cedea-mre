<div class="grid gap-6 md:grid-cols-[60%_1fr]">
    <div class="md:rounded-4xl rounded-2xl bg-white p-4 max-md:order-2 md:p-8">
        <h2 class="text-cedea-blue text-xl font-bold md:text-2xl">Riwayat Struk Undian Saya</h2>

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
        @if (auth()->user()->isVerified()) wire:click="$dispatch('openModal', { component: 'upload-form' })" @endif>
        <div @class([
            'flex h-full flex-col items-center justify-center rounded-2xl bg-white p-4 text-center md:rounded-4xl md:p-8',
            'grayscale' => !auth()->user()->isVerified(),
        ])>
            <img class="text-cedea-red max-w-1/6" src="{{ asset('img/receipt-up.svg') }}" />
            <p @class([
                'text-cedea-red font-montserrat text-xl font-bold md:w-2/3 md:text-3xl',
            ])>
                @if (auth()->user()->isVerified())
                    Upload foto struk disini
                @else
                    Harap verifikasi akun Anda terlebih dahulu
                @endif
            </p>
        </div>

        <div class="text-center">
            <p>silahkan lampirkan</p>
            <p class="font-bold">maksimal 1 struk pembelian (Max 5 MB/struk)</p>
        </div>
    </div>
</div>
