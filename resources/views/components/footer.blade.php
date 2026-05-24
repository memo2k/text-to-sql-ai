@props([
    'text' => null,
])

<footer {{ $attributes->merge(['class' => 'mt-auto shrink-0 border-t border-base-300/80 bg-base-100/80']) }}>
    <div class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-2 px-4 py-6 text-center text-xs text-base-content/45 sm:flex-row sm:px-6 sm:text-left lg:px-8">
        <p>
            {{ $text ?? config('app.name', 'Laravel') }}
        </p>
        <p>&copy; {{ date('Y') }}</p>
        {{ $slot }}
    </div>
</footer>
