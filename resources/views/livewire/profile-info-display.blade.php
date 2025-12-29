<div class="flex flex-col">
    {{-- Tombol Edit dan Heading Nama disatukan --}}
    <div class="mb-2 flex items-start md:mb-12">
        <h1 class="text-cedea-blue clamp-[text,2xl,5xl] font-bold">
            Halo, {{ $user->name }}
        </h1>

        <flux:modal.trigger name="edit-profile">
            <button class="text-cedea-blue hover:bg-cedea-blue/10 ml-4 cursor-pointer rounded-full p-2 transition-colors"
                title="Edit Profil">
                <x-lucide-square-pen class="h-6 w-6 md:h-8 md:w-8" />
            </button>
        </flux:modal.trigger>
    </div>

    <div class="mb-2 w-fit rounded-full bg-green-400 px-3 py-1 text-white opacity-70" x-data="{ showToast: @entangle('showToast') }"
        x-effect="if (showToast) setTimeout(function() {showToast = false}, 5000)"
        x-on:profile-updated="showToast = true" x-show.transition.duration.300ms="showToast" x-cloak>
        Profile berhasil diupdate
    </div>

    {{-- Display Detail Profil --}}
    <p class="max-md:text-sm">{{ $user->address }}</p>

    {{-- Pesan Verifikasi Umum --}}
    @if (!$user->isVerified())
        <p class="text-cedea-red/70 max-md:text-xs">Silahkan verifikasi email atau whatsapp anda terlebih dahulu</p>
    @endif

    {{-- @if (!$user->isVerified())
        <p class="text-cedea-red/70 max-md:text-xs">Silahkan verifikasi whatsapp anda terlebih dahulu</p>
    @endif --}}

    {{-- Display Phone --}}
    @if (!empty($user->phone) && !$user->hasVerifiedPhone())
        <livewire:dashboard-phone-verify>
        @else
            <p class="inline-flex items-center max-md:text-sm">
                {{ $user->phone }}
                @if ($user->hasVerifiedPhone())
                    <span class="ml-2 inline-block size-6 rounded-full text-green-300">
                        <x-lucide-circle-check-big />
                    </span>
                @endif
            </p>
    @endif

    {{-- Display Email --}}
    @if (!empty($user->email) && !$user->hasVerifiedEmail())
        <livewire:dashboard-email-verify>
        @else
            <p class="inline-flex items-center max-md:text-sm">
                {{ $user->email }}
                @if ($user->hasVerifiedEmail())
                    <span class="ml-2 inline-block size-6 rounded-full text-green-300">
                        <x-lucide-circle-check-big />
                    </span>
                @endif
            </p>
    @endif

    {{-- <p class="inline-flex items-center max-md:text-sm">
        {{ $user->email }}
        @if ($user->hasVerifiedEmail())
            <span class="ml-2 inline-block size-6 rounded-full text-green-300">
                <x-lucide-circle-check-big />
            </span>
        @endif
    </p> --}}


    @if (!empty($user->social))
        <p class="text-cedea-blue mb-2">Sosial Media:</p>
        <ul class="my-2 flex w-full list-inside list-none flex-col space-y-1 max-md:text-sm">
            @foreach ($user->social as $key => $value)
                @if ($value)
                    <li>
                        <p class="flex flex-wrap items-center text-ellipsis">
                            <span class="text-cedea-blue inline-flex items-center uppercase">
                                <flux:icon.at-symbol class="max-w-12" />{{ $key }}:&nbsp;</span>
                            {{ !empty($value) ? $value : '-' }}
                        </p>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <p class="text-cedea-red">Edit profile untuk menambah sosial media kamu</p>
    @endif
</div>
