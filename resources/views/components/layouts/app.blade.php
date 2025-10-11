<!DOCTYPE html>
<html class="h-full min-h-dvh" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins relative h-full bg-[#e51b1f] antialiased">
    <div class="bg-radial from-60 auto z-0 h-full from-transparent to-[#952227]">
        <div class="asia-pattern-body z-0 flex h-full flex-col overflow-x-clip bg-no-repeat">
            <x-header />
            {{ $slot }}
            <x-footer />
        </div>
    </div>
    @fluxScripts
</body>

</html>
