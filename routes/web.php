<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\Item\ItemController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Inventory\Unit\UnitController;

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

Route::prefix('inventory/units')->name('units.')->group(function () {
    Route::get('/', [UnitController::class, 'index'])->name('index');

    Route::post('/', [UnitController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UnitController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UnitController::class, 'update'])->name('update');
    Route::delete('/{id}', [UnitController::class, 'destroy'])->name('destroy');
});

Route::prefix('inventory/items')->name('items.')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('/create', [ItemController::class, 'create'])->name('create');
    Route::post('/', [ItemController::class, 'store'])->name('store');
    Route::put('/{id}', [ItemController::class, 'update'])->name('update');
    Route::delete('/{id}', [ItemController::class, 'destroy'])->name('destroy');
});



Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('{any}', [HomeController::class, 'index']);

