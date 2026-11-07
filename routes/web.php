<?php

use App\Http\Controllers\BranchMapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/profil', function () {
    return redirect('/admin');
});

Route::get('/peta', [BranchMapController::class, 'index'])->name('peta.index');
Route::post('/peta', [BranchMapController::class, 'store'])->name('peta.store');
