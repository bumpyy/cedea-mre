<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ">
    <head>
        @include('partials.head')
    </head>
    <body class="font-poppins bg-cedea-red antialiased">

        <x-header />

        {{ $slot }}

        @fluxScripts
    </body>
</html>
