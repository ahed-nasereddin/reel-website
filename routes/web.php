<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ContactController;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::get('/Quotation', function () {
    return redirect()->route('quotation.create');
});

Route::get('/quotation/create', [QuotationController::class, 'index'])->name('quotation.create');

// Route::get('/items', [App\Http\Controllers\CatalogPageController::class, 'items'])->name('items.index');
Route::get('/items/{slug}', [App\Http\Controllers\CatalogPageController::class, 'itemDetails'])->name('items.show');
Route::get('/equipment/{category?}/{subCategory?}', [App\Http\Controllers\CatalogPageController::class, 'categoryPage'])->name('equipment.category');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
