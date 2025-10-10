<x-layouts.app>

    <div class="my-12">
        {{-- hero --}}
        <x-home.hero />

        <x-home.prize />

        <div class="container flex items-center justify-center gap-4 max-lg:flex-col">
            <x-home.how />

            <div class="max-lg:order-0 max-lg:clamp-[mb,-44,-26rem]">
                <img src="{{ asset('img/zee.png') }}" alt="">
            </div>
        </div>
    </div>
</x-layouts.app>
