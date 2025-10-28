@props(['img', 'text', 'number'])
<div class="grid items-center justify-center justify-items-center gap-4 md:row-span-full md:grid-rows-subgrid">
    <img src="{{ $img }}" alt="">

    <div class="bg-cedea-red relative grid min-h-fit items-center rounded-xl p-2 pl-12 text-white md:h-full">
        <div class="bg-cedea-blue absolute -left-4 -top-4 rounded-full p-6 text-4xl font-bold">
            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">{{ $number }}</span>
        </div>
        <p>{{ $text }}</p>
    </div>
</div>
