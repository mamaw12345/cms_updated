<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FAQcontroller;
use App\Http\Controllers\GuideController;
use App\Models\ProsperGuide;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();
//     return redirect('/login');
// })->name('logout');//may problem pa



Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product_id}/qr', [ProductController::class, 'generateQr'])->name('products.generateQr');
Route::get('/products/{id}/qr', [ProductController::class, 'viewQr'])->name('products.viewQr');
Route::get('/products/verify/{product_id}', [ProductController::class, 'verify'])->name('products.verify');

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');//->middleware('auth'); <--if need ng login

Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blogs/edit/{blogID}', [BlogController::class, 'edit'])->name('blog.edit');
Route::put('/blogs/update/{blogID}', [BlogController::class, 'update'])->name('blog.update');
Route::post('/blogs/bulk-update', [BlogController::class, 'bulkUpdate'])->name('blog.bulkUpdate');
Route::get('/blogs/add', [BlogController::class, 'add'])->name('blog.add');
Route::post('/blogs/store', [BlogController::class, 'store'])->name('blog.store');

Route::get('/FAQs', [FAQcontroller::class, 'index'])->name('faqs.index');
Route::post('/FAQs/updateStatus', [FAQcontroller::class, 'updateStatus'])->name('faq.updateStatus');
Route::get('/FAQs/edit/{id}', [FAQcontroller::class, 'edit'])->name('faq.edit');
Route::put('/FAQs/update/{id}', [FAQcontroller::class, 'update'])->name('faq.update');
Route::get('/FAQs/add', [FAQcontroller::class, 'add'])->name('faq.add');
Route::put('/FAQs', [FAQcontroller::class, 'store'])->name('faqs.store');

Route::get('/prosperGuide', [GuideController::class, 'index'])->name('guide.index');
Route::get('/prosperGuide/edit/{zodiacID}', [GuideController::class, 'edit'])->name('guide.edit');
Route::put('/prosperGuide/edit/{zodiacID}', [GuideController::class, 'update'])->name('guide.update');
Route::post('/prosperGuide/bulk-update', [GuideController::class, 'bulkUpdate'])->name('guide.bulkUpdate');

