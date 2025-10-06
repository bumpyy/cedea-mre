<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins bg-cedea-red antialiased">

    <div class="bg-radial to-cedea-dark from-30 min-h-dvh from-transparent">
        <x-header />
        {{ $slot }}
    </div>

    @fluxScripts
</body>

</html>
