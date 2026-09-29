<?php

namespace App\Http\Controllers;

use App\Models\Question;
use AskSql\AskSql\Facades\AskSql;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TextToSqlController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::orderBy('created_at', 'desc')->get();
        $question = Question::find($request->question_id, ['id', 'question', 'sql_query', 'result']);
        $stored = $question?->result;
        $rows = is_array($stored) ? $stored : (is_string($stored) ? json_decode($stored, true) : null);
        $sql = $question?->sql_query;

        return view('text-to-sql', [
            'question' => $question ?? null,
            'rows' => $rows ?? [],
            'sql' => $sql ?? null,
            'questions' => $questions,
        ]);
    }

    public function generate(Request $request)
    {
        $maxQuestionLength = (int) config('asksql.limits.max_question_length', 2000);
        $request->validate([
            'question' => "required|string|max:{$maxQuestionLength}",
        ]);

        try {
            $result = AskSql::ask($request->string('question')->toString());

            if ($result->failed()) {
                return response()->json(['error' => $result->error]);
            }

            $question = Question::updateOrCreate(
                [
                    'id' => $request->question_id,
                ],
                [
                    'question' => $request->question,
                    'sql_query' => $result->sql,
                    'sql_explanation' => $result->explanation,
                    'result' => $result->rows,
                ]
            );

            $resultsHtml = view('text-to-sql.partials.results', [
                'rows' => $result->rows,
                'sql' => $result->sql,
            ])->render();

            $questionsHtml = view('text-to-sql.partials.questions', [
                'questions' => Question::orderBy('created_at', 'desc')->get(),
                'questionId' => $question->id,
            ])->render();

            return response()->json(['resultsHtml' => $resultsHtml, 'questionsHtml' => $questionsHtml]);
        } catch (\Throwable $e) {
            Log::error($e);

            return response()->json(['error' => 'Something went wrong. Try again.']);
        }
    }

    public function deleteQuestion(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
        ]);

        Question::find($request->question_id)->delete();

        return response()->json(['questionsHtml' => view('text-to-sql.partials.questions', [
            'questions' => Question::orderBy('created_at', 'desc')->get(),
            'questionId' => null,
        ])->render()]);
    }
}
