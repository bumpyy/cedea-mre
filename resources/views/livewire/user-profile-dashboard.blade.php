<div>
    <form class="my-6 w-full space-y-6" wire:submit="updateProfileInformation">
        <flux:field>
            <flux:label class="text-white">{{ __('Name') }}</flux:label>
            <flux:input class="text-black" name="name" type="text" wire:model="name" required autofocus
                autocomplete="name" />
            <flux:error class="bg-white" name="name" />
        </flux:field>

        <div>
            <flux:field>
                <flux:label class="text-white">{{ __('Email') }}</flux:label>
                <flux:input class="text-black" name="email" type="email" wire:model="email" required
                    autocomplete="email" />
                <flux:error class="bg-white" name="email" />
            </flux:field>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <flux:text class="mt-4">
                        {{ __('Your email address is unverified.') }}

                        <flux:link class="cursor-pointer text-sm" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if (session('status') === 'verification-link-sent')
                        <flux:text class="!dark:text-green-400 mt-2 font-medium !text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button class="w-full" variant="primary" type="submit">{{ __('Save') }}</flux:button>
            </div>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</div>
