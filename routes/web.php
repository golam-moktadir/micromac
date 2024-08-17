<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('land_page');
});

Route::get('brand-info', [App\Http\Controllers\BrandController::class, 'index']);
Route::post('brand-add', [App\Http\Controllers\BrandController::class, 'addBrand']);
Route::get('get-single-brand/{id}', [App\Http\Controllers\BrandController::class, 'getSingleBrand']);
Route::post('brand-update', [App\Http\Controllers\BrandController::class, 'updateBrand']);
Route::get('brand-delete/{id}', [App\Http\Controllers\BrandController::class, 'deleteBrand']);

Route::get('model-info', [App\Http\Controllers\ModelController::class, 'index']);
Route::post('model-add', [App\Http\Controllers\ModelController::class, 'addModel']);
Route::get('get-single-model/{id}', [App\Http\Controllers\ModelController::class, 'getSingleModel']);
Route::post('model-update', [App\Http\Controllers\ModelController::class, 'updateModel']);
Route::get('model-delete/{id}', [App\Http\Controllers\ModelController::class, 'deleteModel']);

Route::get('item-info', [App\Http\Controllers\ItemController::class, 'index']);
Route::post('item-add', [App\Http\Controllers\ItemController::class, 'addItem']);
Route::get('get-single-item/{id}', [App\Http\Controllers\ItemController::class, 'getSingleItem']);
Route::post('item-update', [App\Http\Controllers\ItemController::class, 'updateItem']);
Route::get('item-delete/{id}', [App\Http\Controllers\ItemController::class, 'deleteItem']);
