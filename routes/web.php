<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetManagerController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/asset-manager', [AssetManagerController::class, 'index'])->name('asset.manager');