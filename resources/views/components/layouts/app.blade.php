<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins bg-[#e51b1f] antialiased">

    <div class="bg-radial from-60 relative z-0 h-full min-h-dvh from-transparent to-[#952227]">
        <div class="asia-pattern-body relative z-0 min-h-dvh overflow-clip bg-no-repeat">
            <x-header />
            {{ $slot }}
            <x-footer />
        </div>
    </div>

    @fluxScripts
</body>

</html>
