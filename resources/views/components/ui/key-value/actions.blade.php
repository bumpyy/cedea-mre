@aware([
    'showDuplicate' => true,
])

<div class="flex space-x-1">
    @if($showDuplicate)
        <button 
            type="button" 
            x-on:click="duplicateRow(index)"
            x-bind:disabled="maxRows && state.length >= maxRows"
            class="w-8 h-8 flex items-center justify-center cursor-pointer hover:bg-gray-800/5 dark:hover:bg-white/5 rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none dark:focus:bg-white/5 focus:bg-gray-800/5 "
            title="Duplicate row"
            data-action="duplicate"
        >
            <x-ui.icon name="document-duplicate" class="size-5"/>
        </button>
    @endif
    
    <button 
        type="button" 
        x-on:click="deleteRow(index)"
        x-bind:disabled="minRows && state.length <= minRows"
        class="w-8 h-8 flex items-center justify-center hover:bg-gray-800/5 dark:hover:bg-white/5 cursor-pointer rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none dark:focus:bg-white/5 focus:bg-gray-800/5 "
        title="Delete row"
        data-action="delete"
    >
        <x-ui.icon name="trash" class="size-5"/>
    </button>
</div>