<div class="overflow-clip rounded-lg bg-white p-1">
    <img class="rounded-md" src="{{ $submission->getFirstMediaUrl('submissions') }}"
        alt="submission {{ $submission->created_at ? $submission->created_at->format('d F Y') : '-' }}" </div>
