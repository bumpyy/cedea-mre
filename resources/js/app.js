// import SwupLivewirePlugin from "@swup/livewire-plugin";
// import Swup from "swup";
import "./globals/modals.js";

// const swup = new Swup({
//     plugins: [new SwupLivewirePlugin()],
// });

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

Alpine.data("otpTimer", (minute) => ({
    loading: false,
    countDown: minute * 60 * 1000,
    countDownTimer: new Date(Date.now() + minute * 60 * 1000).getTime(),
    intervalID: null,
    init() {
        if (!this.intervalID) {
            this.intervalID = setInterval(() => {
                this.countDown = this.countDownTimer - new Date().getTime();
            }, 1000);
        }
    },
    getTime() {
        if (this.countDown < 0) {
            this.clearTimer();
        }

        return this.countDown;
    },
    formatTime(num) {
        var date = new Date(num);
        return new Date(this.countDown).toLocaleTimeString(navigator.language, {
            minute: "2-digit",
            second: "2-digit",
        });
    },
    clearTimer() {
        clearInterval(this.intervalID);
        this.intervalID = null;
    },
}));
