/*
 |--------------------------------------------------------------------------
 | Panzoom Image Alpine helper
 |--------------------------------------------------------------------------
 | Exposes a global `interactiveImage(imageUrl, imageId)` function that can
 | be used in Blade via x-data="interactiveImage(...)".
 */
document.addEventListener("alpine:init", () => {
    (function () {
        if (typeof window === "undefined") return;

        window.customInteractiveImage = function (imageUrl, imageId) {
            return {
                imageUrl: imageUrl,

                scale: 1,
                rotation: 0,
                x: 0,
                y: 0,

                isPanning: false,
                startX: 0,
                startY: 0,
                initialX: 0,
                initialY: 0,

                minScale: 0.1,
                maxScale: 5,
                step: 0.3,

                init() {
                    this.$nextTick(() => {
                        if (this.$refs.container) {
                            new ResizeObserver(() => {
                                if (
                                    this.scale === 1 &&
                                    this.x === 0 &&
                                    this.y === 0
                                ) {
                                    this.fit();
                                } else {
                                    this.updateConstraints();
                                }
                            }).observe(this.$refs.container);
                        }
                    });
                },

                onImageLoad() {
                    this.fit();
                },

                fit() {
                    if (!this.$refs.container || !this.$refs.image) return;

                    const cW = this.$refs.container.clientWidth;
                    const cH = this.$refs.container.clientHeight;
                    const iW = this.$refs.image.naturalWidth;
                    const iH = this.$refs.image.naturalHeight;

                    const isVertical = this.rotation % 180 !== 0;

                    const visualW = isVertical ? iH : iW;
                    const visualH = isVertical ? iW : iH;

                    const scaleX = cW / visualW;
                    const scaleY = cH / visualH;

                    this.scale = Math.min(scaleX, scaleY, 1) - 0.05;
                    this.x = 0;
                    this.y = 0;
                },

                updateConstraints() {
                    if (!this.$refs.container || !this.$refs.image) return;

                    const cW = this.$refs.container.clientWidth;
                    const cH = this.$refs.container.clientHeight;

                    const isVertical = this.rotation % 180 !== 0;
                    const currentW =
                        (isVertical
                            ? this.$refs.image.naturalHeight
                            : this.$refs.image.naturalWidth) * this.scale;
                    const currentH =
                        (isVertical
                            ? this.$refs.image.naturalWidth
                            : this.$refs.image.naturalHeight) * this.scale;

                    const limitX = currentW > cW ? (currentW - cW) / 2 : 0;
                    const limitY = currentH > cH ? (currentH - cH) / 2 : 0;

                    this.x = Math.max(-limitX, Math.min(limitX, this.x));
                    this.y = Math.max(-limitY, Math.min(limitY, this.y));
                },

                rotate() {
                    this.rotation = (this.rotation + 90) % 360;

                    this.$nextTick(() => {
                        this.updateConstraints();
                    });
                },

                zoomIn() {
                    this.scale = Math.min(
                        this.maxScale,
                        this.scale + this.step
                    );
                    this.updateConstraints();
                },

                zoomOut() {
                    this.scale = Math.max(
                        this.minScale,
                        this.scale - this.step
                    );
                    this.updateConstraints();
                },

                reset() {
                    this.rotation = 0;
                    this.fit();
                },

                handleWheel(e) {
                    e.preventDefault();
                    const delta = e.deltaY > 0 ? -0.1 : 0.1;
                    this.scale = Math.max(
                        this.minScale,
                        Math.min(this.maxScale, this.scale + delta)
                    );
                    this.updateConstraints();
                },

                startDrag(e) {
                    e.preventDefault();
                    if (
                        e.target !== this.$refs.image &&
                        e.target !== this.$refs.container
                    )
                        return;

                    this.isPanning = true;
                    const clientX = e.touches
                        ? e.touches[0].clientX
                        : e.clientX;
                    const clientY = e.touches
                        ? e.touches[0].clientY
                        : e.clientY;

                    this.startX = clientX;
                    this.startY = clientY;
                    this.initialX = this.x;
                    this.initialY = this.y;
                },

                drag(e) {
                    if (!this.isPanning) return;
                    e.preventDefault();

                    const clientX = e.touches
                        ? e.touches[0].clientX
                        : e.clientX;
                    const clientY = e.touches
                        ? e.touches[0].clientY
                        : e.clientY;

                    const deltaX = clientX - this.startX;
                    const deltaY = clientY - this.startY;

                    this.x = this.initialX + deltaX;
                    this.y = this.initialY + deltaY;

                    this.updateConstraints();
                },

                endDrag() {
                    this.isPanning = false;
                },
            };
        };
    })();
});
