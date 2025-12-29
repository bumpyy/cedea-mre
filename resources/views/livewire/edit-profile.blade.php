<flux:modal class="max-w-7xl!" name="edit-profile">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Edit Profil</flux:heading>
            {{-- <flux:subheading>Perbarui data diri Anda untuk keperluan pengundian.</flux:subheading> --}}
        </div>

        <form class="space-y-4" wire:submit="save">

            <flux:separator text="Informasi Pribadi" />

            {{-- Nama Lengkap --}}
            <flux:input label="Nama Lengkap" wire:model="name" icon="user" autocomplete="name"
                placeholder="Nama kamu" />

            {{-- Alamat / Domisili --}}
            <flux:textarea label="Domisili / Kota" wire:model="address" icon="map-pin" autocomplete="street-address"
                placeholder="Contoh: Jakarta Selatan" />

            <flux:separator text="Kontak & Sosial Media" />

            {{-- Email --}}
            {{-- <flux:input type="email" label="Email" wire:model="email" icon="envelope" autocomplete="email" /> --}}

            {{-- No WhatsApp (08...) --}}
            {{-- <flux:input type="tel" label="No. WhatsApp" wire:model="phone" icon="phone" autocomplete="tel"
                placeholder="08xxxxxxxxxx" description="Pastikan nomor terhubung dengan WhatsApp." /> --}}

            {{-- Social Media (Single Input) --}}
            <flux:input label="X" wire:model="social.x" icon="at-symbol" placeholder="@username" />
            <flux:input label="TikTok" wire:model="social.tiktok" icon="at-symbol" placeholder="@username" />
            <flux:input label="Instagram" wire:model="social.instagram" icon="at-symbol" placeholder="@username" />
            <flux:input label="Facebook" wire:model="social.facebook" icon="at-symbol" placeholder="@username" />

            <flux:separator text="Ubah password (kosongkan jika tidak diubah)" />

            <flux:field>
                <flux:label class="">Password Lama</flux:label>
                <flux:input class="" name="current_password" type="current" wire:model="current_password"
                    :placeholder="__('Password Lama')" viewable />
                <flux:error class="" name="current_password" />
            </flux:field>

            <flux:field>
                <flux:label class="">Password Baru</flux:label>
                <flux:input class="" name="new_password" type="password" wire:model="new_password"
                    :placeholder="__('Password Baru')" viewable />
                <flux:error class="" name="password" />
            </flux:field>

            <!-- Confirm Password -->
            <flux:field>
                <flux:label class="">Confirm password baru</flux:label>
                <flux:input class="" name="new_password_confirmation" type="password"
                    wire:model="new_password_confirmation" :placeholder="__('Confirm password Baru')" viewable />
                <flux:error class="" name="new_password_confirmation" />
            </flux:field>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-end gap-2 border-t border-zinc-100 pt-4 dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan...</span>
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
