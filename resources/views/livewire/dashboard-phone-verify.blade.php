<div>
    <div @class(['flex flex-wrap gap-2'])>
        <p @class('max-md:text-sm opacity-35')>{{ auth()->user()->phone }}</p>
        <p class="cursor-pointer text-red-600 max-md:text-sm" wire:loading.remove wire:click="sendVerification">
            ⚠ Verifikasi nomor Whatsapp
        </p>

        <p class="cursor-progress text-red-600 max-md:text-sm" wire:loading>Mengirim OTP...</p>
    </div>

    <x-ui.otp title="Verifikasi Nomor telepon"
        desc="Masukkan kode verifikasi 6 digit yang dikirim ke nomor Whatsapp kamu." wire:model="otpCode"
        :length="6" />
</div>
