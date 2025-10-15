import SwupLivewirePlugin from "@swup/livewire-plugin";
import Swup from "swup";

const swup = new Swup({
    // cache: false,
    plugins: [new SwupLivewirePlugin()],
});

const loadingScreen = document.getElementById("loading-screen");

// Durasi jeda di tengah (waktu stop sebelum ganti konten)
const delayInMiddle = 1000; // 1 detik

// Durasi transisi slide kedua (harus sama dengan transisi di CSS .is-leaving: 0.5s = 500ms)
const slideOutDuration = 500;

// 1. visit:start: Tampilkan loading screen dan mulai slide ke tengah (50vh)
swup.hooks.on("visit:start", () => {
    // Reset dan tambahkan 'is-active' untuk memicu slide masuk
    loadingScreen.classList.remove("is-leaving");
    loadingScreen.classList.add("is-active");
});

// 2. animation:out:await: Tahan proses, lakukan jeda, ganti konten, lalu slide keluar penuh
swup.hooks.on("animation:out:await", (visit) => {
    // Kembalikan Promise agar Swup menunggu kita memanggil resolve()
    return new Promise((resolve) => {
        // --- Langkah 1: Stop di tengah (50vh) ---
        // Pindah dari 'is-active' ke 'is-stopped' untuk menonaktifkan transisi
        loadingScreen.classList.remove("is-active");
        loadingScreen.classList.add("is-stopped");

        // * JEDA DI TENGAH (Delay In Middle) *
        setTimeout(() => {
            // --- Langkah 2: GANTI KONTEN (Panggilan Resolve) ---
            // Panggil resolve() di sini!
            // Swup akan: 1) Mengganti konten lama dengan baru;
            // 2) Menghapus kelas 'is-animating' dari <html> (mengakhiri animation:out);
            // 3) Memulai animation:in:start pada konten baru.
            resolve();

            // Tambahkan delay kecil (misalnya 50ms) untuk memastikan
            // Swup selesai mengganti konten sebelum loading screen bergerak
            setTimeout(() => {
                // --- Langkah 3: Slide Keluar Penuh (100vh) ---
                // Pindah dari 'is-stopped' ke 'is-leaving' untuk memicu slide ke bawah
                loadingScreen.classList.remove("is-stopped");
                loadingScreen.classList.add("is-leaving");

                // Konten baru sudah terlihat di belakang loading screen yang sedang bergerak ke bawah.
            }, 50); // Delay kecil sebelum memulai slide keluar
        }, delayInMiddle);
    });
    // CATATAN: Karena kita memanggil resolve() sebelum menunggu slideOutDuration,
    // kita tidak perlu lagi hook 'animation:in:await' secara eksplisit di sini.
});

// 3. animation:in:start: Hapus 'is-active' (tidak diperlukan lagi)
swup.hooks.on("animation:in:start", () => {
    // Di sinilah konten baru sudah dimuat dan Swup memulai animasi masuk (yang diwakili oleh loading screen yang bergerak keluar)
    // Kita biarkan loading screen bergerak keluar di hook 'animation:out:await' sebelumnya.
});

// 4. animation:in:end: Bersihkan semua kelas (loading screen sudah tidak perlu)
swup.hooks.on("animation:in:end", () => {
    loadingScreen.classList.remove("is-active", "is-stopped", "is-leaving");
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
