@extends('layout')

@section('title', 'Privacy notice — ' . config('app.name', 'Laravel'))

@section('content')
<main class="mx-auto w-full max-w-3xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8 lg:py-12">
    <header class="mb-8">
        <p class="text-xs text-base-content/45">
            <a href="{{ route('text-to-sql') }}" class="link link-hover">← Back to demo</a>
        </p>
        <h1 class="mt-4 text-2xl font-semibold tracking-tight text-base-content sm:text-3xl">
            Privacy notice
        </h1>
        <p class="mt-2 text-sm text-base-content/55">
            Last updated: {{ now()->format('F j, Y') }}
        </p>
    </header>

    <div class="space-y-8 text-sm leading-relaxed text-base-content/80">
        <p>
            This site is a personal portfolio demo for natural-language database queries.
            It is not a commercial product. There are no user accounts or sign-in.
        </p>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Who operates this site</h2>
        <p>
            The demo is run by the owner of this deployment (the “operator”).
            Hosting is provided by
            <a href="https://forge.laravel.com" rel="noopener noreferrer" target="_blank" class="link link-primary">Laravel Forge</a>.
        </p>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">What we collect</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>
                <strong>Questions you submit</strong> — the text you type, the SQL generated for it,
                a short explanation, and the query results shown in the app.
            </li>
            <li>
                <strong>Technical data</strong> — your IP address is used for rate limiting and abuse prevention;
                standard server and application logs may include request metadata.
            </li>
            <li>
                <strong>Essential cookies</strong> — Laravel session and CSRF cookies so the form works securely.
                We do not use advertising or analytics cookies on this demo.
            </li>
        </ul>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">How we use it</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>To generate and run read-only SQL against the demo store database.</li>
            <li>To show question history in the sidebar on this deployment (shared across all visitors).</li>
            <li>To enforce usage limits and keep the service stable.</li>
        </ul>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Third-party services</h2>
        <p>
            Your question and database schema context are sent to
            <a href="https://www.anthropic.com/privacy" rel="noopener noreferrer" target="_blank" class="link link-primary">Anthropic</a>
            to produce SQL. Anthropic processes that content under their own terms and privacy policy.
            Do not submit passwords, financial data, or other sensitive personal information.
        </p>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Demo data</h2>
        <p>
            The database contains fictional e-commerce sample data (products, orders, customers, and similar).
            That data is not real people’s information.
        </p>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Retention</h2>
        <p>
            Submitted questions and results are stored in the application database until you delete them
            from the sidebar, the operator removes them, or the database is reset. Server logs may be
            retained according to the hosting provider’s policies.
        </p>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Your choices</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Do not use the demo if you do not agree with this notice.</li>
            <li>Only ask questions about the demo data; avoid typing real personal details.</li>
            <li>
                Delete individual history entries from the sidebar at any time. Because there are no
                accounts, history is shared on this deployment — deleting an entry removes it for everyone.
            </li>
            <li>
                For broader deletion requests (for example, server logs), contact the operator
                @if ($contactEmail = config('mail.from.address'))
                    at <a href="mailto:{{ $contactEmail }}" class="link link-primary">{{ $contactEmail }}</a>.
                @else
                    using the contact details published with this deployment.
                @endif
            </li>
        </ul>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Security</h2>
        <p>
            Queries are restricted to read-only SQL, but this remains an experimental demo.
            Use it at your own discretion; the operator does not guarantee availability or accuracy.
        </p>
        </section>

        <section class="space-y-3">
        <h2 class="text-base font-semibold text-base-content">Changes</h2>
        <p>
            This notice may be updated from time to time. The “Last updated” date at the top reflects the latest version.
        </p>
        </section>
    </div>
</main>
@endsection
