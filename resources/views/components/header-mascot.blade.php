@props(['type' => ''])

<div {{ $attributes->merge(['class' => 'lg:absolute relative h-full max-h-80']) }}>
    <img @class([
        'h-[clamp(100%,_30vw,_150%)]',
        'rotate-[-10deg]' => $type === 'cheese',
        'rotate-[10deg]' => $type === 'chili',
    ]) src="{{ asset('img/eomuk-' . $type . '-2.png') }}" alt="eomuk-{{ $type }}">
    <div @class([
        'grid-overlay absolute max-w-96 w-[clamp(40%,_30vw,_200%)]',
        '2xl:-right-64 2xl:-bottom-64 xl:-right-56 xl:-bottom-36 lg:-right-44 lg:-bottom-10 grid' =>
            $type === 'cheese',
        '2xl:-left-48 2xl:-bottom-32 xl:-left-44 xl:-bottom-32 lg:-left-26 lg:-bottom-20 grid' =>
            $type === 'chili',
    ])>
        <img class="z-0 opacity-80" src="{{ asset('img/' . $type . '-mascot-border.png') }}"
            alt="eomuk-{{ $type }}">
        <img class="z-[2]" src="{{ asset('img/' . $type . '-mascot.png') }}" alt="eomuk-{{ $type }}">
    </div>
</div>
