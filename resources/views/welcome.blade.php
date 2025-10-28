<x-layouts.app :gradient='true'>
    <div class="container my-12">

        <div class="mb-12 flex justify-center">
            <img class="clamp-[max-w,160px,280px]" src="{{ asset('img/cedea-kfood.png') }}" alt="Cedea & K-Food Logo">
        </div>

        <div class="flex flex-wrap">
            <div class="flex flex-col items-center justify-start gap-4">
                <div class="w-3/5">
                    <img src="{{ asset('img/eomuk-bar-text.png') }}" alt="snack ala korea Eomuk Bar">
                </div>
                <div class="w-11/12">
                    <img src="{{ asset('img/enak-bar-bar.png') }}" alt="Enaknya Bar Bar">
                </div>
            </div>

            <div class="-ml-12 -mt-24 basis-3/5">
                <div class="group flex w-full">
                    <img class="ml-20 w-2/5 -rotate-3 drop-shadow-2xl transition-[rotate] duration-[600ms] ease-in-out group-hover:-rotate-1"
                        src="{{ asset('img/eomuk-cheese-4.png') }}" alt="">
                    <img class="-ml-[5.3rem] mt-16 w-2/5 rotate-6 drop-shadow-2xl transition-[rotate] duration-[600ms] ease-in-out group-hover:rotate-3"
                        src="{{ asset('img/eomuk-chili-4.png') }}" alt="">
                </div>
                {{-- <img src="{{ asset('img/eomuk-combine.png') }}" alt="Eomuk Combine Image"> --}}
            </div>
        </div>

        {{-- <x-home.prize />

        <div class="container grid items-center justify-center gap-4 lg:grid-cols-2">
            <x-home.how />

            <div class="max-lg:order-0 max-lg:clamp-[mb,-44,-26rem] relative z-0 lg:-ml-12 lg:w-[130%]">
                <img class="" src="{{ asset('img/zee.png') }}" alt="">
            </div>
        </div> --}}
    </div>
</x-layouts.app>
