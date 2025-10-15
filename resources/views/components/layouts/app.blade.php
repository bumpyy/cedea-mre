<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-poppins bg-cedea-red relative h-full antialiased" data-barba="wrapper">
    <div class="bg-cedea-red" id="loading-screen">
        <x-home.hero />
    </div>

    <main class="" id="swup" data-swup-transition="slide-down-stop">
        <div class="transition-fade bg-radial from-60 z-0 grid h-auto min-h-dvh from-transparent to-[#952227]">
            <div
                class="bg-size-[auto_80%] z-0 h-full overflow-x-clip bg-[url('../assets/patterns/asia-pattern.png')] bg-fixed bg-center bg-no-repeat">
                <div class="box-border bg-cover bg-center shadow-[inset_0_0_70px_0_#00000060]">
                    <x-header />

                    {{ $slot }}

                    @if (request()->routeIs('home'))
                        <x-footer />
                    @endif
                </div>
            </div>
        </div>
    </main>
    @fluxScripts
</body>

</html>
