<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" wire:submit="register">
        <!-- Name -->
        <flux:field>
            <flux:label class="text-white">{{ __('Name') }}</flux:label>
            <flux:input class="text-black" name="name" type="text" wire:model="name" required autofocus
                autocomplete="name" :placeholder="__('Full name')" />
            <flux:error class="bg-white" name="name" />
        </flux:field>

        <!-- Email Address -->
        <flux:field>
            <flux:label class="text-white">{{ __('Email address') }}</flux:label>
            <flux:input class="text-black" name="email" type="email" wire:model="email" required
                autocomplete="email" placeholder="email@example.com" />
            <flux:error class="bg-white" name="email" />
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label class="text-white">{{ __('Password') }}</flux:label>
            <flux:input class="text-black" name="password" type="password" wire:model="password" required
                autocomplete="new-password" :placeholder="__('Password')" viewable />
            <flux:error class="bg-white" name="password" />
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label class="text-white">{{ __('Confirm password') }}</flux:label>
            <flux:input class="text-black" name="password_confirmation" type="password"
                wire:model="password_confirmation" required autocomplete="new-password"
                :placeholder="__('Confirm password')" viewable />
            <flux:error class="bg-white" name="password_confirmation" />
        </flux:field>

        <div class="flex items-center justify-end">
            <flux:button class="w-full" type="submit" variant="primary">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 rtl:space-x-reverse">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')">{{ __('Log in') }}</flux:link>
    </div>
</div>
