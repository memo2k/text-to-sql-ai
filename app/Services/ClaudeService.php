<?php

namespace App\Services;

use App\Repositories\ClaudeRepository;
use Illuminate\Support\Facades\Http;

class ClaudeService
{
    public function generateSqlQuery(string $question)
    {
        $apiKey = config('ai.anthropic.api_key');

        $schema = (new PromptService())->buildSchemaPrompt('text_to_sql_ai');

        $system = ClaudeRepository::getSystemPrompt();
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

        return $response->json();
    }
}