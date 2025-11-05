<div x-data="{ resendText: '{{ __('one-time-passwords::form.resend_code') }}', isResending: false }">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('one-time-passwords::form.one_time_password_form_title') }}
    </h2>
    <form class="mt-6 space-y-6" wire:submit="submitOneTimePassword">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="password">
                {{ __('one-time-passwords::form.password_label') }}
            </label>
            <input
                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                id="one_time_password" type="text" wire:model="oneTimePassword">
            @error('oneTimePassword')
                <p class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button
                class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                type="submit">
                {{ __('one-time-passwords::form.submit_login_code_button') }}
            </button>
        </div>

        <button
            class="m-0 cursor-pointer border-0 bg-transparent p-0 text-left text-sm text-gray-600 transition-opacity duration-300 dark:text-gray-400"
            type="button"
            @click="
                if (!isResending) {
                    isResending = true;
                    resendText = 'Code sent';
                    $wire.resendCode();
                    setTimeout(() => {
                        resendText = '{{ __('one-time-passwords::form.resend_code') }}';
                        isResending = false;
                    }, 2000);
                }
            "
            :class="{ 'underline': !isResending }" x-text="resendText"></button>
    </form>
</div>
