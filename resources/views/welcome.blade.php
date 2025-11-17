<x-layouts.app :gradient='true'>
    <div class="container">

        <div class="mb-6 md:mb-16">
            <img class="mx-auto max-w-[140px] md:max-w-[280px]" src="{{ asset('img/cedea-kfood.png') }}"
                alt="Cedea & K-Food Logo">
        </div>

        <div class="mx-auto max-w-[95%]">
            <img class="mx-auto" src="{{ asset('img/final/headline.png') }}" />
        </div>

        <div class="grid gap-2 lg:grid-cols-[45%_1fr]">
            <div class="flex flex-col items-center justify-between">
                <div class="mx-auto max-w-[190px] md:max-w-[380px]">
                    <img src="{{ asset('img/final/tagline.png') }}" />
                </div>

                <div class="scale-105">
                    <img src="{{ asset('img/final/eomuk-qr.png') }}" />
                </div>

                <div>
                    <img src="{{ asset('img/final/marketplace.png') }}" />
                </div>
            </div>

            <div class="flex flex-col justify-between gap-4">
                <div class="mx-auto md:w-[95%]">
                    <div>
                        <div class="shrink basis-full">
                            <img src="{{ asset('img/final/plane-prize.png') }}" alt="">
                        </div>
                        <div class="-mt-[15%] w-1/2 shrink basis-2/3">
                            <img src="{{ asset('img/final/money-prize.png') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <img src="{{ asset('img/final/period.png') }}" alt="">
                    </div>
                </div>
                <div
                    class="relative flex items-center gap-2 rounded-3xl bg-[] bg-white bg-[url('../assets/patterns/how-bg-pattern.png')] bg-bottom bg-repeat-x p-12 max-md:flex-col">

                    <ol
                        class="font-poppings grid gap-x-6 gap-y-12 font-bold uppercase md:grid-cols-3 md:grid-rows-[auto_minmax(auto,1fr)]">
                        <x-how-item img="{{ asset('img/final/how-eomuk.png') }}"
                            text="beli cedea snack korea <br/> eomuk bar" number="1" />
                        <x-how-item img="{{ asset('img/final/how-qr.png') }}"
                            text="scan qr code pada kemasan cedea snack korea <br/> eomuk bar" number="2" />
                        <x-how-item img="{{ asset('img/final/how-prize.png') }}"
                            text="menangkan liburan ke korea & uang tunai ratusan juta" number="3" />
                    </ol>

                </div>

                <div>
                    <img src="{{ asset('img/final/footnote.png') }}" alt="">
                </div>
            </div>

        </div>

        <div
            class="font-poppings clamp-[text,base,3xl] clamp-[mt,6,12] mx-auto w-full rounded-full bg-[#FCC500] px-2 py-4 text-center font-extrabold uppercase text-white drop-shadow-2xl md:w-4/5">
            <a href="{{ route('login') }}">join sekarang</a>
        </div>

    </div>
</x-layouts.app>
