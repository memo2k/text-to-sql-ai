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
                <li class="group">
                    <div class="relative rounded-lg {{ $question->id == $questionId ? 'bg-base-100 ring-1 ring-base-300/80' : '' }}">
                        <a href="{{ route('text-to-sql', ['question_id' => $question->id]) }}"
                            class="question-item block w-full rounded-lg px-3 py-2.5 pr-9 transition-colors hover:bg-base-100"
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

                        <button
                            type="button"
                            class="delete-question btn btn-ghost btn-xs absolute right-1 top-1.5 h-7 min-h-0 gap-1 px-1.5 text-base-content/35 opacity-0 transition-all group-hover:opacity-100 hover:bg-error/10 hover:text-error max-lg:opacity-50"
                            data-question-id="{{ $question->id }}"
                            aria-label="Delete question"
                            title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
