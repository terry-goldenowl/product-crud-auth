<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get("/login", [AuthController::class, 'showLogin'])->name("show-login");
    Route::post("/login", [AuthController::class, 'login'])->name('login');
    Route::get("/register", [AuthController::class, 'showRegister'])->name("show-register");
    Route::post("/register", [AuthController::class, 'register'])->name("register");
});

Route::middleware('auth')->group(function () {
    Route::any("/logout", [AuthController::class, 'logout'])->name('logout');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductsController::class, 'create'])->name('products.create');
    Route::patch('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductsController::class, 'delete'])->name('products.delete');
});
