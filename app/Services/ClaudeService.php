<?php

namespace App\Services;

use App\Repositories\ClaudeRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    protected PromptService $promptService;
    protected ClaudeRepository $claudeRepository;
    protected SqlValidator $sqlValidator;

    public function __construct(PromptService $promptService, ClaudeRepository $claudeRepository, SqlValidator $sqlValidator)
    {
        $this->promptService = $promptService;
        $this->claudeRepository = $claudeRepository;
        $this->sqlValidator = $sqlValidator;
    }

    public function generateSqlQuery(string $question)
    {
        $apiKey = config('ai.anthropic.api_key');

        if (!is_string($apiKey) || $apiKey === '') {
            Log::error('Claude API key is not configured.');
            return ['error' => 'Something went wrong. Try again later.'];
        }

        $schema = $this->promptService->buildSchemaPrompt('text_to_sql_ai');

        $system = $this->claudeRepository->getSystemPrompt();
        $userMessage = "Schema:\n{$schema}\n\nQuestion: {$question}";

        $response = Http::timeout(60)
            ->withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => config('ai.anthropic.api_version'),
                'content-type' => 'application/json',
            ])
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => config('ai.anthropic.model'),
                'max_tokens' => config('ai.anthropic.max_tokens'),
                'system' => $system,
                'messages' => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

        if ($response->failed()) {
            Log::error('Claude API error: ' . $response->body());
            if ($response->status() === 429) {
                return ['error' => 'AI service is busy. Try again in a moment.'];
            }

            return ['error' => 'Could not reach the AI service. Try again.'];
        }

        $body = $response->json();
        $text = $body['content'][0]['text'] ?? null;

        if (!is_string($text) || trim($text) === '') {
            Log::error('Claude API returned invalid response: ' . $text);
            return ['error' => 'The model returned an invalid response. Try again.'];
        }

        $sqlResponse = json_decode($text, true);

        if (!is_array($sqlResponse)) {
            Log::error('Claude API returned invalid response: ' . $text);
            return ['error' => 'The model returned an invalid response. Try again.'];
        }

        $validated = $this->sqlValidator->validate($sqlResponse['sql'] ?? '');

        if (isset($validated['error'])) {
            Log::error('Claude API returned invalid response: ' . $validated['error']);
            return ['error' => $validated['error']];
        }

        return [
            'sql' => $validated['sql'],
            'explanation' => $sqlResponse['explanation'] ?? '',
        ];
    }
}
