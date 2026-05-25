<?php

return [
  'anthropic' => [
    'api_key' => env('ANTHROPIC_API_KEY'),
    'model' => env('ANTHROPIC_MODEL', 'claude-sonnet-4-20250514'),
    'max_tokens' => env('ANTHROPIC_MAX_TOKENS', 2048),
    'api_version' => '2023-06-01',
  ],

  'limits' => [
    'max_rows' => env('ASKSQL_MAX_ROWS', 1000),
    'max_question_length' => 2000,
    'queries_per_hour' => env('ASKSQL_QUERIES_PER_HOUR', 20),
    'statement_timeout_seconds' => 5,
  ],

  'databases' => [
    'text_to_sql_ai' => [
      'name' => 'Text to SQL AI',
      'emoji' => '�',
      'connection' => 'mysql',
      'table_prefix' => 'text_to_sql_ai_',
      'description' => 'Online tech store — customers, orders, products, and categories.',
      'suggestions' => [
        'Top 5 products by total order amount',
        'Products that have never been ordered',
        'Monthly revenue for the last 12 months',
        'Categories with more than 2 products',
      ],
    ],
  ],
];
