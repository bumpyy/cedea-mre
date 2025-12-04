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

    <div class="order-1 flex flex-col gap-4 text-white">
        <div @if (auth()->user()->isVerified()) x-data="{ showRefreshText: false }" x-effect="if (showRefreshText) setTimeout(function() {showRefreshText = false}, 5000)" @click="showRefreshText = true"
            wire:click="$dispatch('openModal', { component: 'upload-form' })" @endif
            @class([
                'flex h-full flex-col  items-center justify-center rounded-2xl bg-white p-4 text-center md:rounded-4xl md:p-8',
                'grayscale' => !auth()->user()->isVerified(),
                'cursor-pointer' => auth()->user()->isVerified(),
            ])>

            <img class="text-cedea-red max-w-1/6" src="{{ asset('img/receipt-up.svg') }}" />
            <div @class([
                'text-cedea-red font-montserrat text-xl font-bold md:w-2/3 md:text-3xl',
            ])>
                @if (auth()->user()->isVerified())
                    <div class="flex flex-col gap-1">
                        <p>Upload foto struk disini</p>
                        <div class="flex flex-col gap-1 text-sm text-gray-500">
                            <p>Click/tap untuk membuka form upload</p>
                            <p class="text-xs text-slate-500/70" x-show="showRefreshText">
                                Coba refresh browser jika form tidak muncul
                            </p>
                        </div>
                    </div>
                    <div class="mx-auto mb-2 mt-2 w-fit rounded-full bg-green-400 px-3 py-1 text-base text-white opacity-70"
                        x-data="{ submissionSubmitted: @entangle('submissionSubmitted') }"
                        x-effect="if (submissionSubmitted) setTimeout(function() {submissionSubmitted = false}, 5000)"
                        x-on:profile-updated="submissionSubmitted = true"
                        x-show.transition.duration.300ms="submissionSubmitted" x-cloak>
                        Submission berhasil diupload
                    </div>
                @else
                    <p>Harap verifikasi akun Anda terlebih dahulu</p>
                @endif
            </div>
        </div>

        <div class="text-center">
            <p>silahkan lampirkan</p>
            <p class="font-bold">maksimal 1 struk pembelian (Max 5 MB/struk) per submission</p>
            <p class="clamp-[text,xs,sm] font-bold">Upload banyak struk untuk kesempatan menang lebih besar</p>
        </div>
    </div>
</div>
