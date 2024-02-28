<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\IoTDeviceController;
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
    
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('otp', [AuthController::class, 'otp'])->name('otp');
    Route::post('verify-otp', [AuthController::class,'verifyOtp'])->name("otp.verify");
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
    Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::post('iotdevices/update-speed', [IoTDeviceController::class, 'updateSpeed'])->name('iotdevices.speed');
    Route::get('/iotdevices/create', [IoTDeviceController::class, 'create'])->name("iotdevices.create");
    Route::get('/iotdevice/working', [IoTDeviceController::class, 'iotWorking'])->name("iotdevice.working");
    Route::post('iotdevices', [IoTDeviceController::class, 'store'])->name('iotdevices.store');
   
    Route::post('/iotdevices/direct', [IoTDeviceController::class, 'directIoT'])->name("directIoT.send");
    
    Route::post('/iotdevices/blockchain', [IoTDeviceController::class, 'blockchain'])->name("blockchain.send");

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
