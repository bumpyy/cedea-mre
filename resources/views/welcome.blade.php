<x-layouts.app :gradient='true'>
    <div class="container my-12 max-md:mt-6">

        <div class="mb-12 flex justify-center md:mb-24">
            <img class="max-w-[140px] md:max-w-[280px]" src="{{ asset('img/cedea-kfood.png') }}" alt="Cedea & K-Food Logo">
        </div>

        <div class="relative flex max-md:flex-col">
            <div class="flex flex-col items-center justify-start gap-4">
                <div class="w-3/5">
                    <img src="{{ asset('img/eomuk-bar-text.png') }}" alt="snack ala korea Eomuk Bar">
                </div>
                <div class="w-11/12">
                    <img src="{{ asset('img/enak-bar-bar.png') }}" alt="Enaknya Bar Bar">
                </div>
            </div>

            <div class="group -mt-12 w-full basis-3/5 max-md:absolute max-md:-z-10 md:-ml-12 md:-mt-24 md:flex">
                <div
                    class="w-2/5 -rotate-3 drop-shadow-2xl transition-[rotate] duration-[600ms] ease-in-out group-hover:-rotate-1 max-md:absolute max-md:-left-16 md:ml-20">
                    <img src="{{ asset('img/eomuk-cheese-4.png') }}" alt="">
                </div>
                <div
                    class="w-2/5 rotate-6 drop-shadow-2xl transition-[rotate] duration-[600ms] ease-in-out group-hover:rotate-3 max-md:absolute max-md:-right-16 md:-ml-[5.3rem] md:mt-16">
                    <img src="{{ asset('img/eomuk-chili-4.png') }}" alt="">
                </div>
                {{-- <img src="{{ asset('img/eomuk-combine.png') }}" alt="Eomuk Combine Image"> --}}
            </div>
        </div>

        <div class="-mt-4 2xl:-mt-40">

            <div class="-mb-32 md:-mb-72 md:w-2/5">
                <img src="{{ asset('img/zee-how.png') }}" alt="snack ala korea Eomuk Bar">
            </div>

            <div class="relative flex items-center gap-2 rounded-3xl bg-white p-12 max-md:flex-col">
                <div class="basis-full">
                    <img src="{{ asset('img/how-heading.png') }}" alt="">
                </div>

                <div class="mt-12 grid gap-12 uppercase md:grid-cols-3 md:grid-rows-[auto_minmax(40%,1fr)]">
                    <x-how-item img="{{ asset('img/how-eomuk.png') }}" text="beli cedea snack korea eomuk bar"
                        number="1" />
                    <x-how-item img="{{ asset('img/how-qr.png') }}"
                        text="scan qr code pada kemasan cedea snack korea eomuk bar" number="2" />
                    <x-how-item img="{{ asset('img/how-prize.png') }}"
                        text="menangkan liburan ke korea & uang tuhai ratusan juta" number="3" />
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
