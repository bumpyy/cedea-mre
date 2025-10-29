<div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
    <div class="max-w-lg">
        <img src="{{ asset('img/hero-3.png') }}" alt="">
    </div>
    <div class="flex w-full max-w-lg flex-col gap-2">
        <a class="flex flex-col items-center gap-2 font-medium" href="{{ route('home') }}">
            <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <div class="flex flex-col gap-6">
            {{ $slot }}
        </div>
    </div>
</div>
