<x-layouts.app :gradient='true'>
    <div class="container my-12 max-md:mt-6">

        <div class="mb-12 flex justify-center md:mb-24">
            <img class="max-w-[140px] md:max-w-[280px]" src="{{ asset('img/cedea-kfood.png') }}" alt="Cedea & K-Food Logo">
        </div>

        <div class="relative flex max-md:flex-col md:gap-x-8">
            <div class="flex flex-col items-center justify-start gap-4 max-md:z-[1]">
                <div class="w-1/2 md:w-1/3 lg:w-3/5">
                    <img class="max-md:drop-shadow-xl" src="{{ asset('img/eomuk-bar-text.png') }}"
                        alt="snack ala korea Eomuk Bar">
                </div>
                <div class="w-1/2 md:h-2/3 lg:w-11/12">
                    <img src="{{ asset('img/enak-bar-bar.png') }}" alt="Enaknya Bar Bar">
                </div>
            </div>

            <div
                class="-mt-12 w-full basis-3/5 max-md:absolute max-md:-z-0 md:relative md:-ml-12 md:-mt-24 md:flex [&:hover>div>img.peer:not(:hover)~img]:scale-50 [&:hover>div>img.peer:not(:hover)~img]:opacity-0">


                <div class="w-2/5 drop-shadow-2xl hover:z-[1] max-md:absolute max-md:-left-10 md:relative md:ml-20">
                    <img class="peer relative -rotate-3 transition-[rotate,scale] duration-[600ms] ease-in-out hover:scale-105 group-hover:-rotate-1"
                        src="{{ asset('img/eomuk-cheese-4.png') }}" alt="">

                    <img class="absolute bottom-0 w-2/5 transition-[scale,opacity] duration-[600ms] ease-in-out max-md:-right-[10%] max-md:-scale-x-100 md:-left-[22%] md:bottom-[30%]"
                        src="{{ asset('img/cheese-combine.png') }}" alt="">

                    <img class="absolute -left-[5%] bottom-0 w-3/5 transition-[scale,opacity] duration-[600ms] ease-in-out md:-left-[15%] md:bottom-[5%]"
                        src="{{ asset('img/cheese-mascot-plus-border-2.png') }}" alt="">
                </div>

                <div
                    class="w-2/5 drop-shadow-2xl hover:z-[1] max-md:absolute max-md:-right-10 md:relative md:-ml-[5.3rem] md:mt-14">
                    <img class="peer rotate-3 transition-[rotate,scale] duration-[600ms] ease-in-out hover:scale-105 group-hover:rotate-3 md:rotate-6"
                        src="{{ asset('img/eomuk-chili-4.png') }}" alt="">

                    <img class="absolute bottom-0 w-2/5 transition-[scale,opacity] duration-[600ms] ease-in-out max-md:-left-[18%] max-md:-scale-x-100 md:-right-[22%] md:bottom-[30%]"
                        src="{{ asset('img/chili-combine.png') }}" alt="">

                    <img class="absolute -right-[25%] bottom-0 w-3/5 transition-[scale,opacity] duration-[600ms] ease-in-out"
                        src="{{ asset('img/chili-mascot-plus-border-2.png') }}" alt="">
                </div>

                <div class="absolute left-[-5%] top-[10%] w-1/5">
                    <img src="{{ asset('img/label-baru.png') }}" alt="">
                </div>
                {{-- <img src="{{ asset('img/eomuk-combine.png') }}" alt="Eomuk Combine Image"> --}}
            </div>
        </div>

        <div class="mt-10 2xl:-mt-40">
            <div class="grid-overlay -mb-32 grid md:-mb-64 md:w-2/5">
                <img src="{{ asset('img/zee-how-person.png') }}" alt="zee">
                <img class="z-[1]" src="{{ asset('img/zee-how-coin.png') }}" alt="gold coins">
            </div>

            <div
                class="relative flex items-center gap-2 rounded-3xl bg-white bg-[url('../assets/patterns/how-bg-pattern.png')] bg-bottom bg-repeat-x p-12 max-md:flex-col">
                <div class="basis-full">
                    <img src="{{ asset('img/how-heading.png') }}" alt="">
                </div>

                <ol
                    class="font-poppings grid gap-x-6 gap-y-12 font-bold uppercase md:grid-cols-3 md:grid-rows-[auto_minmax(40%,1fr)]">
                    <x-how-item img="{{ asset('img/how-eomuk.png') }}" text="beli cedea snack korea eomuk bar"
                        number="1" />
                    <x-how-item img="{{ asset('img/how-qr.png') }}"
                        text="scan qr code pada kemasan cedea snack korea eomuk bar" number="2" />
                    <x-how-item img="{{ asset('img/how-prize.png') }}"
                        text="menangkan liburan ke korea & uang tuhai ratusan juta" number="3" />
                </ol>

            </div>
        </div>

        <div
            class="font-poppings mx-auto mt-6 w-full rounded-full bg-[#FCC500] px-2 py-4 text-center text-2xl font-extrabold uppercase text-white drop-shadow-2xl md:mt-12 md:w-4/5 md:text-7xl">
            <a href="{{ route('login') }}">join sekarang</a>
        </div>

</x-layouts.app>
