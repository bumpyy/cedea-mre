<x-layouts.app>
    <div class="my-12">
        {{-- hero --}}
        <x-home.hero />

        <x-home.prize />

        <div class="container grid items-center justify-center gap-4 lg:grid-cols-2">
            <x-home.how />

            <div class="max-lg:order-0 max-lg:clamp-[mb,-44,-26rem] relative z-0 lg:-ml-12 lg:w-[130%]">
                <img class="" src="{{ asset('img/zee.png') }}" alt="">
            </div>
        </div>
    </div>
</x-layouts.app>
