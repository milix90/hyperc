<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:web', 'isAdmin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/dashboard', PanelController::class)->name('dashboard');
    Route::resource('/category', CategoryController::class)->except(['show']);
});
