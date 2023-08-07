<?php

use App\Http\Controllers\Api\V1\CategoriasController;
use App\Http\Controllers\Api\V1\PessoasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'v1'], function () {

    // CRUDL Pessoas
    Route::prefix('pessoas')->group(function () {
        Route::controller(PessoasController::class)->group(function () {
            Route::name('pessoas.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::post('', 'store')->name('store');
                Route::put('/{id}', 'update')->name('update');
                Route::patch('/{id}', 'update')->name('update');
            });
        });
    });

    // CRUDL Categoriass
    Route::prefix('categorias')->group(function () {
        Route::controller(CategoriasController::class)->group(function () {
            Route::name('categorias.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::post('', 'store')->name('store');
                Route::put('/{id}', 'update')->name('update');
                Route::patch('/{id}', 'update')->name('update');
            });
        });
    });
});
