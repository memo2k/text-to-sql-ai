@props([
    'title' => 'Text to SQL',
    'tagline' => 'Ask in plain language, get table results',
    'homeUrl' => '/',
])

<header {{ $attributes->merge(['class' => 'border-b border-base-300/80 bg-base-100/95 backdrop-blur-md']) }}>
    <div class="mx-auto flex h-14 w-full max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ $homeUrl }}" class="text-base font-semibold tracking-tight text-base-content">
            {{ $title }}
        </a>
        @if ($tagline)
            <p class="hidden text-sm text-base-content/50 sm:block">
                {{ $tagline }}
            </p>
        @endif
        {{ $slot }}
    </div>
</header>
