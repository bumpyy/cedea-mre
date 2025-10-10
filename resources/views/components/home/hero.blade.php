    <div class="clamp-[gap,6,12] mt-20 flex flex-col items-center justify-center">
        <div
            class="bg-size-[200%_200%] shadow-top relative overflow-clip rounded-full bg-[url('../assets/patterns/paper-50.png')] bg-no-repeat">
            <div
                class="bg-radial to-cedea-dark/10 from-30 clamp-[w,7rem,17rem] clamp-[px,4,10] clamp-[py,2,4] from-transparent">
                <img src="{{ asset('img/brand.png') }}" srcset="{{ asset('img/brand.svg') }}" alt="Cedea k-food logo">
            </div>
        </div>

        <div class="drop-shadow-nav container relative mx-auto flex flex-col items-center justify-center gap-16 px-6">
            <div class="relative grid-cols-2 justify-items-center max-lg:grid">
                <div
                    class="bg-size-[100%_100%] rounded-4xl col-span-full basis-full -rotate-3 bg-white bg-[url('../assets/patterns/paper-50.png')] bg-no-repeat bg-blend-multiply lg:rounded-[4rem]">
                    <h1
                        class="font-anton text-cedea-blue mask-[url('../assets/patterns/scratch-transparent-1.png')] mask-size-[100%_100%] clamp-[px,4,16] clamp-[p,2,8] clamp-[text,4xl,9xl] text flex size-full flex-col items-center justify-center uppercase italic leading-none mix-blend-multiply before:pointer-events-none">
                        <span class="">Trip & Chill</span>
                        <span class="flex items-start">
                            <span class="font-bebas clamp-[text,lg,7xl]">bareng</span>
                            <span class="text-cedea-gold">eomuk bar</span>
                        </span>
                        <span class="mx-auto">in seoul</span>
                    </h1>
                    <div class="clamp-[w,10rem,15rem] absolute bottom-0 right-0 z-[5]">
                        <img src="{{ asset('img/south-korea-flag.png') }}" alt="">
                    </div>
                </div>
                <x-header-mascot class="h-full lg:-left-[clamp(8%,_15vw,_25%)] lg:-top-4" type="cheese" />
                <x-header-mascot
                    class="h-full lg:-right-[clamp(10%,_13vw,_30%)] lg:-top-10 2xl:-right-[clamp(10%,_14vw,_30%)]"
                    type="chili" />
            </div>
        </div>
    </div>
