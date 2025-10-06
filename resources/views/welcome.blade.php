<x-layouts.app>

    {{-- hero --}}
    <div class="container relative mx-auto my-24 flex flex-col items-center justify-center gap-16 px-6 lg:my-32">
        <div
            class="bg-size-[200%_200%] relative z-10 -mb-20 w-[20%] overflow-clip rounded-full bg-[url('../assets/patterns/paper.png')] bg-no-repeat drop-shadow-md">
            <div class="bg-radial to-cedea-dark/10 from-30 from-transparent px-8 py-4">
                <img src="{{ asset('img/brand.png') }}" srcset="{{ asset('img/brand.svg') }}" alt="Cedea k-food logo">
            </div>
        </div>

        <div class="relative">
            <x-header-mascot class="absolute -right-[38%] -top-14 h-full" type="chili" />

            <div
                class="bg-size-[100%_100%] relative z-[1] -rotate-3 rounded-[4rem] bg-white bg-[url('../assets/patterns/paper.png')] bg-no-repeat px-8 bg-blend-multiply drop-shadow-md">
                <h1
                    class="font-anton text-cedea-gold mask-[url('../assets/patterns/scratch-transparent-1.png')] mask-size-[100%_100%] flex size-full flex-col items-center justify-center p-8 text-3xl uppercase italic leading-none mix-blend-multiply before:pointer-events-none lg:text-[9rem]">
                    <span class="">Trip & Chill</span>
                    <span class="flex items-start">
                        <span class="font-bebas text-7xl">bareng</span>
                        <span class="text-cedea-red">eomuk bar</span>
                    </span>
                    <span class="mx-auto">in seoul</span>
                </h1>
            </div>

            <x-header-mascot class="absolute -left-[38%] -top-14 h-full" type="cheese" />
        </div>

    </div>
</x-layouts.app>
