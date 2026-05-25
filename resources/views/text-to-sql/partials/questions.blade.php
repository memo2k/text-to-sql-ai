@php
    $questions = $questions ?? collect();
    $hasQuestions = $questions->isNotEmpty();
@endphp

<div id="questions-container">
    @if (! $hasQuestions)
        <p class="text-sm leading-relaxed text-base-content/40">Nothing asked yet.</p>
    @else
        <ul class="space-y-2">
            @foreach ($questions as $question)
                <li>
                    <a href="{{ route('text-to-sql', ['question_id' => $question->id]) }}"
                        class="question-item block w-full rounded-lg px-3 py-2.5 transition-colors hover:bg-base-100 {{ $question->id == $questionId ? 'bg-base-100 ring-1 ring-base-300/80' : '' }}"
                        title="{{ $question->question }}">
                        <span class="line-clamp-2 text-sm leading-snug text-base-content/85">
                            {{ $question->question }}
                        </span>
                        <span class="mt-1 flex items-center gap-2 text-xs text-base-content/40">
                            <time datetime="{{ $question->created_at->toIso8601String() }}">
                                {{ $question->created_at->diffForHumans() }}
                            </time>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
