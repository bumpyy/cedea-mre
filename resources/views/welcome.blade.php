<x-layouts.app>

    <div>
        {{-- hero --}}
        <x-home.hero />

        <x-home.prize />

        <div class="container flex items-center justify-center max-lg:flex-col">
            <x-home.how />
            <div>
                <img src="{{ asset('img/zee.png') }}" alt="">
            </div>
        </div>
    </div>
</x-layouts.app>
