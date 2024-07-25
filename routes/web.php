<?php

use App\Http\Controllers\Download\FileController;
use App\Http\Controllers\Home\HomeController;
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

//Home
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
});

//Download
Route::controller(FileController::class)->group(function () {
    Route::get('/file-download', 'downloadFile')->name('files.download');
    Route::post('/file-import', 'importFile')->name('files.import');
});
