<div class="flex flex-col gap-6">
    <x-auth-header title="Log in" description="Ketik alamat email dan kata sandi untuk log in" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" wire:submit="login">
        <!-- Email Address or Phone -->
        <flux:field class="text-5xl">
            <flux:label class="text-white">Alamat email atau nomor handphone</flux:label>
            <flux:input class="text-black" icon="user" name="emailOrPhone" wire:model="emailOrPhone" required
                autofocus autocomplete="email" />
            <flux:error class="text-white" name="emailOrPhone" />
        </flux:field>

        <!-- Password -->
        <div class="relative">
            <flux:field>
                <flux:label class="text-white">Password</flux:label>
                <flux:input class="text-black" icon="lock-closed" name="password" type="password" wire:model="password"
                    required autocomplete="current-password" placeholder="Password" viewable />
                <flux:error class="text-white" name="password" />
            </flux:field>

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm text-white" :href="route('password.request')">
                    Lupa password ?
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:field variant="inline">
            <flux:checkbox wire:model="remember" />
            <flux:label class="text-white">Ingat saya</flux:label>
            <flux:error name="remember" />
        </flux:field>

        <div class="flex items-center justify-center">
            <flux:button class="w-fit bg-amber-400 !px-8" data-test="login-button" variant="primary" type="submit">
                Log in
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm text-white rtl:space-x-reverse">
            <span>Belum punya akun?</span>
            <flux:link class="font-bold text-white" :href="route('register')">Daftar Yuk</flux:link>
        </div>
    @endif
</div>
