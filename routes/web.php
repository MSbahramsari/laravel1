<?php

use App\Http\Controllers\FactorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::any('/login', [\App\Http\Controllers\AuthorizeController::class, 'loginUser'])->name('login');
Route::any('/register', [\App\Http\Controllers\AuthorizeController::class, 'registerUser'])->name('register');




Route::get('/', function () {
    return redirect()->route('login');
});


Route::view('/login', 'authorize.login')->name('view.login');

Route::view('/register', 'authorize.register')->name('view.register');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/workplace', function () {
        return view('workplace');
    })->name('workplace');

//users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::any('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');


//products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::any('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

//orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/getOrderProduct', [OrderController::class, 'pro'])->name('orders.pro');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::any('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');

//factors
    Route::get('/factors', [FactorController::class, 'index'])->name('factors.index');
    Route::get('/factors/create', [FactorController::class, 'create'])->name('factors.create');
    Route::post('/factors', [FactorController::class, 'store'])->name('factors.store');
    Route::get('/factors/{id}/edit', [FactorController::class, 'edit'])->name('factors.edit');
    Route::any('/factors/{id}', [FactorController::class, 'update'])->name('factors.update');
    Route::post('/factors/{id}/delete', [FactorController::class, 'destroy'])->name('factors.destroy');
});
