<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\CandidateController::class, 'index'])->name('display');

// Initialize the poll tracking
Route::post('/start', [App\Http\Controllers\CandidateController::class, 'start'])->name('start');

// Route for casting vote and passing the ballot placement number as parameter
Route::get('/cast-vote/{ballot}', [App\Http\Controllers\CandidateController::class, 'castVote']);



