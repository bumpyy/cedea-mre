@props(['img', 'text', 'number'])
<li class="grid items-center justify-center justify-items-center gap-4 md:row-span-full md:grid-rows-subgrid">
    <img class="max-w-[80%]" src="{{ $img }}" alt="">

    <div class="bg-cedea-red relative grid min-h-fit items-center rounded-xl p-2 pl-10 text-white md:h-full">
        <h3 class="bg-cedea-blue absolute -left-4 -top-4 rounded-full p-6 text-4xl font-bold">
            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">{{ $number }}</span>
        </h3>
        <div>
            {!! $text !!}
        </div>
    </div>
</li>
