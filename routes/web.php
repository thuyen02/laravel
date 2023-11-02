<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\SuppilerController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\UnitController;
use Illuminate\Http\Request;
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
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin.login');

Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        //Category Routes
        Route::get('/Units', [UnitController::class, 'index'])->name('unit.index');
        Route::get('/Units/create', [UnitController::class, 'create'])->name('unit.create');
        Route::post('/Units', [UnitController::class, 'store'])->name('unit.store');
        Route::get('/Units/{Unit}/edit', [UnitController::class, 'edit'])->name('unit.edit');
        Route::put('/Units/{Unit}', [UnitController::class, 'update'])->name('unit.update');
        Route::delete('/Units/{Unit}', [UnitController::class, 'destroy'])->name('unit.delete');

        Route::get('/getunit', function (Request $request) {
            $unit_code ="";
            if (!empty($request->title)) {
             echo "loci";
            }
            return response()->json([
                'status' => true,
                'unit_code' => $unit_code
            ]);
        })->name('Get.unit_code');
});
//Suppiler route
        Route::get('/Suppiler', [SuppilerController::class, 'index'])->name('suppiler.index');
        Route::get('/Suppiler/create', [SuppilerController::class, 'create'])->name('suppiler.create');
        Route::post('/Suppiler', [SuppilerController::class, 'store'])->name('suppiler.store');
        Route::get('/Suppiler/{Suppiler}/edit', [SuppilerController::class, 'edit'])->name('suppiler.edit');
        Route::put('/Suppiler/{Suppiler}', [SuppilerController::class, 'update'])->name('suppiler.update');
        Route::delete('/Suppiler/{Suppiler}', [SuppilerController::class, 'destroy'])->name('suppiler.delete');
        Route::get('/suppiler', function (Request $request) {
            $suppiler_code ="";
            if (!empty($request->title)) {
             echo "loci";
            }
            return response()->json([
                'status' => true,
                'suppiler_code' => $suppiler_code
            ]);
        })->name('Get.suppiler_code');
    //Category route
    Route::get('/Category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/Category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/Category/{Category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/Category/{Category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/Category/{Category}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/Category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category', function (Request $request) {
        $Category_code ="";
        if (!empty($request->title)) {
         echo "loci";
        }
        return response()->json([
            'status' => true,
            'category_code' => $Category_code
        ]);
    })->name('Get.category_code');
    //products route
    Route::get('/Products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/Products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/Products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/Products/{Product}/edit', [ProductsController::class, 'edit'])->name('Products.edit');

    Route::get('/products', function (Request $request) {
        $Product_code ="";
        if (!empty($request->title)) {
         echo "loci";
        }
        return response()->json([
            'status' => true,
            'product_code' => $Product_code
        ]);
    })->name('Get.product_code');

    Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

});