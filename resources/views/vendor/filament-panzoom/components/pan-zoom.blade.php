<x-filament-forms::field-wrapper>
    <div class="relative w-full overflow-hidden rounded-lg border border-gray-200 bg-gray-100" x-data="customInteractiveImage({{ json_encode($getImageUrl()) }}, '{{ $getImageId() }}')"
        style="height: 470px;">

        <div class="relative flex h-full w-full touch-none items-center justify-center overflow-hidden" x-ref="container"
            :class="isPanning ? 'cursor-grabbing' : 'cursor-grab'" @wheel="handleWheel" @mousedown="startDrag"
            @mousemove="drag" @mouseup="endDrag" @mouseleave="endDrag" @touchstart="startDrag" @touchmove="drag"
            @touchend="endDrag">

            <img class="block max-w-none origin-center select-none shadow-sm" x-ref="image" :src="imageUrl"
                :style="`transform: translate(${x}px, ${y}px) rotate(${rotation}deg) scale(${scale}); transition: ${isPanning ? 'none' : 'transform 0.2s ease-out'};`"
                draggable="false" @load="onImageLoad" />

        </div>

        <div
            class="absolute right-4 top-4 z-10 flex flex-col gap-2 rounded-lg border border-gray-200 bg-white/90 p-2 shadow-lg backdrop-blur-sm">
            <button class="rounded p-2 text-gray-600 hover:bg-gray-100" type="button" @click="zoomIn" title="Zoom In">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
            <button class="rounded p-2 text-gray-600 hover:bg-gray-100" type="button" @click="zoomOut"
                title="Zoom Out">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>
            <button class="rounded p-2 text-gray-600 hover:bg-gray-100" type="button" @click="rotate"
                title="Rotate 90deg">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
            </button>
            <button class="rounded p-2 text-gray-600 hover:bg-gray-100" type="button" @click="reset" title="Reset">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>
            </button>
        </div>

        <div
            class="pointer-events-none absolute bottom-4 right-4 rounded-lg border border-gray-200 bg-white/90 px-3 py-1 text-xs font-medium text-gray-600 shadow">
            Scale: <span x-text="Math.round(scale * 100) + '%'"></span> |
            Rot: <span x-text="rotation + '°'"></span>
        </div>

    </div>
</x-filament-forms::field-wrapper>
