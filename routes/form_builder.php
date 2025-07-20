<?php

use App\Http\Controllers\Admin\FormBuilderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('builder/apointment', [FormBuilderController::class, 'builderAppointment'])->name('builderAppointment');

Route::prefix('admin')->middleware(['auth', 'anyAuth'])->group(function () {
    Route::get('form-builder', [FormBuilderController::class, 'form_builder'])->name('admin.form-builder'); 
    Route::get('form-builder/create', [FormBuilderController::class, 'formBuilderCreate'])->name('admin.form-builder.create'); 
    Route::post('/form-builder', [FormBuilderController::class, 'store'])->name('form-builder.store');

    Route::get('/form-builder/delete/{type}/{name}', [FormBuilderController::class, 'delete'])->name('form-builder.delete');

    Route::post('/form-builder/reorder', [FormBuilderController::class, 'saveOrder'])->name('form-builder.reorder');

    Route::get('/form-builder/edit/{type}', [FormBuilderController::class, 'edit'])->name('form-builder.edit');
    Route::post('/form-builder/update/{type}', [FormBuilderController::class, 'update'])->name('form-builder.update');
});