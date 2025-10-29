@props(['submission' => null])


<div
    class="text-cedea-gold flex items-center gap-4 rounded-lg border-[1px] p-2 pr-6 transition-[background] hover:bg-slate-300/50">
    <div class="bg-cedea-gold basis-20 cursor-pointer rounded-md p-4"
        wire:click="$dispatch('openModal', { component: 'view-submission', arguments: { id: {{ $submission->id }} } })"
        wire:key="{{ $submission->id }}">
        <img class="shrink grow-0 text-white" src="{{ asset('img/receipt.svg') }}" />
    </div>

    <div class="flex w-full items-center justify-between">
        <div>
            <p class="font-bold max-md:text-sm">
                {{ $submission->uuid ? $submission->uuid : '-' }}
            </p>
            <p @class([
                'uppercase',
                'text-yellow-500' =>
                    $submission->status == \App\Enum\SubmissionStatusEnum::PENDING,
                'text-green-500' =>
                    $submission->status == \App\Enum\SubmissionStatusEnum::ACCEPTED,
                'text-red-500' =>
                    $submission->status == \App\Enum\SubmissionStatusEnum::REJECTED,
            ])>{{ $submission->status->value }}</p>
            <p class="text-xs opacity-70 md:text-sm">{{ $submission->status->getDescription() }}</p>
            <p class="text-xs opacity-70 md:text-sm">
                {{ $submission->created_at ? $submission->created_at->format('d F Y, g:i a') : '-' }}</p>
        </div>

        <div class="ml-auto basis-8">
            @switch($submission->status)
                @case(\App\Enum\SubmissionStatusEnum::PENDING)
                    <x-lucide-clock class="text-yellow-500" />
                @break

                @case(\App\Enum\SubmissionStatusEnum::ACCEPTED)
                    <x-lucide-check class="text-green-500" />
                @break

                @case(\App\Enum\SubmissionStatusEnum::REJECTED)
                    <x-lucide-x class="text-red-500" />
                @break
            @endswitch
        </div>
    </div>
</div>
