<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

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

Route::get('/', [PagesController::class, 'index']);

// Route::resource('/movies', MoviesController::class);

Route::resource('/blog', PostsController::class);

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'movies'])->name('movies');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movie');
// Route::get('/blog', [PostsController::class, 'index'])->name('blog');
Route::post('/blog/search', [PostsController::class, 'search'])->name('search');
Route::post('/blog/sort', [PostsController::class, 'sort'])->name('sort');



Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);

// Route::post('/subscribe', 'SubscriberController@store')->name('subscribe');
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

Route::resource('reviews', ReviewController::class);

// Route::get('/reviews/{movieId}', [ReviewController::class, 'reviewsForMovie']);
Route::get('/reviews/{movieId}', [ReviewController::class, 'reviewsForMovie'])->name('reviews.forMovie');

// routes/web.php

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user_page.dashboard');
    })->name('dashboard');
    Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
});

Route::get('/my-blogs', [PostsController::class, 'myBlogs'])->name('my.blogs');
Route::get('/my-reviews', [ReviewController::class, 'myReviews'])->name('my.reviews');








