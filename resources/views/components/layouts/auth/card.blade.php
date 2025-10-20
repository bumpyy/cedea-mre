<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ">
    <head>
        @include('partials.head')
    </head>
    <body class="dark:bg-linear-to-b min-h-screen bg-neutral-100 antialiased">
        <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a class="flex flex-col items-center gap-2 font-medium" href="{{ route('home') }}">
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black"/>
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="flex flex-col gap-6">
                    <div class="shadow-xs rounded-xl border bg-white text-stone-800">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
