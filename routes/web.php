<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashboxController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'redirect'])->name('redirect');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// registration routes
Route::middleware(['auth', 'role:registrar'])->prefix('registrar')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('registration.index');
    Route::get('/analyse', [RegistrationController::class, 'analyse'])->name('registration.analyse');
    Route::get('/{registration}', [RegistrationController::class, 'show'])->name('registration.show');
    Route::post('', [RegistrationController::class, 'store'])->name('registration.store');
    Route::get('/{registration}/edit', [RegistrationController::class, 'edit'])->name('registration.edit');
    Route::put('/{registration}', [RegistrationController::class, 'update'])->name('registration.update');
    Route::delete('/{registration}', [RegistrationController::class, 'destroy'])->name('registration.destroy');
    Route::get('/{registration}/send_doc', [RegistrationController::class, 'send_doc'])->name('registration.send_doc');
    Route::post('/{registration}/send_doc_store', [RegistrationController::class, 'send_doc_store'])->name('registration.send_doc_store');
});

// cashier routes
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->group(function () {
    Route::get('', [CashboxController::class, 'index'])->name('cash.index');
    Route::put('/{orderId}', [CashboxController::class, 'confirmation'])->name('cash.confirmation');
    Route::put('/return/{returnId}', [CashboxController::class, 'return'])->name('cash.return');
    Route::post('/{id}/invoice', [CashboxController::class, 'invoice'])->name('cash.invoice');
    Route::get('/analyse', [CashboxController::class, 'analyse'])->name('cash.analyse');
    Route::get('/report/doctor', [CashboxController::class, 'doctor'])->name('cash.doctor');
    Route::post('/report/doctor', [CashboxController::class, 'filter'])->name('cash.doctor.show');
    Route::post('/export', [CashboxController::class, 'export'])->name('cash.doctor.export');
    Route::get('/debts', [CashboxController::class, 'debts'])->name('cash.debts');
    Route::put('/debts/{id}', [CashboxController::class, 'debts_confirmation'])->name('cash.debts.confirmation');
    Route::post('/debts', [CashboxController::class, 'debts_filter'])->name('cash.debts.filter');
});

// doctor routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    Route::get('/', [DoctorPageController::class, 'index'])->name('doctor.index');
    Route::get('/orders', [DoctorPageController::class, 'orders'])->name('doctor.orders');
    Route::get('/orders/{order}', [DoctorPageController::class, 'show'])->name('doctor.orders.show');
    Route::get('/orders/{order}/edit', [DoctorPageController::class, 'edit'])->name('doctor.orders.edit');
    Route::put('/orders/{order}', [DoctorPageController::class, 'update'])->name('doctor.orders.update');
    Route::delete('/orders/{order}', [DoctorPageController::class, 'destroy'])->name('doctor.orders.destroy');
    Route::get('/analyse', [DoctorPageController::class, 'analyse'])->name('doctor.orders.analyse');
});

// admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // positions crud
    Route::get('/positions', [PositionController::class, 'index'])->name('admin.positions_index');
    Route::post('/positions', [PositionController::class, 'store'])->name('admin.positions_store');
    Route::get('/positions/{position}/edit', [PositionController::class, 'edit'])->name('admin.positions_edit');
    Route::put('/positions/{position}', [PositionController::class, 'update'])->name('admin.positions_update');
    Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('admin.positions_destroy');
    // doctors crud
    Route::get('/doctors', [DoctorController::class, 'index'])->name('admin.doctors_index');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('admin.doctors_store');
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('admin.doctors_edit');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('admin.doctors_update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('admin.doctors_destroy');
    // services crud
    Route::get('/services', [ServiceController::class, 'index'])->name('admin.services_index');
    Route::post('/services', [ServiceController::class, 'store'])->name('admin.services_store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services_edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('admin.services_update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services_destroy');
    // cashiers crud
    Route::get('/cashiers', [CashierController::class, 'index'])->name('admin.cashiers_index');
    Route::post('/cashiers', [CashierController::class, 'store'])->name('admin.cashiers_store');
    Route::get('/cashiers/{cashier}/edit', [CashierController::class, 'edit'])->name('admin.cashiers_edit');
    Route::put('/cashiers/{cashier}', [CashierController::class, 'update'])->name('admin.cashiers_update');
    Route::delete('/cashiers/{cashier}', [CashierController::class, 'destroy'])->name('admin.cashiers_destroy');
    // registrars crud
    Route::get('/registrars', [RegistrarController::class, 'index'])->name('admin.registrars_index');
    Route::post('/registrars', [RegistrarController::class, 'store'])->name('admin.registrars_store');
    Route::get('/registrars/{registrar}/edit', [RegistrarController::class, 'edit'])->name('admin.registrars_edit');
    Route::put('/registrars/{registrar}', [RegistrarController::class, 'update'])->name('admin.registrars_update');
    Route::delete('/registrars/{registrar}', [RegistrarController::class, 'destroy'])->name('admin.registrars_destroy');
    // patients crud
    Route::get('/patients', [PatientController::class, 'index'])->name('admin.patients_index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('admin.patients_show');
    Route::post('/patients', [PatientController::class, 'store'])->name('admin.patients_store');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('admin.patients_edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('admin.patients_update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients_destroy');
    // analyse crud
    Route::get('/analyse', [AdminController::class, 'doctor'])->name('admin.analyse');
    Route::post('/analyse', [AdminController::class, 'filter'])->name('admin.filter');
    Route::post('/export', [AdminController::class, 'export'])->name('admin.export');
});
