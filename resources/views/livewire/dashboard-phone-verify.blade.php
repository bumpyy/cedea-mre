<div>
    @if (!$showOtpForm)
        <div wire:key='field' @class(['flex flex-wrap gap-2'])>
            <p @class('max-md:text-sm opacity-35')>{{ auth()->user()->phone }}</p>
            <p class="cursor-pointer text-red-600 max-md:text-sm" wire:loading.remove wire:click="handleShowOtpForm">
                ⚠ Verifikasi nomor Whatsapp
            </p>
            <p class="cursor-progress text-red-600 max-md:text-sm" wire:loading>Mengirim OTP...</p>
        </div>
    @else
        <div class="inline-flex flex-col gap-4" wire:key='otp'>
            <div @otp-complete="$wire.verifyOtp($event.detail)">
                <x-ui.otp title="Verifikasi Whatsapp"
                    desc="Masukkan kode verifikasi 6 digit yang dikirim ke nomor Whatsapp kamu." wire:model="otpCode" />
            </div>
            <div class="cursor-pointer space-x-1 text-center text-sm rtl:space-x-reverse" wire:click="resetForm">
                Batalkan
            </div>
        </div>
    @endif
</div>
