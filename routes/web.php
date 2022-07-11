<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Exports\ProductExport;
use App\Http\Controllers\SendMailController;
use Symfony\Component\Console\Input\Input as InputInput;
use Illuminate\Http\Request;

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

Route::get('/home', [ProductCategoryController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('user/login');
});

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerAction'])->name('register.action');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');
Route::get('password', [AuthController::class, 'password'])->name('password');
Route::post('password', [AuthController::class, 'passwordAction'])->name('password.action');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:admin')->group(
    function () {
        Route::prefix('admin')->group(function () {
            Route::get('/login', [AdminController::class, 'adminLogin']);
            Route::post('/login', [AdminController::class, 'login'])->name('login.admin');
            Route::get('/user', [UserController::class, 'index'])->name('user');
            Route::get('/user/view_create', [UserController::class, 'create'])->name('view_create');
            Route::post('/user/create', [UserController::class, 'store'])->name('add-user.admin');
            Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
            Route::post('/user/update', [UserController::class, 'update'])->name('update-user.admin');
            Route::delete('/user/delete', [UserController::class, 'delete']);
            Route::get('address/import', [ImportAddressController::class, 'index'])->name('address.import');
            Route::get('address/district/{id}', [UserController::class, 'getAllDistrict'])->name('address.district');
            Route::get('address/commune/{id}', [UserController::class, 'getAllCommune'])->name('address.commune');
        });
    }
);




Route::get('file', 'FileController@index');
Route::post('file', 'Filecontroller@doUpload');

Route::middleware('auth:web')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/category/create', [ProductCategoryController::class, 'create'])->name('create.category');
        Route::post('/category/store', [ProductCategoryController::class, 'store'])->name('store.category');
        Route::get('/category/edit/{id}', [ProductCategoryController::class, 'edit'])->name('edit.category');
        Route::post('/category/update', [ProductCategoryController::class, 'update'])->name('update.category');

        Route::get('/product/index', [ProductController::class, 'index'])->name('product-list');
        Route::get('/product/create', [ProductController::class, 'create'])->name('view_create_product');
        Route::post('/product/store', [ProductController::class, 'store'])->name('create');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('view_edit_product');
        Route::post('/product/update', [ProductController::class, 'update'])->name('update');


        Route::delete('/product/delete', [ProductController::class, 'delete']);
        Route::delete('/category/delete', [ProductCategoryController::class, 'delete']);

        Route::get('/product/downloadPdf', [ProductController::class, 'downloadPdf']);
        Route::post('/product/downloadPdf', [ProductController::class, 'downloadPdf']);

        Route::get('/product/downloadCSV', [ProductController::class, 'export']);
        Route::post('/product/downloadCSV', [ProductController::class, 'export']);
    });
});
