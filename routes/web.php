<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalibrateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LandDeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QualityDetectorController;
use App\Http\Controllers\SensorController;
use App\Models\Sensor;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('home');

//auth middleware group
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'farmerHome'])->name('home');
    Route::resource('users', UserController::class);
    Route::get("/lands/datatables", [LandController::class, "datatables"]);
    Route::resource('lands', LandController::class);

    //import excel to sensor
    Route::resource('sensor', SensorController::class);
    Route::get('/admin/sensor/show/{id}', [SensorController::class, 'showWithDataRange'])->name('admin.sensor.show');
    Route::post('/admin/sensor/show/{id}', [SensorController::class, 'showWithDataRange'])->name('admin.sensor.show.range');
    Route::put("/admin/sensor/show/{id}", [SensorController::class, "update"]);

    Route::post('/sensor/{sensor_id}/import', [ExcelController::class, "importExcel"]);

    //calibrate
    Route::get('/admin/calibrate/show/{id}', [CalibrateController::class, 'show'])->name('admin.calibrate.show');
    Route::post('/admin/calibrate/getdata/{id}', [CalibrateController::class, 'getData'])->name('calibrate.getdata');

    Route::scopeBindings()->group(function () {
        Route::resource('lands.devices', LandDeviceController::class);
        Route::get('/lands/{land}/quality-detector', [QualityDetectorController::class, 'index'])->name('quality-detector');
    });

});

Route::get('login', [AuthController::class, 'loginPage'])->name('auth.login');
Route::get('register', [AuthController::class, 'registerPage'])->name('auth.register');
Route::post('login-check', [AuthController::class, 'loginCheck'])->name('auth.login.check');
Route::post('register-check', [AuthController::class, 'registerCheck'])->name('auth.register.check');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
