<?php

use App\Http\Controllers\Accounting\Account\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\Item\ItemController;
use App\Http\Controllers\Production\Bom\BomController;
use App\Http\Controllers\Production\Machine\MachineController;
use App\Http\Controllers\ProductionController;
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
    Route::post('/{id}/unit', [ItemController::class, 'addUnit']);

    Route::post('/', [ItemController::class, 'store'])->name('store');
    Route::put('/{id}', [ItemController::class, 'update'])->name('update');
    Route::delete('/{id}', [ItemController::class, 'destroy'])->name('destroy');
});


Route::prefix('accounts')->name('accounts.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::post('/', [AccountController::class, 'store'])->name('store');
    Route::put('/{id}', [AccountController::class, 'update'])->name('update');
    Route::delete('/{id}', [AccountController::class, 'destroy'])->name('destroy');
});

Route::prefix('machines')->name('machines.')->group(function () {

    Route::get('/', [MachineController::class, 'index'])->name('index');

    Route::post('/', [MachineController::class, 'store'])->name('store');

    Route::put('/{id}', [MachineController::class, 'update'])->name('update');

    Route::delete('/{id}', [MachineController::class, 'destroy'])->name('destroy');

});

Route::put('/production/bom/{id}', [BomController::class, 'update']);

Route::prefix('production')->group(function () {

    // MACHINE

    Route::prefix('bom')->name('bom.')->group(function () {

        Route::get('/', [BomController::class, 'index'])->name('index');
        Route::get('/create', [BomController::class, 'create'])->name('create');
        Route::post('/', [BomController::class, 'store'])->name('store');

        // 🔥 WAJIB buat modal
        Route::get('/{id}', [BomController::class, 'show'])->name('show');

        // 🔥 buat edit dari modal
        Route::put('/{id}', [BomController::class, 'update'])->name('update');

        // 🔥 delete
        Route::delete('/{id}', [BomController::class, 'destroy'])->name('destroy');
    });

    // ================= PRODUCTION =================
    Route::prefix('list')->name('production.')->group(function () {
        Route::get('/', [ProductionController::class, 'index'])->name('index');
    });

    Route::prefix('create')->group(function () {
        Route::get('/', [ProductionController::class, 'create'])->name('production.create');
        Route::post('/', [ProductionController::class, 'store'])->name('production.store');
    });

    Route::post('{id}/start', [ProductionController::class, 'start']);
    Route::post('{id}/finish', [ProductionController::class, 'finish']);
});


Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('{any}', [HomeController::class, 'index']);

