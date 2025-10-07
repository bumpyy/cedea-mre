<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins bg-cedea-red antialiased">

    <div class="bg-radial to-cedea-dark from-30 h-full min-h-dvh from-transparent">
        <div class="asia-pattern-body min-h-dvh bg-no-repeat">
            <x-header />
            {{ $slot }}
        </div>
    </div>

    @fluxScripts
</body>

</html>
