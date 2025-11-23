{{-- ? Main Menu --}}
{{-- TODO: Clean-up and seperate into smaller components --}}
<div class="flex items-center justify-end gap-4 lg:justify-center" data-mobile-nav-open
    x-bind:data-mobile-nav-open="mobileNavOpen ? 'true' : 'false'" x-data="{ mobileNavOpen: false, hoverPosition: null, closeMobileNav() { this.mobileNavOpen = false } }"
    x-resize.document="if($width> 1024) mobileNavOpen=false;">

    <nav class="bg-cedea-red relative z-10 w-auto text-white" x-data="navigation">

        {{-- Desktop nav --}}
        <div class="relative max-lg:hidden">
            {{-- main nav --}}
            <div class="relative">
                <ul class="flex flex-1 list-none items-center justify-center">
                    {{-- home --}}
                    @foreach ($nav_items as $item)
                        @if ($item['disable'])
                            <li class="cursor-not-allowed gap-y-1 px-5 py-7 font-medium opacity-60 transition-colors"
                                onclick="alert('Akan Hadir')">
                                <div
                                    class="relative font-medium transition-colors after:absolute after:left-0 after:top-8 after:h-1 after:w-0 after:bg-transparent after:transition-all after:duration-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50">
                                    {{ $item['label'] }}
                                </div>
                            </li>
                        @else
                            <li class="gap-y-1 px-5 py-7 font-medium transition-colors"
                                @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='{{ Str::kebab($item['label']) }}'"
                                @mouseleave="navigationMenuLeave()">
                                <a @class([
                                    'relative font-medium transition-colors after:absolute after:left-0 after:top-8 after:h-1 after:w-0 after:bg-transparent after:transition-all after:duration-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50',
                                    'after:bg-white! after:w-1/2!' => url()->current() === $item['route'],
                                ])
                                    :class="{
                                        'after:bg-white after:w-1/2': navigationMenu=='{{ Str::kebab($item['label']) }}',
                                        'after:bg-transparent after:w-0 ': navigationMenu!='{{ Str::kebab($item['label']) }}'
                                    }"
                                    href="{{ $item['route'] }}">
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    <li class="gap-y-1 px-5 py-7 font-medium transition-colors"
                        @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='login'"
                        @mouseleave="navigationMenuLeave()">

                        <a @class([
                            'relative font-medium transition-colors after:absolute after:left-0 after:top-8 after:h-1 after:w-0 after:bg-transparent after:transition-all after:duration-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50',
                            'after:bg-white! after:w-1/2!' =>
                                url()->current() === route('login') ||
                                url()->current() === route('dashboard'),
                        ])
                            :class="{
                                'after:bg-white after:w-1/2': navigationMenu=='login',
                                'after:bg-transparent after:w-0 ': navigationMenu!='login'
                            }"
                            href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                            @auth
                                Dashboard/Upload
                            @else
                                Login / Register
                            @endauth
                            {{-- <x-lucide-house class="size-4" /> --}}
                        </a>

                    </li>

                    @auth
                        <li>
                            <flux:dropdown class="text-white" align="end">
                                <flux:profile class="**:data-flux-icon:text-white" :initials="auth()->user()->initials()" />
                                <flux:navmenu class="max-w-48">
                                    <div class="px-2 py-1.5">
                                        <flux:text size="sm">Signed in as</flux:text>
                                        <flux:heading class="mt-1! truncate">{{ auth()->user()->email }}</flux:heading>
                                    </div>

                                    <form class="w-full" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <flux:menu.item class="w-full cursor-pointer" data-test="logout-button"
                                            as="button" type="submit" icon="arrow-right-start-on-rectangle">
                                            {{ __('Log Out') }}
                                        </flux:menu.item>
                                    </form>
                                </flux:navmenu>
                            </flux:dropdown>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- submenu --}}
            <div class="absolute top-full -translate-x-1/2 text-center duration-200 ease-out" x-ref="navigationDropdown"
                x-show="navigationMenuOpen" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90" @mouseover="navigationMenuClearCloseTimeout()"
                @mouseleave="navigationMenuLeave()" x-cloak>
                <div class="bg-cedea-red flex h-auto w-auto justify-center shadow-sm">
                    @foreach ($nav_items as $item)
                        @if (array_key_exists('submenu', $item) && count($item['submenu']) && !$item['disable'])
                            <div class="flex w-full max-w-sm items-stretch justify-center gap-x-3"
                                x-show="navigationMenu == '{{ Str::kebab($item['label']) }}'">
                                <div class="w-52">
                                    @foreach ($item['submenu'] as $item_submenu)
                                        @if (array_key_exists('submenu', $item_submenu) && count($item_submenu['submenu']))
                                            <div class="group relative w-full">
                                                <a class="after:animate-in after:slide-in-from-left-1 after:bg-cedea-red group-hover:shadow-nav flex cursor-pointer select-none items-center justify-center rounded py-3 ease-out after:absolute after:-right-1 after:origin-left after:-translate-x-full after:opacity-0 after:duration-100 group-hover:after:visible group-hover:after:h-full group-hover:after:w-2 group-hover:after:translate-x-0 group-hover:after:opacity-100"
                                                    href="{{ $item_submenu['route'] }}" @click="navigationMenuClose()">
                                                    <span
                                                        class="mb-1 block font-medium">{{ $item_submenu['label'] }}</span>
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </a>

                                                {{-- sub-submenu --}}
                                                <div class="invisible absolute -right-1 top-1/2 mr-1 -translate-y-1/2 translate-x-full opacity-0 duration-200 ease-out group-hover:visible group-hover:mr-0 group-hover:opacity-100"
                                                    data-submenu="">
                                                    <div
                                                        class="animate-in slide-in-from-left-1 bg-cedea-red z-50 w-52 min-w-32 max-w-sm overflow-hidden text-center">
                                                        @foreach ($item_submenu['submenu'] as $sub_submenu)
                                                            <a class="hover:shadow-nav data-disabled:pointer-events-none data-disabled:opacity-50 relative flex cursor-pointer select-none items-center justify-center rounded px-2 py-3 outline-none"
                                                                href="{{ $sub_submenu['route'] }}">{{ $sub_submenu['label'] }}</a>
                                                            <div class="mx-auto h-0.5 w-2/6 bg-neutral-200 last:hidden">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <a class="hover:shadow-nav block cursor-pointer rounded px-3.5 py-3"
                                                href="{{ $item_submenu['route'] }}" @click="navigationMenuClose()">
                                                <span
                                                    class="mb-1 block font-medium">{{ $item_submenu['label'] }}</span>
                                            </a>
                                        @endif
                                        <div class="mx-auto h-0.5 w-2/6 bg-neutral-200 last:hidden"></div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </nav>

    <div class="flex justify-start gap-4 lg:flex-row lg:justify-end lg:gap-x-6 lg:gap-y-0">
        {{-- search icon --}}
        {{-- <x-search-modal /> --}}

        {{-- Locale Toggle --}}
        {{-- <x-locale-toggler /> --}}

        {{-- burger menu --}}
        <label class="flex h-10 w-9 cursor-pointer flex-col items-center justify-center lg:hidden">
            <input class="peer hidden" type="checkbox" x-model="mobileNavOpen" />
            <div
                class="h-0.5 w-[50%] origin-left translate-y-[0.45rem] rounded-sm bg-white transition-all duration-300 peer-checked:-rotate-45">
            </div>
            <div
                class="h-0.5 w-[50%] origin-center rounded-md bg-white transition-all duration-300 peer-checked:hidden">
            </div>
            <div
                class="h-0.5 w-[50%] origin-left -translate-y-[0.45rem] rounded-md bg-white transition-all duration-300 peer-checked:rotate-45">
            </div>
        </label>
    </div>

    {{-- Mobile Nav --}}
    <nav class="-z-1 bg-cedea-red absolute left-0 top-14 flex w-full flex-col gap-y-4 overflow-auto px-4 transition-all duration-700 lg:hidden"
        x-trap.inert.noscroll.noautofocus="mobileNavOpen" x-cloak
        :class="{
            'animate-in max-h-dvh h-screen slide-in-from-top py-4': mobileNavOpen,
            'max-h-0 p-0 h-0':
                !mobileNavOpen
        }">

        {{-- nav items --}}
        <ul class="bg-cedea-red container flex w-full list-none flex-col justify-center gap-y-8 pb-16 pt-10 lg:hidden">
            @foreach ($nav_items as $item)
                <li class="focus:outline-none">
                    @if (!$item['disable'])
                        <a class="relative inline-flex cursor-pointer flex-col rounded-md font-medium transition-colors"
                            @click="closeMobileNav()" href="{{ $item['route'] }}">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <div class="relative inline-flex cursor-not-allowed flex-col rounded-md font-medium opacity-60 transition-colors"
                            onclick="alert('Akan Hadir')">
                            {{ $item['label'] }}
                        </div>
                    @endif

                    @if (!$item['disable'])
                        @if (array_key_exists('submenu', $item) && count($item['submenu']))
                            <ul class="px-3.5">
                                @foreach ($item['submenu'] as $item_submenu)
                                    <a class="flex cursor-pointer items-center py-3" @click="closeMobileNav()"
                                        href="{{ $item_submenu['route'] }}">
                                        <span class="mb-1 block font-medium">{{ $item_submenu['label'] }}</span>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                    {{-- sub-submenu --}}

                                    @if (array_key_exists('submenu', $item_submenu) && count($item_submenu['submenu']))
                                        <li class="relative w-full focus:outline-none">
                                            <ul
                                                class="animate-in slide-in-from-top-1 bg-cedea-red z-50 min-w-32 max-w-sm overflow-hidden p-1 pl-6">
                                                @foreach ($item_submenu['submenu'] as $sub_submenu)
                                                    <li class="relative cursor-pointer py-3 focus:outline-none">
                                                        <a class="data-disabled:pointer-events-none data-disabled:opacity-50"
                                                            @click="closeMobileNav()"
                                                            href="{{ $sub_submenu['route'] }}">{{ $sub_submenu['label'] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    @endif

                </li>
            @endforeach

            <li>
                <a class="relative inline-flex cursor-pointer flex-col rounded-md font-medium transition-colors"
                    @click="closeMobileNav()" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                    @auth
                        Dashboard/Upload
                    @else
                        Login / Register
                    @endauth
                </a>

            </li>

            @auth
                <li class="text-white">
                    <div class="py-1.5">
                        <flux:text class="text-white" size="sm ">Signed in as</flux:text>
                        <flux:heading class="mt-1! truncate text-white">{{ auth()->user()->email }}</flux:heading>
                    </div>

                    <form class="w-full" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item class="text-white! w-full cursor-pointer" data-test="logout-button"
                            as="button" type="submit" icon="arrow-right-start-on-rectangle">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>

                </li>
            @endauth

        </ul>

    </nav>

</div>
