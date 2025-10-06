@props(['type' => ''])

<div {{ $attributes->merge(['class' => 'lg:absolute h-full']) }}>
    <img class="h-[130%]" src="{{ asset('img/eomuk-' . $type . '.png') }}" alt="eomuk-{{ $type }}">
    <div @class([
        'grid-overlay absolute w-[80%]',
        '-right-36 -bottom-44 grid ' => $type === 'cheese',
        '-left-6 -bottom-6  grid ' => $type === 'chili',
    ])>
        <img class="z-0 opacity-80" src="{{ asset('img/' . $type . '-mascot-border.png') }}"
            alt="eomuk-{{ $type }}">
        <img class="z-[2]" src="{{ asset('img/' . $type . '-mascot.png') }}" alt="eomuk-{{ $type }}">
    </div>
</div>
