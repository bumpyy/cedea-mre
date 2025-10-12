import SwupLivewirePlugin from "@swup/livewire-plugin";
import Swup from "swup";

const swup = new Swup({
    plugins: [new SwupLivewirePlugin()],
});

swup.hooks.on("page:view", (visit) => {
    console.log("New page: ", visit.to.url);
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
