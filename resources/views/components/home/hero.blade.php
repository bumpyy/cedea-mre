<div class="clamp-[gap,6,12] container mt-20 flex flex-col items-center justify-center">

    <div class="drop-shadow-nav relative flex w-[clamp(100%,100vw,105%)] flex-col items-center justify-center gap-16">
        <div class="grid w-full grid-cols-[1fr_auto_1fr] items-end justify-items-center">

            <x-hero-eomuk type="cheese" />

            <div class="relative">

                <x-mascot type="cheese" />
                <div
                    class="bg-size-[200%_200%] shadow-top clamp-[mb,4,8] relative mx-auto w-fit overflow-clip rounded-full bg-[url('../assets/patterns/paper-50.png')] bg-no-repeat">
                    <div
                        class="bg-radial to-cedea-dark/10 from-30 clamp-[w,7rem,17rem] clamp-[px,4,10] clamp-[py,2,4] from-transparent">
                        <img src="{{ asset('img/brand.png') }}" srcset="{{ asset('img/brand.svg') }}"
                            alt="Cedea k-food logo">
                    </div>
                </div>

                <div
                    class="bg-size-[100%_100%] clamp-[rounded,3xl,4rem] -rotate-4 relative z-[1] h-fit w-[clamp(100%,_50vw_+_1rem,_130%)] justify-self-center bg-white bg-[url('../assets/patterns/paper-50.png')] bg-no-repeat bg-blend-multiply">
                    <h1
                        class="font-anton text-cedea-blue mask-[url('../assets/patterns/scratch-transparent-1.png')] mask-size-[100%_100%] clamp-[px,2,16] clamp-[py,2,8] clamp-[text,4xl,9xl] text flex size-full flex-col items-center justify-center uppercase italic leading-none mix-blend-multiply before:pointer-events-none">
                        <span class="">Trip & Chill</span>
                        <span class="flex items-start">
                            <span class="font-bebas clamp-[text,lg,7xl]">bareng</span>
                            <span class="text-cedea-gold">eomuk bar</span>
                        </span>
                        <span class="mx-auto">in seoul</span>
                    </h1>

                </div>

                <x-mascot type="chili" />

                <div class="clamp-[w,4rem,14rem] absolute -bottom-2 -right-2 z-[5]">
                    <img src="{{ asset('img/south-korea-flag.png') }}" alt="">
                </div>

            </div>

            <x-hero-eomuk type="chili" />


        </div>
    </div>
</div>
