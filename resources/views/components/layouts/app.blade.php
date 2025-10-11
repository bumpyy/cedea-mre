<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins relative h-full bg-[#e51b1f] antialiased">
    <div class="bg-radial from-60 z-0 grid h-auto min-h-dvh from-transparent to-[#952227]">
        <div class="asia-pattern-body z-0 h-full overflow-x-clip bg-no-repeat">
            <x-header />
            {{ $slot }}

            @if (request()->routeIs('home'))
                <x-footer />
            @endif
        </div>
    </div>
    @fluxScripts
</body>

</html>
