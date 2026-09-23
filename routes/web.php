<?php

use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\BlogController;
use App\Http\Controllers\Site\CafeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\MembershipController;
use App\Http\Controllers\Site\PilatesController;
use App\Http\Controllers\Site\RobotsController;
use App\Http\Controllers\Site\ShopController;
use App\Http\Controllers\Site\SitemapController;
use App\Http\Controllers\Site\TreatmentController;
use App\Http\Controllers\Site\WellnessController;
use App\Livewire\Account\Dashboard;
use App\Livewire\Booking\BookingFlow;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/pilates', PilatesController::class)->name('pilates');
Route::get('/wellness', WellnessController::class)->name('wellness');
Route::get('/treatments/{treatment:slug}', TreatmentController::class)->name('treatments.show');
Route::get('/membership', MembershipController::class)->name('membership');
Route::get('/cafe', CafeController::class)->name('cafe');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/book', BookingFlow::class)->name('book');
Route::get('/contact', ContactController::class)->name('contact');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', Dashboard::class)->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/deploy.php';
