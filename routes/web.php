<?php

use App\Http\Controllers\TextToSqlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TextToSqlController::class, 'index'])->name('text-to-sql');
Route::post('/', [TextToSqlController::class, 'generate'])->middleware('throttle:text-to-sql-generate')->name('text-to-sql.generate');
Route::delete('/delete-question', [TextToSqlController::class, 'deleteQuestion'])->middleware('throttle:text-to-sql-delete')->name('text-to-sql.delete');
Route::view('/privacy', 'privacy')->name('privacy');
