<?php

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

use App\Models\Product;
use App\Models\SiteContent;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    // Fetch dynamic content from database
    $siteContent = SiteContent::all()->groupBy('section');
    
    // Show best products first if any, otherwise latest
    // Only show products explicitly marked as best. Do not fall back to latest products.
    $topProducts = Product::where('is_best', true)
                    ->orderBy('updated_at','desc')
                    ->take(3)
                    ->get();
    $products = Product::orderBy('created_at','desc')->get();
    return view('welcome', compact('topProducts','products', 'siteContent'));
});

// public product detail page
Route::get('product/{product}', function (App\Models\Product $product) {
    // Load reviews with product
    $product->load('reviews');
    return view('product', compact('product'));
})->name('product.show');

// Review submission route
Route::post('product/{product}/review', [ReviewController::class, 'store'])->name('review.store');

// Admin routes: simple session-based auth + admin middleware
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteContentController;

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');

    Route::middleware(['auth','admin'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', function () { return redirect()->route('admin.dashboard'); });
        Route::get('dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');

        Route::resource('products', ProductController::class, ['as' => 'admin']);
        Route::resource('content', SiteContentController::class, ['as' => 'admin']);
    });
});
