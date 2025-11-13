<x-layouts.app>
    <x-layouts.auth.simple :title="$title ?? null">
        {{ $slot }}
    </x-layouts.auth.simple>

    @livewire('wire-elements-modal')

</x-layouts.app>
