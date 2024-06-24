<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'store'])->name('login.store')->middleware('guest');
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::post('questions/store-contribution', [QuestionController::class, 'store'])->name('questions.store.contribution');

Route::middleware(['auth'])
    ->group(function (){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('questions', QuestionController::class);
        Route::resource('answers', AnswerController::class);
        Route::post('questions/import', [QuestionController::class, 'import'])->name('questions.import');
        Route::get('question/export', [QuestionController::class, 'export'])->name('questions.export');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });

Route::get('ask/{question}', [BotManController::class, 'askOpenAI']);
