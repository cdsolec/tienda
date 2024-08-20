<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuotationController;

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

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', [WelcomeController::class, 'dashboard'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/brands', [WelcomeController::class, 'brands'])->name('brands');
Route::get('/solutions', [WelcomeController::class, 'solutions'])->name('solutions');
Route::get('/conditions', [WelcomeController::class, 'conditions'])->name('conditions');
Route::get('/policy', [WelcomeController::class, 'policy'])->name('policy');
Route::get('/products', [WelcomeController::class, 'products'])->name('products');
Route::get('/product/{product}', [WelcomeController::class, 'product'])->name('product');
Route::get('/product/{product}/stock', [WelcomeController::class, 'stock'])->name('stock');
Route::post('/product/{product}/stock', [WelcomeController::class, 'stock_mail'])->name('stock.mail');
Route::get('/contact', [WelcomeController::class, 'comments_create'])->name('comments.create');
Route::post('/contact', [WelcomeController::class, 'comments_store'])->name('comments.store');

Route::get('/cart/reload/{type}/{id}', [CartController::class, 'reload'])->name('cart.reload');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::apiResource('cart', CartController::class);

Route::get('/basket/clear', [BasketController::class, 'clear'])->name('basket.clear');
Route::apiResource('basket', BasketController::class);

Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation.index');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/quotation/checkout', [QuotationController::class, 'checkout'])->name('quotation.checkout');
    Route::post('/basket/checkout', [BasketController::class, 'checkout'])->name('basket.checkout');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/orders/{commande}/name', [OrderController::class, 'name'])->name('orders.name');
    Route::get('/orders/{commande}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');
    Route::post('/budgets/{propal}/name', [BudgetController::class, 'name'])->name('budgets.name');
    Route::get('/budgets/{propal}/pdf', [BudgetController::class, 'pdf'])->name('budgets.pdf');

    Route::resource('orders', OrderController::class)->parameters(['orders' => 'commande']);
    Route::resource('budgets', BudgetController::class)->parameters(['budgets' => 'propal']);

    Route::resource('orders.payments', PaymentController::class)->shallow()->parameters(['orders' => 'commande']);
});

/* Mail Preview */
Route::get('/mail/orders/{commande}', [OrderController::class, 'mail'])->name('orders.mail');
