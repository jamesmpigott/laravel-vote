<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PollController;
use App\Http\Controllers\Api\VoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/create/poll', [PollController::class, 'create']);
    Route::get('/get-user-polls', [PollController::class, 'userPolls']);
});

Route::get('polls/', [PollController::class, 'index']);
Route::get('polls/{poll}', [PollController::class, 'show']);
Route::post('vote', [VoteController::class, 'processVote']);