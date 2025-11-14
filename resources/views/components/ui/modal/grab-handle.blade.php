<div class="relative flex justify-center pt-[2px] sm:hidden" x-data="{
    startY: 0,
    currentY: 0,
    moving: false,
    modalContainer: null,
    modalContents: null,

    get distance() {
        return this.moving ? Math.max(0, this.currentY - this.startY) : 0;
    },

    get progress() {
        let progress = Math.max(1 - this.distance / 200, 0.5);

        // don't apply opacity effect untile it move 20%
        if (progress > 0.8) return 1

        return progress
    },

    resetTransform() {
        this.modalContainer.style.transform = '';
        this.modalContainer.style.opacity = 1;
    },

    disableDefaultAnimations() {
        this.modalContents.style.transition = 'none';
    },

    enableDefaultAnimations() {
        this.modalContents.style.transition = '';
    },

    handleTouchStart(event) {
        this.disableDefaultAnimations();
        this.moving = true;
        this.startY = this.currentY = event.touches[0].clientY;
    },

    handleTouchMove(event) {
        if (!this.moving) return;
        this.currentY = event.touches[0].clientY;
        requestAnimationFrame(() => {
            this.modalContainer.style.transform = `translateY(${this.distance}px)`;
            this.modalContainer.style.opacity = this.progress;
        });
    },

    handleTouchEnd() {
        if (!this.moving) return;

        if (this.distance > 100) {
            // Close modal
            $data.close();
        } else {
            // Snap back
            this.enableDefaultAnimations();
            this.resetTransform();
        }

        this.moving = false;
    },
}" x-init="modalContainer = $el.closest('[data-slot=modal-container]');
modalContents = $el.closest('[data-slot=modal-contents]');

// Watch for modal open/close to reset transform
$watch('$data.isOpen', (value) => {
    if (value) {
        // Reset transform when modal opens
        $nextTick(() => {
            resetTransform();
            moving = false;
            startY = currentY = 0;
        });
    }
});"
    x-on:touchstart="handleTouchStart($event)" x-on:touchmove="handleTouchMove($event)" x-on:touchend="handleTouchEnd()"
    x-on:touchcancel="handleTouchEnd()">
    <span class="-translate-1/2 pointer-fine:hidden absolute left-1/2 top-1/2 size-12">
        <!--
            Touch target enhancement: Expands clickable area to 48px for thumb-friendly interaction
            Hidden on precise pointer devices (mouse) - only shows for touch/stylus input
            WCAG guideline: minimum 44px touch targets for accessibility
            @see https://tailwindcss.com/docs/hover-focus-and-other-states#pointer
        -->
    </span>
    <div class="rounded-box h-[5px] w-[10%] bg-neutral-300 transition dark:bg-neutral-700"
        x-bind:class="{ 'scale-x-125': moving }"></div>
</div>
