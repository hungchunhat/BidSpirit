<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');

Route::controller(AuctionController::class)->group(function () {
    Route::get('/auctions', 'index')->name('auction.index');
    Route::get('/auctions/{auction}', 'show')->name('auction.show');
    Route::get('/auctions/{auction}/edit', 'edit')->name('auction.edit')->middleware('auth')->can('edit-auction','auction');
    Route::post('/add-product','addProduct')->name('auctions.addProduct');
    Route::post('/auctions', 'store')->name('auction.store');
    Route::delete('/auctions', 'destroy')->name('auction.destroy');
    Route::patch('/auctions/{auction}', 'update')->name('auction.update')->middleware('auth')->can('edit-auction','auction');
    Route::patch('/auctions/{auction}/start', 'startAuction')->name('auction.start');
    Route::patch('/auctions/{auction}/end', 'endAuction')->name('auction.end');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('product.index');
    Route::post('/products', 'store')->name('product.store');
    Route::get('/products/{product}/edit', 'edit')->name('product.edit')->middleware('auth')->can('edit-product','product');
    Route::patch('/products{product}', 'update')->name('product.update')->middleware('auth')->can('edit-product','product');
    Route::delete('/products', 'destroy')->name('product.destroy')->middleware('auth');
    Route::post('/products/{id}/fav', 'fav')->name('product.fav')->middleware('auth');
    Route::post('/products/{product}/approve', 'approve')->name('product.approve')->middleware('auth')->can('admin');
    Route::post('/products/{product}/reject', 'reject')->name('product.reject')->middleware('auth')->can('admin');
});
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->middleware('auth');
    Route::get('/profile/watch-list', 'index1')->middleware('auth');
    Route::get('/profile/manage', 'index2')->middleware('auth')->can('admin');
    Route::patch('/profile/{user}', 'update')->name('profile.update');
    Route::patch('/profile/{user}/password', 'updatePassword')->name('profile.password');
    Route::delete('/profile/{user}', 'destroy')->name('profile.destroy');
});
Route::controller(UserController::class)->group(function () {
    Route::delete('/users', 'destroy')->name('user.destroy');
    Route::patch('/users', 'update')->name('user.changeRole');
});
Route::controller(BidController::class)->group(function () {
    Route::post('/bids', 'store')->name('bids.store');
});

Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy']);

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::delete('/feedback', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

