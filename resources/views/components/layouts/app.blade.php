<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins bg-[#e91f24] antialiased">

    <div class="bg-radial to-cedea-dark from-30 relative z-0 h-full min-h-dvh from-transparent">
        <div class="asia-pattern-body relative z-0 min-h-dvh overflow-clip bg-no-repeat">
            <x-header />
            {{ $slot }}
            <x-footer />
        </div>
    </div>

    @fluxScripts
</body>

</html>
