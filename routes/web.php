<?php

use App\Http\Controllers\TextToSqlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TextToSqlController::class, 'index'])->name('text-to-sql');
Route::post('/', [TextToSqlController::class, 'generate'])->name('text-to-sql.generate');