@props(['type' => ''])

<div {{ $attributes->merge(['class' => 'lg:absolute h-full max-h-80']) }}>
    <img @class([
        'h-[150%]',
        'rotate-[-10deg]' => $type === 'cheese',
        'rotate-[10deg]' => $type === 'chili',
    ]) src="{{ asset('img/eomuk-' . $type . '-2.png') }}" alt="eomuk-{{ $type }}">
    <div @class([
        'grid-overlay absolute max-w-96 w-[200%]',
        '-right-64 -bottom-64 grid' => $type === 'cheese',
        '-left-48 -bottom-32  grid' => $type === 'chili',
    ])>
        <img class="z-0 opacity-80" src="{{ asset('img/' . $type . '-mascot-border.png') }}"
            alt="eomuk-{{ $type }}">
        <img class="z-[2]" src="{{ asset('img/' . $type . '-mascot.png') }}" alt="eomuk-{{ $type }}">
    </div>
</div>
