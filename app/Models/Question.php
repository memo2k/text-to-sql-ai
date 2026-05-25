<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'sql_query', 'sql_explanation', 'result'];

    protected function casts(): array
    {
        return [
            'result' => 'array',
        ];
    }
}
