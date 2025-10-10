@props(['type' => ''])

<img @class([
    'h-full w-max clamp-[max-h,10rem,37rem] grid grid-overlay -z-10 relative ',
    'rotate-[-12deg] left-[clamp(1rem,_1vw,_4rem)] clamp-[bottom,0,-10] ' =>
        $type === 'cheese',
    'rotate-[12deg] right-0 clamp-[bottom,2,4]' => $type === 'chili',
]) src="{{ asset('img/eomuk-' . $type . '-3.png') }}" alt="eomuk-{{ $type }}">
