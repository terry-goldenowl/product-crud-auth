<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

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
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');

    Route::group(['middleware' => ['role:admin']], function () {
        // Products
        Route::post('/products', [ProductsController::class, 'create'])->name('products.create');
        Route::patch('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductsController::class, 'delete'])->name('products.delete');

        // Users
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::delete('/users/{id}', [UsersController::class, 'deleteUser'])->name('users.delete');
        Route::post('/users/{id}/assign-roles', [UsersController::class, 'assignRoles'])->name('users.roles.assign');

        // Roles
        Route::get('/users-roles', [UsersController::class, 'indexRoles'])->name('users.index-roles');
        Route::get('/users/roles', [RolesController::class, 'getRoles'])->name('users.roles');
        Route::post('/users/roles', [RolesController::class, 'createRole'])->name('create-role');
        Route::delete('/users/roles/{id}', [RolesController::class, 'deleteRole'])->name('delete-role');
        Route::post('/users/roles/{id}', [RolesController::class, 'addPermissionsToRole'])->name('add-permissions-to-role');

        // Permissions
        Route::get('/users/permissions', [PermissionsController::class, 'getPermissions'])->name('users.permissions');
        Route::post('/users/permissions', [PermissionsController::class, 'createPermission'])->name('create-permission');
        Route::delete('/users/permissions/{id}', [PermissionsController::class, 'deletePermission'])->name('delete-permission');
    });
});
