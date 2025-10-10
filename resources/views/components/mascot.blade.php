@props(['type' => 'cheese'])

<div @class([
    'grid-overlay absolute max-w-96 clamp-[w,5rem,26rem] grid',
    'clamp-[bottom,-8,-36] clamp-[left,-6,-40]' => $type === 'cheese',
    'clamp-[bottom,3,4] clamp-[right,-12,-64]' => $type === 'chili',
])>
    <img class="z-0" src="{{ asset('img/' . $type . '-mascot-border.png') }}" alt="eomuk-{{ $type }}-border">
    <img class="z-[2]" src="{{ asset('img/' . $type . '-mascot.png') }}" alt="eomuk-{{ $type }}">
</div>
