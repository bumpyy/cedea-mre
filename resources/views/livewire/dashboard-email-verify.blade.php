<div>
    <div @class(['flex flex-wrap gap-2'])>
        <p @class('max-md:text-sm opacity-35')>{{ auth()->user()->email }}</p>
        <p class="cursor-pointer text-red-600 max-md:text-sm" wire:loading.remove wire:click="sendVerification">
            ⚠ Kirim ulang verifikasi e-mail
        </p>
        <p class="cursor-progress text-red-600 max-md:text-sm" wire:loading>Mengirim email...</p>

    </div>

    @error('email_not_sent')
        <flux:error class="mb-2" name="email_not_sent" />
    @enderror


    @if (session('status') == 'verification-link-sent')
        <flux:text class="!dark:text-green-400 text-green-600! flex flex-col gap-1 font-medium">
            Tautan verifikasi baru telah dikirim ke alamat surel yang Anda berikan saat registrasi.
            <span class="text-sm opacity-50">
                Cek spam jika email verifikasi tidak muncul.
            </span>
        </flux:text>
    @endif
</div>
