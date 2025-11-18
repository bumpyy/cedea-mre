@props([
    'digits' => 6,
    'name' => 'otpCode',
    'title' => null,
    'desc' => null,
])

<div class="mx-auto w-full max-w-6xl bg-white md:px-6" x-data="{
    totalDigits: @js($digits),
    digitIndices: @js(range(1, $digits)),
    init() {
        $nextTick(() => {
            this.$refs.input1?.focus();
        });
    },
    getInput(index) {
        return this.$refs['input' + index];
    },
    setValue(index, value) {
        this.getInput(index).value = value;
    },
    getCode() {
        return this.digitIndices
            .map(i => this.getInput(i).value)
            .join('');
    },
    updateHiddenField() {
        this.$refs.code.value = this.getCode();
        this.$refs.code.dispatchEvent(new Event('input', { bubbles: true }));
        this.$refs.code.dispatchEvent(new Event('change', { bubbles: true }));
    },
    handleNumberKey(index, key) {
        this.setValue(index, key);

        if (index < this.totalDigits) {
            this.getInput(index + 1).focus();
        }

        $nextTick(() => {
            this.updateHiddenField();
        });
    },
    handleBackspace(index) {
        const currentInput = this.getInput(index);

        if (currentInput.value !== '') {
            currentInput.value = '';
            this.updateHiddenField();
            return;
        }

        if (index <= 1) {
            return;
        }

        const previousInput = this.getInput(index - 1);

        previousInput.value = '';
        previousInput.focus();

        this.updateHiddenField();
    },
    handleKeyDown(index, event) {
        const key = event.key;

        if (/^[0-9]$/.test(key)) {
            event.preventDefault();
            this.handleNumberKey(index, key);
            return;
        }

        if (key === 'Backspace') {
            event.preventDefault();
            this.handleBackspace(index);
            return;
        }

        // // Trigger completion event when all boxes filled
        // if (value.length === this.length) {
        //     // if so wait until the last input get filled then call `onComplete`
        //     $nextTick(() => this.onComplete());
        // }
    },
    handlePaste(event) {
        event.preventDefault();

        const pastedText = (event.clipboardData || window.clipboardData).getData('text');
        const numericOnly = pastedText.replace(/[^0-9]/g, '');
        const digitsToFill = Math.min(numericOnly.length, this.totalDigits);

        this.digitIndices
            .slice(0, digitsToFill)
            .forEach(index => {
                this.setValue(index, numericOnly[index - 1]);
            });

        if (numericOnly.length >= this.totalDigits) {
            this.updateHiddenField();
            $nextTick(() => this.onComplete());
        }

    },
    onComplete() {
        this.$dispatch('otp-complete');
    },
    clearAll() {
        this.digitIndices.forEach(index => {
            this.setValue(index, '');
        });

        this.$refs.code.value = '';
        this.$refs.input1?.focus();
    }
}">
    <div class="flex justify-center">
        <div class="mx-auto max-w-md rounded-xl bg-white px-4 py-10 text-center shadow sm:px-8">

            @if ($title && $desc)
                <header class="mb-8">
                    @if ($title)
                        <h1 class="mb-1 text-2xl font-bold">{{ $title }}</h1>
                    @endif
                    @if ($desc)
                        <p class="text-[15px] text-slate-500">{{ $desc }}</p>
                    @endif
                </header>
            @endif

            <div class="flex items-center justify-center">
                @for ($x = 1; $x <= $digits; $x++)
                    <input x-ref="input{{ $x }}" type="text" inputmode="numeric" pattern="[0-9]"
                        maxlength="1" autocomplete="off" @paste="handlePaste"
                        @keydown="handleKeyDown({{ $x }}, $event)" @focus="$el.select()"
                        @input="$el.value = $el.value.replace(/[^0-9]/g, '').slice(0, 1)"
                        @class([
                            'flex size-10 items-center justify-center border border-zinc-300 bg-accent-foreground text-center text-sm font-medium text-accent-content transition-colors focus:border-accent focus:border-2 focus:outline-none focus:relative focus:z-10',
                            'rounded-l-md' => $x === 1,
                            'rounded-r-md' => $x === $digits,
                            '-ml-px' => $x > 1,
                        ]) />
                @endfor
            </div>

            @error('one_time_password')
                <div class="mx-auto mt-4 text-center text-sm text-red-600">
                    {{ $message }}
                </div>
            @enderror

            <div class="mx-auto mt-4 max-w-[260px]">
                <flux:button
                    class="bg-cedea-red hover:bg-cedea-dark focus:ring-cedea-red/30 focus-visible:ring-cedea-red/focus:ring-cedea-red/30 inline-flex w-full justify-center whitespace-nowrap rounded-lg px-3.5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors duration-150 focus:outline-none focus:ring focus-visible:outline-none focus-visible:ring"
                    data-test="otp-button" variant="primary" type="submit">
                    Verifikasi
                </flux:button>
            </div>

            <div class="grid gap-y-2 text-center" x-data="otpTimer(2)"
                x-on:otp-sent="() => {
                this.loading=false;
                init();}
            "
                x-init="init()">
                <div class="mt-4 text-sm text-slate-500">
                    <template x-if="getTime() <= 0">

                        <div>
                            <p x-show="loading">
                                Mengirim OTP lagi
                            </p>

                            <p x-show="!loading">
                                Tidak menerima OTP?
                                <span class="text-cedea-red/80 hover:text-cedea-red cursor-pointer font-medium"
                                    wire:click="resendOtp" @click="loading=true">Kirim
                                    ulang</span>
                            </p>
                        </div>
                    </template>

                    <template x-if="getTime() > 0">
                        <p>
                            kirim lagi OTP dalam
                            <span x-text="formatTime(getTime())"></span>
                        </p>
                    </template>
                </div>
            </div>

            <input {{ $attributes->except(['digits']) }} type="hidden" x-ref="code" wire:model="otpCode"
                name="{{ $name }}" minlength="{{ $digits }}" maxlength="{{ $digits }}" />

        </div>
    </div>


</div>
