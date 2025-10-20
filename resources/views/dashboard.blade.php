<x-layouts.app>
    {{-- <x-layouts.dashboard> --}}
    <section class="container flex flex-col gap-y-12 pb-32 pt-10">

        <x-home.hero />

        <div class="max-md:grid-overlay relative grid overflow-x-clip rounded-[3.5rem] bg-white p-12 md:grid-cols-2">

            <div class="z-[1] text-lg leading-relaxed">
                <h1 class="text-cedea-blue mb-12 text-5xl font-bold">Halo, {{ auth()->user()->name }}</h1>
                <p>{{ auth()->user()->name }}</p>
                <p>{{ auth()->user()->email }}</p>
                <p>{{ auth()->user()->address }}</p>
                <p>{{ auth()->user()->phone }}</p>
            </div>

            <div class="relative z-[0]">
                <img class="absolute -bottom-12 -right-12 max-md:w-1/3" src='{{ asset('img/zee-wave.png') }}'
                    alt="zee waving">
            </div>

        </div>

        <livewire:submissions />
    </section>

    @filepondScripts
    @livewire('wire-elements-modal')
    {{-- </x-layouts.dashboard> --}}
</x-layouts.app>
