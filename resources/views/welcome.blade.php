<x-layouts.app>

    {{-- hero --}}
    <div class="container relative mx-auto my-24 flex flex-col items-center justify-center gap-16 px-6 lg:my-32">
        <div
            class="bg-size-[200%_200%] relative z-10 -mb-20 w-[20%] overflow-clip rounded-full bg-[url('../assets/patterns/paper.png')] bg-no-repeat drop-shadow-md">
            <div class="bg-radial to-cedea-dark/10 from-30 from-transparent px-8 py-4">
                <img src="{{ asset('img/brand.png') }}" srcset="{{ asset('img/brand.svg') }}" alt="Cedea k-food logo">
            </div>
        </div>

        <div class="relative max-lg:flex">

            <div
                class="bg-size-[100%_100%] rounded-4xl relative z-[1] basis-full -rotate-3 bg-white bg-[url('../assets/patterns/paper.png')] bg-no-repeat bg-blend-multiply drop-shadow-md lg:rounded-[4rem]">
                <h1
                    class="font-anton text-cedea-gold mask-[url('../assets/patterns/scratch-transparent-1.png')] mask-size-[100%_100%] flex size-full flex-col items-center justify-center p-2 px-4 text-5xl uppercase italic leading-none mix-blend-multiply before:pointer-events-none sm:text-8xl lg:p-8 lg:px-16 lg:text-[9rem]">
                    <span class="">Trip & Chill</span>
                    <span class="flex items-start">
                        <span class="font-bebas text-lg sm:text-xl md:text-4xl lg:text-7xl">bareng</span>
                        <span class="text-cedea-red">eomuk bar</span>
                    </span>
                    <span class="mx-auto">in seoul</span>
                </h1>
            </div>

            <x-header-mascot class="-right-[38%] -top-14 h-full basis-1/2 lg:order-1" type="chili" />

            <x-header-mascot class="-left-[38%] -top-14 h-full basis-1/2" type="cheese" />
        </div>

    </div>
</x-layouts.app>
