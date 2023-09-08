<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/language', LanguageController::class)->name('frontend.change-language');

/** news detail  */
Route::get('/news-details/{slug}', [HomeController::class, 'showNews'])->name('news-details');
/** news detail  */
Route::get('/news', [HomeController::class, 'news'])->name('news');
/** news comment */
Route::post('/news-comment', [HomeController::class, 'handleComment'])->name('news-comment');
/** news reply comment */
Route::post('/news-comment-replay', [HomeController::class, 'handleReplay'])->name('news-comment-replay');
/** news delete reply comment */
Route::delete('/news-comment-destroy', [HomeController::class, 'commentDestroy'])->name('news-comment-destroy');
