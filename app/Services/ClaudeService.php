<?php

namespace App\Services;

use App\Repositories\ClaudeRepository;
use Illuminate\Support\Facades\Http;

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
            ])->json();

        $sqlResponse = json_decode($response['content'][0]['text'] ?? '', true);

        if (!is_array($sqlResponse)) {
            return ['error' => 'The model returned an invalid response. Try again.',];
        }

        $validated = $this->sqlValidator->validate($sqlResponse['sql'] ?? '');

        if (isset($validated['error'])) {
            return ['error' => $validated['error'],];
        }

        return [
            'sql' => $validated['sql'],
            'explanation' => $sqlResponse['explanation'],
        ];
    }
}