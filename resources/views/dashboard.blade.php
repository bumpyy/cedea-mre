<x-layouts.app>
    {{-- <x-layouts.dashboard> --}}
    <section class="container -mt-12 flex flex-col gap-y-12 pb-32">

        <div class="-ml-[7%] mb-4 md:mb-20">
            <img src="{{ asset('img/hero-4.png') }}" alt="">
        </div>

        <div class="max-md:grid-overlay md:rounded-4xl relative grid rounded-2xl bg-white md:grid-cols-2">

            <div class="z-1 flex flex-col p-6 text-lg leading-relaxed md:p-12">
                <h1 class="text-cedea-blue mb-2 text-3xl font-bold md:mb-12 md:text-5xl">Halo, {{ auth()->user()->name }}
                </h1>

                <p class="max-md:text-sm">{{ auth()->user()->name }}</p>

                <p class="max-md:text-sm">{{ auth()->user()->address }}</p>

                @if (!auth()->user()->isVerified())
                    <p class="text-cedea-red/70 max-md:text-xs">Silahkan verifikasi email atau whatsapp anda terlebih
                        dahulu</p>
                @endif

                @if (!empty(auth()->user()->email) && !auth()->user()->hasVerifiedEmail())
                    <livewire:dashboard-email-verify>
                    @else
                        <p class="inline-flex items-center max-md:text-sm">
                            {{ auth()->user()->email }}
                            @if (auth()->user()->hasVerifiedEmail())
                                <span class="ml-2 inline-block size-6 rounded-full text-green-300">
                                    <x-lucide-badge-check />
                                </span>
                            @endif
                        </p>
                @endif

                @if (!empty(auth()->user()->phone) && !auth()->user()->hasVerifiedPhone())
                    <livewire:dashboard-phone-verify>
                    @else
                        <p class="inline-flex items-center max-md:text-sm">{{ auth()->user()->phone }}
                            @if (auth()->user()->hasVerifiedPhone())
                                <span class="ml-2 inline-block size-6 rounded-full text-green-300">
                                    <x-lucide-badge-check />
                                </span>
                            @endif
                        </p>
                @endif
            </div>

            <div class="relative z-0">
                <img class="absolute bottom-0 right-0 max-md:w-1/3" src='{{ asset('img/zee-wave.png') }}'
                    alt="zee waving">
            </div>

        </div>

        <livewire:submissions />
    </section>

    @filepondScripts
    @livewire('wire-elements-modal')
    {{-- </x-layouts.dashboard> --}}
</x-layouts.app>
