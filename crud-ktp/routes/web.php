<?php

use App\Http\Controllers\CodeDistrict;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdentifyCardController;
use App\Http\Controllers\UserController;

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
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth','verified']], function(){
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::get('/identify-card/import', [IdentifyCardController::class, 'importExportView'])->name('importView');
    Route::post('/identify-card/import', [IdentifyCardController::class, 'import'])->name('import');
    Route::get('/identify-card/export', [IdentifyCardController::class, 'export'])->name('export');
    Route::resource('/identify-card', IdentifyCardController::class);

    Route::resource('/users', UserController::class);

    Route::post('/get-province', [CodeDistrict::class, 'getProvince'])->name('getProvince');
    Route::post('/get-cities', [CodeDistrict::class, 'getCities'])->name('getCities');
    Route::post('/get-city', [CodeDistrict::class, 'getCity'])->name('getCity');
    Route::post('/get-districts', [CodeDistrict::class, 'getDistricts'])->name('getDistricts');
    Route::post('/get-code', [CodeDistrict::class, 'getCode'])->name('getCode');
    Route::get('/check-nik/{nik}', [CodeDistrict::class, 'checkNik'])->name('checkNik');
});
