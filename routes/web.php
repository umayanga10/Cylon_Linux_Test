<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\TerritoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;



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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// pages controller routes
Route::get('/getZoneControllerView', [PagesController::class, 'getZoneControllerView'])->name('pages.zone');

// Zone routes
Route::resource('/zone', ZoneController::class);

// Region routes
Route::resource('/region', RegionController::class);

// Territory routes
Route::resource('/territory', TerritoryController::class);

// User routes
Route::resource('/user', UserController::class);

// Product routes
Route::resource('/product', ProductController::class);

// PurchaseOrder routes 
Route::get('purchaseOrder', [PurchaseOrderController::class, 'index'])->name('purchaseOrder.index');
Route::get('purchaseOrder/create', [PurchaseOrderController::class, 'create'])->name('purchaseOrder.create');
Route::get('purchaseOrder/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('purchaseOrder.show');
Route::post('purchaseOrder', [PurchaseOrderController::class, 'store'])->name('purchaseOrder.store');

Route::get('/poList', [PurchaseOrderController::class, 'poList'])->name('purchaseOrder.poList');
Route::post('/convertInv', [PurchaseOrderController::class, 'convertInv']);
