<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name("home");

Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
Route::get('/product/{id}', [HomeController::class, 'show'])->name("product");

Route::post('/checkout', [CheckoutController::class, 'process'])->name("checkout-process");

Route::get('/checkout/{transaction}', [CheckoutController::class, 'checkout'])->name("checkout");

Route::get('checkout/success/{transaction}', [CheckoutController::class, 'success'])->name("checkout-success");

Route::get('/transactions', [TransactionController::class, 'index'])->name("transactions");

Route::get('/transactions/export-pdf/{id}', [TransactionController::class, 'exportPDF'])->name("transactions.export-pdf");

Route::get('/test-email', [TransactionController::class, 'testEmail'])->name('test.email');

Auth::routes();
