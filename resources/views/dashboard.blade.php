<x-layouts.app>
    {{-- <x-layouts.dashboard> --}}
    <section class="container flex flex-col gap-y-12 py-10">

        <x-home.hero />

        <div class="relative grid grid-cols-2 overflow-x-clip rounded-[3.5rem] bg-white p-12">

            <div class="text-lg leading-relaxed">
                <h1 class="text-cedea-blue mb-12 text-5xl font-bold">Halo, {{ auth()->user()->name }}</h1>
                <p>{{ auth()->user()->name }}</p>
                <p>{{ auth()->user()->email }}</p>
                <p>{{ auth()->user()->address }}</p>
                <p>{{ auth()->user()->phone }}</p>
            </div>
            <div class="w relative">
                <img class="absolute -bottom-12 -right-12" src='{{ asset('img/zee-wave.png') }}' alt="">
            </div>
        </div>

    </section>
    {{-- </x-layouts.dashboard> --}}
</x-layouts.app>
