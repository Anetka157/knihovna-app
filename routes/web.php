<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

// Domovská stránka přesměruje na seznam knih
Route::redirect('/', '/books');

// CRUD pro knihy
Route::resource('books', BookController::class);

// Výpůjčky
Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('/loans/overdue', [LoanController::class, 'overdue'])->name('loans.overdue');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
Route::patch('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
