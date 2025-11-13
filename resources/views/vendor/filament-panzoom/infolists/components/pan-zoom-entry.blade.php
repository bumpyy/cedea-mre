<div class="relative w-full overflow-hidden rounded-lg border border-gray-200 bg-gray-50" x-data="interactiveImage({{ json_encode($getImageUrl()) }}, '{{ $getImageId() }}', {{ $getDoubleClickZoomLevel() }})"
    style="height: 470px; min-height: 470px; max-height: 470px;">
    <div class="relative h-full w-full" x-ref="container" @wheel.prevent="zoom" @mousemove="pan" @mouseup="endPan"
        @mouseleave="endPan" @touchmove.prevent="touch" @touchend="endTouch">
        <img class="block max-w-none select-none transition-transform duration-75" x-ref="image" :src="imageUrl"
            :style="`transform: translate(${panX}px, ${panY}px) scale(${scale}); transform-origin: 0 0; position: absolute; left: 0; top: 0;`"
            :class="isPanning ? 'cursor-grabbing' : 'cursor-grab'" style="max-width: none; max-height: none;"
            alt="Receipt Image" @load="onImageLoad" @mousedown="startPan" @dblclick="doubleClickZoom"
            @touchstart="startTouch" draggable="false" />
    </div>

    <div class="absolute right-4 top-4 flex flex-col gap-2 rounded-lg bg-white/90 p-2 shadow-lg backdrop-blur-sm">
        <div class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 bg-white text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-800"
            @click="zoomIn" title="Zoom In">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </div>

        <div class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 bg-white text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-800"
            @click="zoomOut" title="Zoom Out">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
            </svg>
        </div>

        <div class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 bg-white text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-800"
            @click="reset" title="Reset View">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
            </svg>
        </div>
    </div>

    <div
        class="absolute bottom-4 right-4 rounded-lg bg-white/90 px-3 py-1 text-sm text-gray-600 shadow-lg backdrop-blur-sm">
        <span x-text="`${Math.round(scale * 100)}%`"></span>
    </div>
</div>
