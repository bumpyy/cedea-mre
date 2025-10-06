<div class="relative flex items-center" x-data="{
    dropdownOpen: false
}">

    <button class="flex items-center gap-1 uppercase" @click="dropdownOpen=true">
        {{ LaravelLocalization::getCurrentLocale() }}
        <span class="flex size-4 gap-2 transition-transform duration-700" :class="{ '-rotate-180': dropdownOpen }">
            <x-lucide-chevron-down />
        </span>
    </button>

    <div class="absolute left-0 top-0 z-50 mt-6" x-show="dropdownOpen" @click.away="dropdownOpen=false"
        x-transition:enter="ease-in-out duration-200" x-transition:enter-start="-translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="ease-in-out duration-200"
        x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-2 opacity-0" x-cloak>

        <ul class="mt-1 rounded-md border border-neutral-200/70 bg-white p-1 text-sm text-neutral-700 shadow-md">

            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a class="group relative flex w-full select-none items-center justify-between rounded px-2 py-1.5 uppercase outline-none hover:bg-neutral-100 hover:text-neutral-900 data-[disabled]:pointer-events-none data-[disabled]:opacity-50"
                    rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <span>{{ $localeCode }}</span>
                    {{-- <span
                        class="ml-auto text-xs tracking-widest text-neutral-400 group-hover:text-neutral-600">⌘T</span> --}}
                </a>
            @endforeach

        </ul>
    </div>
</div>
