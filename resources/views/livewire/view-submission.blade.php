<div class="overflow-hidden rounded-lg bg-white p-1">
    @if ($submission)
        <img class="rounded-md" src="{{ $submission->getFirstMediaUrl('submissions') }}"
            alt="submission {{ $submission->created_at ? $submission->created_at->format('d F Y') : '-' }}" />
    @else
        <p class="text-center text-red-500">Ada yang salah, coba lagi nanti</p>
    @endif
</div>
