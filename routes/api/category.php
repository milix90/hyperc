<?php

use App\Http\Controllers\Api\v1\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/category/','as' => 'api.'],function (){
    Route::get('/',[CategoryController::class,'getParents'])->name('categories');
    Route::get('/{slug}',[CategoryController::class,'getParentDetails'])->name('category.details');
});
