<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', '\App\Http\Controllers\WelcomeController@welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/games', [ProfileController::class, 'games'])->name('profile.games');
    Route::get('/profile/events', [ProfileController::class, 'events'])->name('profile.events');
    Route::get('/profile/auctions', [ProfileController::class, 'auctions'])->name('profile.auctions');
    Route::get('/profile/acceptance', [ProfileController::class, 'acceptance'])->middleware(\App\Http\Middleware\isAdmin::class)->name('profile.acceptance');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');

    Route::get('/profile/acceptance/accept/{element}/{id}', [ProfileController::class, 'accept'])->middleware(\App\Http\Middleware\isAdmin::class)->name('profile.acceptance.accept');
    Route::get('/profile/acceptance/decline/{element}/{id}', [ProfileController::class, 'decline'])->middleware(\App\Http\Middleware\isAdmin::class)->name('profile.acceptance.decline');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('welcome', \App\Http\Controllers\WelcomeController::class);
Route::resource('library', \App\Http\Controllers\GameController::class);
Route::resource('comments', \App\Http\Controllers\CommentController::class);
Route::resource('ratings', \App\Http\Controllers\RatingController::class);
Route::resource('auctions', \App\Http\Controllers\AuctionController::class);
Route::resource('events', \App\Http\Controllers\EventController::class);
Route::resource('places', \App\Http\Controllers\PlaceController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/auctions/create', [\App\Http\Controllers\AuctionController::class, 'create'])->name('auctions.create');
    Route::get('/auctions/destroy/{id}', [\App\Http\Controllers\AuctionController::class, 'destroy'])->name('auctions.destroy');
    //Route::get('/profile/auctions', [\App\Http\Controllers\ProfileController::class, 'auctions'])->name('prifle.auctions');
    Route::get('/profile/auctions/destroy/{id}', [\App\Http\Controllers\AuctionController::class,'destroy'])->name('auctions.destroy');
    Route::get('/library/destroy/{id}', [\App\Http\Controllers\GameController::class, 'destroy'])->name('library.destroy');
    //Route::get('/library/edit/{id}', [\App\Http\Controllers\GameController::class, 'edit'])->name('library.edit');
    Route::post('/library/update/{id}', [\App\Http\Controllers\GameController::class, 'update'])->name('library.update');
    Route::post('/ratings/store', [\App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');
    Route::get('events/create', [\App\Http\Controllers\EventController::class,'create'])->name('events.create');
    Route::get('/library/create', [\App\Http\Controllers\GameController::class, 'create'])->name('library.create');
    Route::post('/library/{id}', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/library/show/add/{id}', [\App\Http\Controllers\GameController::class, 'add'])->name('library.show.add');
    Route::get('/events/show/update/{id}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.show.update');
    Route::get('/events/show/cancel/{id}', [\App\Http\Controllers\EventController::class, 'cancel'])->name('events.show.cancel');
    Route::get('/profile/events/destroy/{id}', [\App\Http\Controllers\EventController::class,'destroy'])->name('events.destroy');
    Route::post('/profile/events/{id}', [\App\Http\Controllers\EventController::class, 'update_event'])->name('events.update_event');
    Route::post('/auctions/update/{id}', [\App\Http\Controllers\AuctionController::class, 'update'])->name('auctions.update');
    Route::post('/profile/auctions/{id}', [\App\Http\Controllers\AuctionController::class, 'update'])->name('auctions.update');
    Route::get('/profile/events/deleteFromGames/{id}', [\App\Http\Controllers\GameController::class,'deleteFromGames'])->name('library.deleteFromGames');
});

Route::get('/events/{id}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/library/{id}', [\App\Http\Controllers\GameController::class, 'show'])->name('library.show');
Route::get('search', [\App\Http\Controllers\GameController::class, 'search'])->name('library.index');
Route::get('filter_games', [\App\Http\Controllers\GameController::class, 'filterGames']);
Route::get('filter_auctions', [\App\Http\Controllers\AuctionController::class, 'filterAuctions']);
