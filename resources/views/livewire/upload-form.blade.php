<div class="flex flex-col rounded-[2rem] bg-white p-8" class="text-cedea-red mb-8 flex flex-col text-center text-xl"
    x-data="{ uploaded: false, uploading: false }" x-on:filepond-upload-started="uploading = true"
    x-on:filepond-upload-completed="
        uploading = false;
        uploaded = true;
    "
    x-on:filepond-upload-reverted="
    uploading = false;
    uploaded = false;
    "
    x-on:filepond-upload-file-removed="
    uploading = false;
    uploaded = false;
    ">

    <form method="POST" wire:submit="submit">
        <x-filepond::upload required wire:model="file" :credits="false" max-file-size="5MB" :accepted-file-types="['image/png', 'image/jpeg', 'image/jpg']" />

        <div class="flex items-center justify-center">
            <div class="flex items-center justify-center">
                <button
                    class="relative inline-flex h-10 w-fit items-center justify-center gap-2 whitespace-nowrap rounded-lg border border-black/10 bg-[var(--color-accent)] bg-amber-400 !px-8 pe-4 ps-4 text-sm font-medium text-[var(--color-accent-foreground)] shadow-[inset_0px_1px_--theme(--color-white/.2)] *:transition-opacity hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] disabled:pointer-events-none disabled:cursor-default disabled:opacity-75 dark:border-0 dark:disabled:opacity-75 [&[disabled]]:pointer-events-none [:is([data-flux-button-group]>&:last-child,_[data-flux-button-group]_:last-child>&)]:border-e-[1px] dark:[:is([data-flux-button-group]>&:last-child,_[data-flux-button-group]_:last-child>&)]:border-e-0 dark:[:is([data-flux-button-group]>&:last-child,_[data-flux-button-group]_:last-child>&)]:border-s-[1px] [:is([data-flux-button-group]>&:not(:first-child),_[data-flux-button-group]_:not(:first-child)>&)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] [[data-flux-button-group]_&]:border-e-0"
                    data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target"
                    wire:loading.attr="disabled" type="submit" x-bind:disabled="!uploaded || uploading"
                    x-bind:loading="uploading">

                    <template x-if="uploading">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="shrink-0 animate-spin [:where(&)]:size-4" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </template>

                    <template x-if="!uploading && uploaded">
                        <span>Submit</span>
                    </template>

                    <template x-if="!uploading && !uploaded">
                        <span>Upload File dulu</span>
                    </template>
                </button>
            </div>
        </div>
    </form>
    @if (session()->has('submission-error'))
        <div class="mt-4 text-red-600">
            <p>{{ session()->get('submission-error') }}</p>
        </div>
    @endif
</div>
