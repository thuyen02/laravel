<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\MedicalRecordsController;

use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\PatientsController;
use App\Http\Controllers\admin\DoctorsController;
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
        Route::get('/Patients', [PatientsController::class, 'index'])->name('patients.index');
        Route::get('/Patients/create', [PatientsController::class, 'create'])->name('patients.create');
        Route::post('/Patients', [PatientsController::class, 'store'])->name('patients.store');
        Route::get('/Patients/{Patients}/edit', [PatientsController::class, 'edit'])->name('patients.edit');
        Route::put('/Patients/{Patients}', [PatientsController::class, 'update'])->name('patients.update');
        Route::delete('/Patients/{Patients}', [PatientsController::class, 'destroy'])->name('patients.delete');

        Route::get('/getPatients', function (Request $request) {
            $patients_code ="";
            if (!empty($request->title)) {
             echo "loci";
            }
            return response()->json([
                'status' => true,
                'patients_code' => $patients_code
            ]);
        })->name('Get.patients_code');
    });
//Doctors route
        Route::get('/Doctors', [DoctorsController::class, 'index'])->name('doctors.index');
        Route::get('/Doctors/create', [DoctorsController::class, 'create'])->name('doctors.create');
        Route::post('/Doctors', [DoctorsController::class, 'store'])->name('doctors.store');
        Route::get('/Doctors/{Doctors}/edit', [DoctorsController::class, 'edit'])->name('doctors.edit');
        Route::put('/Doctors/{Doctors}', [DoctorsController::class, 'update'])->name('doctors.update');
        Route::delete('/Doctors/{Doctors}', [DoctorsController::class, 'destroy'])->name('doctors.delete');
        Route::get('/getDoctors', function (Request $request) {
            $doctors_code ="";
            if (!empty($request->title)) {
             echo "loci";
            }
            return response()->json([
                'status' => true,
                'doctors_code' => $doctors_code
            ]);
        })->name('Get.doctors_code');




    //Category route
    Route::get('/MedicalRecords', [MedicalRecordsController::class, 'index'])->name('medicalrecords.index');
    Route::post('/MedicalRecords', [MedicalRecordsController::class, 'store'])->name('medicalrecords.store');
    Route::get('/MedicalRecords/{MedicalRecords}/edit', [MedicalRecordsController::class, 'edit'])->name('medicalrecords.edit');
    Route::put('/MedicalRecords/{MedicalRecords}', [MedicalRecordsController::class, 'update'])->name('medicalrecords.update');
    Route::delete('/MedicalRecords/{MedicalRecords}', [MedicalRecordsController::class, 'destroy'])->name('medicalrecords.delete');
    Route::get('/MedicalRecords/create', [MedicalRecordsController::class, 'create'])->name('medicalrecords.create');
    Route::get('/getMedicalRecords', function (Request $request) {
        $MedicalRecords_code ="";
        if (!empty($request->title)) {
         echo "loci";
        }
        return response()->json([
            'status' => true,
            'medicalrecords_code' => $MedicalRecords_code
        ]);
    })->name('Get.medicalrecords_code');
//     //products route
//     Route::get('/Products', [ProductsController::class, 'index'])->name('products.index');
//     Route::get('/Products/create', [ProductsController::class, 'create'])->name('products.create');
//     Route::post('/Products', [ProductsController::class, 'store'])->name('products.store');
//     Route::get('/Products/{Product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
//     Route::put('/Products/{Product}', [ProductsController::class, 'update'])->name('products.update');
//     Route::delete('/Products/{Product}', [ProductsController::class, 'destroy'])->name('products.delete');
    
//     Route::post('/Products-image/update', [ProductImageController::class, 'update'])->name('product-images.update');
//     Route::delete('/Products-image', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
    
    
//     Route::get('/products', function (Request $request) {
//         $Product_code ="";
//         if (!empty($request->title)) {
//          echo "loci";
//         }
//         return response()->json([
//             'status' => true,
//             'product_code' => $Product_code
//         ]);
//     })->name('Get.product_code');

    Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

});