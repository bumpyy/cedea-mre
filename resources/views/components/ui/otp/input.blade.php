@aware(['type' => 'text', 'name' => null])

@php
    $classes = [
        // '[:where(&:first-child)]:rounded-l-box [:where(&:last-child)]:rounded-r-box', // default rounding with zero specificity, allows external classes to override without !
        'text-center text-base max-w-12 w-full h-12',
        'focus:bg-white bg-slate-100', // background
        'text-neutral-900 dark:text-neutral-100 placeholder:text-neutral-400 dark:placeholder:text-neutral-500',
        'border border-black/10 dark:border-white/10', // base border
        'focus:outline-none focus:ring-0 focus:border-2 focus:border-white/15 ',
        'transition duration-300 ease-in-out',
        'shadow-sm',
    ];
@endphp

<input data-slot="otp-input"
    {{ $attributes->merge([
            'name' => $name,
            'type' => $type,
        ])->class($classes) }}
    maxlength="1" required x-on:input="handleInput($el)" x-on:keydown.enter="handleInput($el)"
    x-on:paste="handlePaste($event)" x-on:keydown.backspace="handleBackspace($event)" {{-- accessibilty addons --}}
    autocomplete="one-time-code" x-on:keydown.right="$focus.within($refs.inputsWrapper).next()"
    x-on:keydown.up="$focus.within($refs.inputsWrapper).next()"
    x-on:keydown.left="$focus.within($refs.inputsWrapper).prev()"
    x-on:keydown.down="$focus.within($refs.inputsWrapper).prev()" {{-- on focus select for easy replacement
     NOTE: In Firefox, calling $el.select() immediately after focus does nothing
     if the input was just focused programmatically. Wrapping it in requestAnimationFrame
     defers the selection to the next frame, after the browser has fullly applied focus
     This is the only way I got consistent behavior across Chrome, Safari (maybe haha), and Firefox
     after lot of debugging. --}}
    x-on:focus="requestAnimationFrame(() => $el.select())" />
