<x-layouts.app>
    <section class="container -mt-12 flex flex-col gap-y-12 pb-32">

        <div class="-ml-[7%] mb-4 md:mb-20">
            <img src="{{ asset('img/final/headline-header2x.png') }}" alt="">
        </div>

        <div class="max-md:grid-overlay md:rounded-4xl relative grid rounded-2xl bg-white md:grid-cols-2">

            <div class="z-1 flex flex-col p-6 text-lg leading-relaxed md:p-12">

                @if (!auth()->user()->isDisqualified())
                    <livewire:profile-info-display />
                @else
                    <h1 class="text-cedea-blue clamp-[text,2xl,5xl] font-bold">
                        Kamu telah didisqualifikasi
                    </h1>
                @endif


            </div>

            <div class="relative z-0">
                <img class="absolute bottom-0 right-0 max-md:w-1/3" src='{{ asset('img/zee-wave.png') }}'
                    alt="zee waving">
            </div>

        </div>

        @if (!auth()->user()->isDisqualified())
            <livewire:submissions />
        @endif
    </section>

    <livewire:edit-profile />

    @filepondScripts
</x-layouts.app>
