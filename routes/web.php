<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class,'chartData'])
    ->name('dashboard.chart.data');
    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:roles.manage')->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:roles.manage')->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:roles.manage')->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:roles.manage')->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:roles.manage')->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.manage')->name('roles.destroy');
  
        // Clients
    Route::get('/clients', [ClientController::class, 'index'])
        ->middleware('permission:clients.view')
        ->name('clients.index');

    Route::get('/clients/create', [ClientController::class, 'create'])
        ->middleware('permission:clients.create')
        ->name('clients.create');

    Route::post('/clients', [ClientController::class, 'store'])
        ->middleware('permission:clients.create')
        ->name('clients.store');

    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])
        ->middleware('permission:clients.edit')
        ->name('clients.edit');

    Route::put('/clients/{client}', [ClientController::class, 'update'])
        ->middleware('permission:clients.edit')
        ->name('clients.update');

    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
        ->middleware('permission:clients.delete')
        ->name('clients.destroy');

    Route::get('/clients/{client}', [App\Http\Controllers\ClientController::class, 'show'])
    ->middleware('permission:clients.profile.view')
    ->name('clients.show');

    //client services
    Route::get('/client-services', [ClientServiceController::class, 'index'])->name('client_services.index');
    Route::get('/client-services/create', [ClientServiceController::class, 'create'])->name('client_services.create');
    Route::post('/client-services', [ClientServiceController::class, 'store'])->name('client_services.store');
    Route::get('/client-services/{clientService}/edit', [ClientServiceController::class, 'edit'])->name('client_services.edit');
    Route::put('/client-services/{clientService}', [ClientServiceController::class, 'update'])->name('client_services.update');
    Route::delete('/client-services/{clientService}', [ClientServiceController::class, 'destroy'])->name('client_services.destroy');

    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index')->middleware('permission:finance.manage');
    Route::get('/voucher/create', [FinanceController::class, 'voucher'])->name('finance.vouchers.create')->middleware('permission:finance.manage');
    Route::post('/voucher/store', [FinanceController::class, 'voucherstore'])->name('vouchers.store')->middleware('permission:finance.manage');
    Route::post('/expenses/store', [FinanceController::class, 'storeExpense'])->name('finance.expenses.store')->middleware('permission:finance.manage');
    Route::get('/finance/data', [FinanceController::class, 'ajaxData'])->name('finance.ajax');
    Route::get('/client-services/{id}', [FinanceController::class, 'getServices'])->name('finance.client_services');
    Route::get('/finance/total-invoiced', [FinanceController::class, 'totalInvoiced'])->name('finance.total_invoiced');
   
   
    Route::get('/reports', [ReportController::class,'index'])->middleware('permission:reports.view')->name('reports.index');
    Route::get('/reports/ajax', [ReportController::class,'ajax'])->name('reports.ajax');
    });
Route::middleware(['auth', 'permission:users.manage'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::middleware(['auth', 'permission:services.manage'])->prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
    Route::get('/view/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/{service}/data', [ServiceController::class, 'ajaxData'])
    ->name('services.ajax');
    Route::post('/store', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
    Route::post('/update/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');
});


Route::middleware(['auth', 'permission:documents.manage'])->group(function () {
Route::get('/documents', [DocumentController::class,'index'])->name('documents.index');
Route::get('/documents/ajax', [DocumentController::class,'ajax'])
    ->name('documents.ajax');
Route::get('/documents/services', [DocumentController::class,'services'])
    ->name('documents.services');
Route::get('/documents/download/{id}', [DocumentController::class,'download'])
    ->name('documents.download');
Route::get('/documents/create', [DocumentController::class,'create'])
    ->name('documents.create');
Route::post('/documents/upload', [DocumentController::class,'uploaddocuments'])
->name('documents.upload');
});

require __DIR__.'/Auth.php';