<div class="flex flex-col gap-6">
    <x-auth-header title="Buat akun" description="Isi data di bawah untuk membuat akun" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="auth flex flex-col gap-6" method="POST" wire:submit="register">
        <!-- Name -->
        <flux:field>
            <flux:label class="text-white">Nama lengkap</flux:label>
            <flux:input class="text-black" name="name" type="text" wire:model="name" required autofocus
                autocomplete="name" placeholder="Nama lengkap" />
            <flux:error class="" name="name" />
        </flux:field>

        <!-- Email Address -->
        <flux:field>
            <flux:label class="text-white">E-mail</flux:label>
            <flux:input class="text-black" name="email" type="email" wire:model="email" required
                autocomplete="email" placeholder="email@example.com" />
            <flux:error class="" name="email" />
        </flux:field>

        <!-- Address -->
        <flux:field>
            <flux:label class="text-white">Alamat <span class="ml-2 text-xs text-gray-400">Optional</span></flux:label>
            <flux:textarea class="text-black" name="address" wire:model="address" placeholder="Alamat lengkap" />
            <flux:error class="" name="address" />
        </flux:field>

        <!-- no hp -->
        <flux:field>
            {{-- <flux:label class="text-white">No. WhatsApp</flux:label> --}}
            <flux:label class="text-white">No. WhatsApp (untuk verifikasi)</flux:label>

            <flux:input.group>
                {{-- <flux:input.group.prefix class="text-white">+62</flux:input.group.prefix> --}}
                <flux:input class="text-black" name="phone" type="phone" required wire:model="phone"
                    autocomplete="phone" placeholder="Isi nomor WhatsApp kamu (cth: 62823xxxxxxx)" />
            </flux:input.group>

            <flux:error class="" name="phone_formatted" />
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label class="text-white">Password</flux:label>
            <flux:input class="text-black" name="password" type="password" wire:model="password" required
                autocomplete="new-password" :placeholder="__('Password')" viewable />
            <flux:error class="" name="password" />
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label class="text-white">Confirm password</flux:label>
            <flux:input class="text-black" name="password_confirmation" type="password"
                wire:model="password_confirmation" required autocomplete="new-password"
                :placeholder="__('Confirm password')" viewable />
            <flux:error class="" name="password_confirmation" />
        </flux:field>

        {{-- Term --}}
        <div class="flex gap-2">
            <flux:field variant="inline">
                <flux:checkbox wire:model="accept_terms" />

                <flux:error name="accept_terms" />
            </flux:field>
            <flux:label>
                <p class="text-white">
                    Dengan mendaftar, saya setuju dengan
                    <span class="cursor-pointer font-bold" wire:click="showTermsModal">
                        Syarat & Ketentuan yang berlaku
                    </span>
                </p>
            </flux:label>
        </div>

        <div class="flex items-center justify-center">
            <flux:button class="px-8! w-fit bg-amber-400" data-test="login-button" variant="primary" type="submit">
                Daftar sekarang
            </flux:button>
        </div>
    </form>

    <flux:link class="text-center text-white" :href="route('login')">Sudah punya akun</flux:link>

    <x-ui.modal id="terms" closeButton="false" heading="Syarat dan Ketentuan"
        description="Baca syarat dan ketentuan dulu" width="4xl">
        <livewire:terms-list />
    </x-ui.modal>
</div>
