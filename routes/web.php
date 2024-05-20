<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/success', function () {
    return view('success');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'save'])->name('contact.save');
    Route::get('/contact/create', [ContactController::class, 'create'])->name('contact.create');
    Route::get('/contact/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::put('/contact/{id}/update', [ContactController::class, 'update'])->name('contact.update');
    Route::delete('/contact/{id}/delete', [ContactController::class, 'delete'])->name('contact.delete');
});
