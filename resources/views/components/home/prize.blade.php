<div class="clamp-[my,14,24] clamp-[mt,20,60] container relative max-lg:pt-16">
    {{-- sticker --}}
    <div
        class="bg-size-[100%_100%] text-cedea-red font-bebas clamp-[rounded,xl,4xl] lg:top-2/5 clamp-[text,xl,5xl] clamp-[px,4,10] clamp-[py,3,8] absolute left-12 top-8 z-[1] -rotate-6 bg-[url('../assets/patterns/paper.png')] bg-no-repeat text-center font-bold uppercase italic leading-none lg:-left-[2%] lg:-translate-y-1/2">
        menangkan
        <br />
        hadiahnya
    </div>

    <div
        class="bg-size-[100%_100%] max-lg:bg-cedea-red max-lg:clamp-[p,6,20] max-lg:clamp-[pt,12,30] relative grid items-center justify-center rounded-xl bg-no-repeat py-16 drop-shadow-2xl max-lg:flex-col max-md:gap-y-8 md:grid-cols-2 lg:min-h-[5rem] lg:bg-[url('../assets/patterns/prize-bg-transparent.png')] lg:px-64">

        <div class="relative">
            <div class="clamp-[gap,4,0] relative z-10 flex flex-col items-start">
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
            <img class="clamp-[left,2rem,11rem] clamp-[top,2rem,4rem] z-0 max-w-full max-lg:max-w-80 lg:absolute"
                src="{{ asset('img/plane.png') }}" alt="">
        </div>

        <div class="max-md:grid lg:ml-40">
            <img class="max-md:order-2" src="{{ asset('img/money.png') }}" alt="">
            <div class="flex items-start gap-2 max-md:order-1">
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
