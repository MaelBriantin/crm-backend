<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VisitFrequencyController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PostcodeController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return [$request->user()];
    });
    // Sectors routes
    Route::get('/sectorsWithPostcodes/{sector}', [SectorController::class, 'showWithPostcodes']);
    Route::get('/sectorsWithPostcodes', [SectorController::class, 'indexWithPostcodes']);
    Route::delete('/sectors/{sector}', [SectorController::class, 'destroy']);
    Route::patch('/sectors/{sector}', [SectorController::class, 'update']);
    Route::get('/sectors/{sector}', [SectorController::class, 'show']);
    Route::post('/sectors', [SectorController::class, 'store']);
    Route::get('/sectors', [SectorController::class, 'index']);

    // Postcodes routes
    Route::delete('/postcodes/{postcode}', [PostcodeController::class, 'destroy']);
    Route::patch('/postcodes/{postcode}', [PostcodeController::class, 'update']);
    Route::get('/postcodes/{postcode}', [PostcodeController::class, 'show']);
    Route::post('/postcodes', [PostcodeController::class, 'store']);
    Route::get('/postcodes', [PostcodeController::class, 'index']);

    // Brands routes
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy']);
    Route::patch('/brands/{brand}', [BrandController::class, 'update']);
    Route::get('/brands/{brand}', [BrandController::class, 'show']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands', [BrandController::class, 'index']);

    // Customers routes
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);
    Route::patch('/customers/{customer}', [CustomerController::class, 'update']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers', [CustomerController::class, 'index']);

    // Relationships routes
    Route::get('/relationships/{relationship}', [RelationshipController::class, 'show']);
    Route::get('/relationships', [RelationshipController::class, 'index']);

    // VisitFrequency routes
    Route::get('/visitFrequencies/{visitFrequency}', [VisitFrequencyController::class, 'show']);
    Route::get('/visitFrequencies', [VisitFrequencyController::class, 'index']);

    // Products routes
    Route::get('/productOptions', [ProductController::class, 'productOptionsIndex']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::patch('/products/{product}', [ProductController::class, 'update']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products', [ProductController::class, 'index']);

    // Orders routes
    Route::patch('/orders/{order}/confirmPayment', [OrderController::class, 'confirmPayment']);
    Route::get('/orderOptions', [OrderController::class, 'getOrderOptions']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
});
