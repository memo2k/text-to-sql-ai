@php
    $rows = $rows ?? [];
    $hasResults = count($rows) > 0;
    $columns = $hasResults ? array_keys((array) $rows[0]) : [];
@endphp

<div class="flex flex-col gap-4">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <p id="results-meta" class="text-xs text-base-content/45">
            @if ($hasResults)
                {{ count($rows) }} {{ Str::plural('row', count($rows)) }}
            @else
                Waiting for a question
            @endif
        </p>

        @if ($hasResults)
            <button
                type="button"
                id="export-csv-btn"
                class="btn btn-ghost btn-xs rounded-full px-3 text-base-content/55 hover:text-base-content"
            >
                Export CSV
            </button>
        @endif
    </div>

    @if ($hasResults)
        @if (! empty($sql))
            <div id="sql-preview">
                <details class="group rounded-xl border border-base-300/60 bg-base-100" open>
                    <summary class="cursor-pointer px-4 py-3 text-sm font-medium text-base-content/70 marker:content-none [&::-webkit-details-marker]:hidden">
                        <span class="flex items-center gap-2">
                            <span class="text-base-content/40 transition group-open:rotate-90">›</span>
                            View SQL
                        </span>
                    </summary>
                    <div class="border-t border-base-300/60 px-4 py-3">
                        <pre id="sql-code" class="overflow-x-auto font-mono text-xs leading-relaxed text-base-content/80">{{ $sql }}</pre>
                    </div>
                </details>
            </div>
        @endif

        <div id="results-table-wrap" class="overflow-hidden rounded-2xl border border-base-300/70 bg-base-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead class="bg-base-200/60 text-xs uppercase tracking-wide text-base-content/55">
                        <tr>
                            @foreach ($columns as $column)
                                <th>{{ Str::headline(str_replace('_', ' ', $column)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($rows as $row)
                            @php $row = (array) $row; @endphp
                            <tr class="hover:bg-base-200/40">
                                @foreach ($columns as $column)
                                    <td class="font-normal text-base-content/85">{{ $row[$column] ?? '' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div id="results-empty" class="rounded-2xl border border-dashed border-base-300/70 bg-base-100/60 px-6 py-14 text-center">
            <p class="text-sm text-base-content/40">Results will appear here as a table</p>
        </div>
    @endif
</div>
