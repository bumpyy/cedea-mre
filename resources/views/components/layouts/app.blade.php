<!DOCTYPE html>
<html class="h-full min-h-dvh" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins relative h-full bg-[#e51b1f] antialiased">
    <div class="bg-radial from-60 z-0 h-auto from-transparent to-[#952227]">
        <div class="asia-pattern-body z-0 h-full overflow-x-clip bg-no-repeat">
            <x-header />
            {{ $slot }}
            <x-footer />
        </div>
    </div>
    @fluxScripts
</body>

</html>
