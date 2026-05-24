<?php

namespace App\Http\Controllers;

use App\Services\ClaudeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextToSqlController extends Controller
{
    public function index()
    {
        return view('text-to-sql');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $response = (new ClaudeService())->generateSqlQuery($request->question);

        $sqlResponse = json_decode($response['content'][0]['text'], true);
        $sqlQuery = $sqlResponse['sql'];
        $sqlExplanation = $sqlResponse['explanation'];

        $data = DB::connection('mysql')->select($sqlQuery);

        $htmlContent = view('text-to-sql.partials.results', [
            'rows' => $data,
            'sql' => $sqlQuery,
        ])->render();

        return response()->json([
            'htmlContent' => $htmlContent,
        ]);
    }
}
