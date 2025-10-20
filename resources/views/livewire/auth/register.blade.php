<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" wire:submit="register">
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
            <flux:label class="text-white">Alamat</flux:label>
            <flux:textarea class="text-black" name="address" wire:model="address" required
                placeholder="Alamat lengkap" />
            <flux:error class="" name="address" />
        </flux:field>

        <!-- no hp -->
        <flux:field>
            <flux:label class="text-white">No. HP</flux:label>
            <flux:input class="text-black" name="phone" type="phone" wire:model="phone" required
                autocomplete="phone" placeholder="Isi nomor handphone kamu" />
            <flux:error class="" name="phone" />
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label class="text-white">{{ __('Password') }}</flux:label>
            <flux:input class="text-black" name="password" type="password" wire:model="password" required
                autocomplete="new-password" :placeholder="__('Password')" viewable />
            <flux:error class="" name="password" />
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label class="text-white">{{ __('Confirm password') }}</flux:label>
            <flux:input class="text-black" name="password_confirmation" type="password"
                wire:model="password_confirmation" required autocomplete="new-password"
                :placeholder="__('Confirm password')" viewable />
            <flux:error class="" name="password_confirmation" />
        </flux:field>

        {{-- Term --}}
        <flux:field variant="inline">
            <flux:checkbox wire:model="accept_terms" />
            <flux:label>
                <p class="text-white">
                    Dengan mendaftar saya setuju dengan</span>
                    <span class="font-bold">
                        Syarat & Ketentuan Program Undian CEDEA Eomuk Bar RTE
                    </span>
                </p>
            </flux:label>
            <flux:error name="accept_terms" />
        </flux:field>

        <div class="flex items-center justify-end">
            <flux:button class="w-fit bg-amber-400 !px-8" data-test="login-button" variant="primary" type="submit">
                Daftar sekarang
            </flux:button>
        </div>
    </form>

    <flux:link class="text-center text-white" :href="route('login')">Sudah punya akun</flux:link>
</div>
