@extends('layout')

@section('title', 'Text to SQL — ' . config('app.name', 'Laravel'))

@section('content')
<main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8 lg:py-12">
    <header class="mb-10 max-w-3xl">
        <h1 class="text-2xl font-semibold tracking-tight text-base-content sm:text-3xl">
            What do you want to know?
        </h1>
        <p class="mt-2 text-sm text-base-content/55">
            Describe the data you need — we’ll turn it into a query.
        </p>
    </header>

    <div class="mb-12 flex flex-col gap-8 lg:flex-row lg:items-start lg:gap-12">
        <aside
            class="lg:order-1 lg:w-56 lg:shrink-0 xl:w-64"
            aria-labelledby="history-label"
        >
            <div class="mb-3 flex items-baseline justify-between gap-2">
                <p id="history-label" class="text-xs text-base-content/45">Earlier questions</p>
                <button
                    type="button"
                    id="clear-history"
                    class="text-xs text-base-content/35 hover:text-error"
                >
                    Clear
                </button>
            </div>

            <div id="history-empty">
                <p class="text-sm leading-relaxed text-base-content/40">Nothing asked yet.</p>
            </div>

            <div
                id="history-list"
                class="hidden max-h-64 space-y-4 overflow-y-auto pr-1 lg:max-h-80"
            ></div>
        </aside>

        <div class="min-w-0 flex-1 lg:order-2">
            <form id="question-form" class="flex flex-col gap-4" action="{{ route('text-to-sql.generate') }}" method="POST">
                @csrf
                <label class="form-control w-full">
                    <span class="sr-only">Your question</span>
                    <textarea
                        id="question-input"
                        name="question"
                        rows="6"
                        class="textarea textarea-lg w-full resize-none rounded-2xl border-base-300/80 bg-base-100 text-base leading-relaxed shadow-sm transition-shadow focus:border-primary/40 focus:shadow-md focus:outline-none"
                        placeholder="Show users who signed up in the last 30 days, newest first…"
                        required
                    ></textarea>
                </label>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs text-base-content/40">
                        <kbd class="kbd kbd-sm">⌘</kbd>
                        <kbd class="kbd kbd-sm">↵</kbd>
                        to run
                    </span>
                    <button type="button" id="generate-btn" class="btn btn-primary rounded-full px-6">
                        <span id="submit-label">Ask</span>
                        <span id="submit-spinner" class="loading loading-spinner loading-sm hidden"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <section class="border-t border-base-300/50 pt-10" aria-labelledby="results-heading">
        <h2 id="results-heading" class="mb-4 text-sm font-medium text-base-content/70">Results</h2>

        <div id="results-container">
        @include('text-to-sql.partials.results', [
                'rows' => $data ?? [],
                'sql' => $sqlQuery ?? null,
            ])
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#generate-btn').on('click', function() {
            $.ajax({
                url: '{{ route('text-to-sql.generate') }}',
                type: 'POST',
                data: $('#question-form').serialize(),
            }).done(function(response) {
                $('#results-container').html(response.htmlContent);
            }).fail(function(xhr, status, error) {
                console.log(xhr.responseText);
            });
        });
    });
</script>
@endpush
