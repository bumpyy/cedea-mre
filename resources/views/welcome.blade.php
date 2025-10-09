<x-layouts.app>

    <div>
        {{-- hero --}}
        <x-home.hero />

        <x-home.prize />

        <div class="container mx-auto flex items-center justify-center">
            <x-home.how />
            <div>
                <img src="{{ asset('img/zee.png') }}" alt="">
            </div>
        </div>
    </div>
</x-layouts.app>
