  <div class="container relative mx-auto my-24 flex flex-col items-center justify-center gap-16 px-6 lg:my-32">
      <div
          class="bg-size-[200%_200%] relative z-10 -mb-[4.5rem] w-[40%] overflow-clip rounded-full bg-[url('../assets/patterns/paper.png')] bg-no-repeat drop-shadow-md lg:-mb-20 lg:w-[20%]">
          <div
              class="bg-radial to-cedea-dark/10 from-30 from-transparent px-[clamp(0.8rem,_1vw,_4rem)] py-[clamp(0.4rem,_1vw,_2rem)]">
              <img src="{{ asset('img/brand.png') }}" srcset="{{ asset('img/brand.svg') }}" alt="Cedea k-food logo">
          </div>
      </div>

      <div class="relative grid-cols-2 justify-items-center max-lg:grid">
          <div
              class="bg-size-[100%_100%] rounded-4xl relative z-[1] col-span-full basis-full -rotate-3 bg-white bg-[url('../assets/patterns/paper.png')] bg-no-repeat bg-blend-multiply drop-shadow-md lg:rounded-[4rem]">
              <h1
                  class="font-anton text-cedea-gold mask-[url('../assets/patterns/scratch-transparent-1.png')] mask-size-[100%_100%] flex size-full flex-col items-center justify-center p-2 px-4 text-[clamp(2.8rem,_8vw,_9rem)] uppercase italic leading-none mix-blend-multiply before:pointer-events-none lg:p-8 lg:px-16">
                  <span class="">Trip & Chill</span>
                  <span class="flex items-start">
                      <span class="font-bebas text-[clamp(1rem,_8vw,_4.5rem)]">bareng</span>
                      <span class="text-cedea-red">eomuk bar</span>
                  </span>
                  <span class="mx-auto">in seoul</span>
              </h1>
          </div>

          <x-header-mascot class="h-full lg:-left-[clamp(8%,_15vw,_25%)] lg:-top-4" type="cheese" />
          <x-header-mascot
              class="h-full lg:-right-[clamp(10%,_13vw,_30%)] lg:-top-10 2xl:-right-[clamp(10%,_14vw,_30%)]"
              type="chili" />
      </div>
  </div>
