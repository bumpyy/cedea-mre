import SwupLivewirePlugin from "@swup/livewire-plugin";
import Swup from "swup";

const swup = new Swup({
    plugins: [new SwupLivewirePlugin()],
});

document.addEventListener("DOMContentLoaded", () => {
    Flux.dark = false;
    Flux.appearance = "light";
});

Alpine.data("navigation", () => ({
    navigationMenuOpen: false,
    navigationMenu: "",
    navigationMenuCloseDelay: 200,
    navigationMenuCloseTimeout: null,
    navigationMenuLeave() {
        let that = this;
        this.navigationMenuCloseTimeout = setTimeout(() => {
            that.navigationMenuClose();
        }, this.navigationMenuCloseDelay);
    },
    navigationMenuReposition(navElement) {
        this.navigationMenuClearCloseTimeout();
        this.$refs.navigationDropdown.style.left = navElement.offsetLeft + "px";
        this.$refs.navigationDropdown.style.marginLeft =
            navElement.offsetWidth / 2 + "px";
    },
    navigationMenuClearCloseTimeout() {
        clearTimeout(this.navigationMenuCloseTimeout);
    },
    navigationMenuClose() {
        this.navigationMenuOpen = false;
        this.navigationMenu = "";
    },
}));

Alpine.data("pinHandler", () => ({
    length: 5,
    value: "",
    validation: /\d/g,

    // Helper to get the ref name based on index
    refName(index) {
        return "pin" + index;
    },

    updateValue() {
        this.value = Array.from({ length: this.length }, (empty, index) => {
            const refName = this.refName(index);

            // --- ADD THIS CHECK ---
            // If the ref doesn't exist in $refs yet, just return a space
            if (!this.$refs[refName]) {
                return " ";
            }
            // ---------------------

            return this.$refs[refName].value || " ";
        }).join("");
    },

    // CHANGED: Now accepts 'index' as the second argument
    handleInput(pin, index) {
        const value = pin.value.match(this.validation);

        if (!value || !value.length) {
            pin.value = "";
            return;
        }

        pin.value = value;
        this.updateValue();

        // CHANGED: Pass the numeric index directly
        this.focusNextRef(index);
    },

    // CHANGED: Now accepts 'index' as the second argument
    handlePaste(event, index) {
        const text = event.clipboardData.getData("Text").match(this.validation);
        if (!text || !text.length) {
            event.preventDefault(); // Prevent paste if invalid
            return;
        }

        // CHANGED: 'pastedFrom' is just the index
        const pastedFrom = index;
        const remainingInputs = this.length - pastedFrom;
        const value = text.slice(0, remainingInputs).join("");

        const inputsToUpdate = Array.from(
            Array(remainingInputs),
            (empty, i) => {
                return i + pastedFrom;
            }
        ).splice(0, value.length);

        // Update the values
        inputsToUpdate.forEach((refIndex, i) => {
            // CHANGED: Access ref by string name
            this.$refs[this.refName(refIndex)].value = value[i];
        });

        // Focus the last input we updated
        this.focusNextRef(inputsToUpdate.pop());
        this.updateValue();
    },

    // CHANGED: 'current' is now a number, not a string
    focusNextRef(current) {
        // CHANGED: No more parseInt, 'current' is already a number
        const next = current + 1;

        // CHANGED: Check for ref by string name
        if (!this.$refs[this.refName(next)]) {
            // Focus the last input
            const last = this.length - 1;
            this.$refs[this.refName(last)].focus();
            this.$refs[this.refName(last)].select();
            return;
        }

        // CHANGED: Access ref by string name
        this.$refs[this.refName(next)].focus();
        this.$refs[this.refName(next)].select();
    },

    // CHANGED: 'current' is now a number, not a string
    focusPreviousRef(current) {
        // CHANGED: No more parseInt
        const previous = current - 1;

        // CHANGED: Access ref by string name (and check if it exists)
        if (this.$refs[this.refName(previous)]) {
            this.$refs[this.refName(previous)].focus();
            this.$refs[this.refName(previous)].select();
        }
    },
}));

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("otp-form");
    const inputs = [...form.querySelectorAll("input[type=text]")];
    const submit = form.querySelector("button[type=submit]");

    const handleKeyDown = (e) => {
        if (
            !/^[0-9]{1}$/.test(e.key) &&
            e.key !== "Backspace" &&
            e.key !== "Delete" &&
            e.key !== "Tab" &&
            !e.metaKey
        ) {
            e.preventDefault();
        }

        if (e.key === "Delete" || e.key === "Backspace") {
            const index = inputs.indexOf(e.target);
            if (index > 0) {
                inputs[index - 1].value = "";
                inputs[index - 1].focus();
            }
        }
    };

    const handleInput = (e) => {
        const { target } = e;
        const index = inputs.indexOf(target);
        if (target.value) {
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            } else {
                submit.focus();
            }
        }
    };

    const handleFocus = (e) => {
        e.target.select();
    };

    const handlePaste = (e) => {
        e.preventDefault();
        const text = e.clipboardData.getData("text");
        if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
            return;
        }
        const digits = text.split("");
        inputs.forEach((input, index) => (input.value = digits[index]));
        submit.focus();
    };

    inputs.forEach((input) => {
        input.addEventListener("input", handleInput);
        input.addEventListener("keydown", handleKeyDown);
        input.addEventListener("focus", handleFocus);
        input.addEventListener("paste", handlePaste);
    });
});
