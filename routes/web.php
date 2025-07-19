<?php

use App\Http\Controllers\TimeEntryController;
use App\Livewire\EntriesIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', EntriesIndex::class)->name('entries.index');
Route::get('/entries/{entry}', [TimeEntryController::class, 'show'])->name('entries.show');
Route::post('/entries', [TimeEntryController::class, 'store'])->name('entries.store');
Route::get('/entries/{entry}/edit', [TimeEntryController::class, 'edit'])->name('entries.edit');
Route::delete('/entries/{entry}', [TimeEntryController::class, 'destroy'])->name('entries.destroy');
Route::put('/entries/{entry}', [TimeEntryController::class, 'update'])->name('entries.update');
