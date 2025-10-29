<x-layouts.app>
    {{-- <x-layouts.dashboard> --}}
    <section class="container flex flex-col gap-y-12 pb-32 pt-10">

        <div
            class="max-md:grid-overlay overflo relative grid overflow-x-hidden rounded-2xl bg-white md:grid-cols-2 md:rounded-[3.5rem]">

            <div class="z-[1] p-6 text-lg leading-relaxed md:p-12">
                <h1 class="text-cedea-blue mb-2 text-3xl font-bold md:mb-12 md:text-5xl">Halo, {{ auth()->user()->name }}
                </h1>
                <p class="max-md:text-sm">{{ auth()->user()->name }}</p>
                <p class="max-md:text-sm">{{ auth()->user()->email }}</p>
                <p class="max-md:text-sm">{{ auth()->user()->address }}</p>
                <p class="max-md:text-sm">{{ auth()->user()->phone }}</p>
            </div>

            <div class="relative z-[0]">
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
