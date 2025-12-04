<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" wire:submit="resetPassword">
        <!-- Email Address -->
        <flux:field>
            <flux:label class="text-white">Email atau nomor WhatsApp</flux:label>
            <flux:input class="text-black" name="emailOrPhone" wire:model="emailOrPhone" autocomplete="email" required />
            <flux:error class="bg-white" name="emailOrPhone" />
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
            <flux:button class="bg-cedea-red w-full drop-shadow-lg" type="submit" variant="primary">
                {{ __('Reset password') }}
            </flux:button>
        </div>
    </form>
</div>
