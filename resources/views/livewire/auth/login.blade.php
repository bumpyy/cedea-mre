<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" wire:submit="login">
        <!-- Email Address -->
        <flux:field>
            <flux:label class="text-white">{{ __('Email address') }}</flux:label>
            <flux:input class="text-black" name="email" type="email" wire:model="email" required autofocus
                autocomplete="email" placeholder="email@example.com" />
            <flux:error class="bg-white" name="email" />
        </flux:field>

        <!-- Password -->
        <div class="relative">
            <flux:field>
                <flux:label class="text-white">{{ __('Password') }}</flux:label>
                <flux:input class="text-black" name="password" type="password" wire:model="password" required
                    autocomplete="current-password" :placeholder="__('Password')" viewable />
                <flux:error class="bg-white" name="password" />
            </flux:field>

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm text-white" :href="route('password.request')"
                    wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->


        <flux:field variant="inline">
            <flux:checkbox wire:model="remember" />
            <flux:label class="text-white">Remember</flux:label>
            <flux:error name="remember" />
        </flux:field>

        <div class="flex items-center justify-end">
            <flux:button class="w-full" data-test="login-button" variant="primary" type="submit">
                {{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm text-white rtl:space-x-reverse">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link class="text-white" :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
