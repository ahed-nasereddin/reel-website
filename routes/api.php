<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sliders', [HomeController::class, 'sliders']);
Route::get('/services', [HomeController::class, 'services']);
Route::get('/latestprojects', [ProjectController::class, 'latestprojects']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);
Route::get('/projects', [ProjectController::class, 'all']);

Route::get('/contact', [ContactController::class, 'show']);


Route::get('/team', [HomeController::class, 'team']);
Route::get('/testimonials', [HomeController::class, 'testimonials']);
Route::post('/testimonials', [HomeController::class, 'storeTestimonial']);

Route::middleware('web')->group(function () {
    Route::post('/cart/add', [App\Http\Controllers\Api\CartController::class, 'add']);
    Route::post('/cart/remove', [App\Http\Controllers\Api\CartController::class, 'remove']);
    Route::post('/cart/update', [App\Http\Controllers\Api\CartController::class, 'update']);
    Route::get('/cart', [App\Http\Controllers\Api\CartController::class, 'index']);

    Route::post('/quotation/create', [App\Http\Controllers\Api\QuotationController::class, 'store']);
    Route::get('/quotation/{id}', [App\Http\Controllers\Api\QuotationController::class, 'show']);
});

Route::post('/makequote', [App\Http\Controllers\Api\QuotationController::class, 'store']);

Route::get('/navigation', [App\Http\Controllers\Api\CatalogController::class, 'navigation']);
Route::get('/main-categories', [App\Http\Controllers\Api\CatalogController::class, 'mainCategories']);
Route::get('/categories', [App\Http\Controllers\Api\CatalogController::class, 'categories']);
Route::get('/sub-categories', [App\Http\Controllers\Api\CatalogController::class, 'subCategories']);
Route::get('/brands', [App\Http\Controllers\Api\CatalogController::class, 'brands']);
Route::get('/items', [App\Http\Controllers\Api\CatalogController::class, 'items']);
Route::get('/items/{slug}', [App\Http\Controllers\Api\CatalogController::class, 'show']);
Route::get('/related-items/{id}', [App\Http\Controllers\Api\CatalogController::class, 'relatedItems']);
