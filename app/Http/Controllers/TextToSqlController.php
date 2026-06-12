<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\ClaudeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TextToSqlController extends Controller
{
    protected ClaudeService $claudeService;

    public function __construct(ClaudeService $claudeService)
    {
        $this->claudeService = $claudeService;
    }

    public function index(Request $request)
    {
        $questions = Question::orderBy('created_at', 'desc')->get();
        $question = Question::find($request->question_id, ['id', 'question', 'sql_query', 'result']);
        $rows = isset($question) ? json_decode($question->result, true) : null;
        $sql = isset($question) ? $question->sql_query : null;

        return view('text-to-sql', [
            'question' => $question ?? null,
            'rows' => $rows ?? [],
            'sql' => $sql ?? null,
            'questions' => $questions,
        ]);
    }

    public function generate(Request $request)
    {
        $maxQuestionLength = config('ai.limits.max_question_length');
        $request->validate([
            'question' => "required|string|max:{$maxQuestionLength}",
        ]);

        try {
            $sqlResult = $this->claudeService->generateSqlQuery($request->question);

            if (isset($sqlResult['error'])) {
                return response()->json(['error' => $sqlResult['error']]);
            }

            $sqlQuery = $sqlResult['sql'];
            $sqlExplanation = $sqlResult['explanation'];

            $connection = config('ai.databases.text_to_sql_ai.connection', 'mysql');
            $data = DB::connection($connection)->select($sqlQuery);

            $question = Question::updateOrCreate(
                [
                    'id' => $request->question_id,
                ],
                [
                    'question' => $request->question,
                    'sql_query' => $sqlQuery,
                    'sql_explanation' => $sqlExplanation,
                    'result' => json_encode($data),
                ]
            );

            $resultsHtml = view('text-to-sql.partials.results', [
                'rows' => $data,
                'sql' => $sqlQuery,
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
