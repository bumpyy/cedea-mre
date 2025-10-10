<div class="clamp-[my,8,14] clamp-[mt,8,28] container relative max-lg:pt-16">
    {{-- sticker --}}
    <div
        class="bg-size-[100%_100%] text-cedea-red font-bebas rounded-4xl lg:top-2/5 clamp-[text,xl,5xl] absolute left-12 top-0 z-[1] -rotate-6 bg-[url('../assets/patterns/paper.png')] bg-no-repeat px-6 py-8 text-center font-bold uppercase italic leading-none lg:-left-[2%] lg:-translate-y-1/2">
        menangkan
        <br />
        hadiahnya
    </div>
    <div
        class="bg-size-[100%_100%] relative flex items-center justify-center bg-no-repeat py-16 drop-shadow-xl max-lg:flex-col lg:min-h-[5rem] lg:bg-[url('../assets/patterns/prize-bg-transparent.png')] lg:px-64">

        <div class="relative">
            <div class="relative z-10 flex flex-col items-start">
                <p class="font-marimpa text-[clamp(1.5rem,_15vw,_30rem)] leading-none text-amber-300">10</p>
                <p class="font-montserrat clamp-[pl,4,8] -mt-4 flex flex-col text-white">
                    <span class="clamp-[text,lg,5xl] font-bold uppercase leading-none">
                        tiket
                    </span>

                    <span class="clamp-[text,lg,5xl] font-bold uppercase leading-none">
                        ke seoul
                    </span>

                    <span class="clamp-[text,base,3xl] uppercase leading-none">
                        2 tiket untuk 5 pemenang
                    </span>
                </p>
            </div>
            <img class="right-0 top-2 z-0 max-lg:max-w-80 lg:absolute lg:-right-[clamp(10rem,_1vw,_-11rem)] lg:-ml-28 xl:-right-[clamp(10rem,_1vw,_-11rem)] xl:top-[clamp(6rem,_1vw,_6rem)]"
                src="{{ asset('img/plane.png') }}" alt="">
        </div>

        <div class="lg:ml-40">
            <img src="{{ asset('img/money.png') }}" alt="">
            <div class="flex items-start gap-2">
                <p class="font-marimpa clamp-[text,lg,10rem] leading-none text-amber-300">
                    100</p>
                <p class="font-montserrat flex flex-col text-white">
                    <span class="clamp-[text,base,3xl] font-bold uppercase leading-none">Juta</span>
                    <span class="clamp-[text,base,3xl] font-bold uppercase leading-none">Rupiah</span>
                    <span class="clamp-[text,base,base] leading-none">untuk 10 pemenang</span>
                </p>
            </div>
        </div>
    </div>
</div>
