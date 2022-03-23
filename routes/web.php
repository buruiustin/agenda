<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::resource('/', ContactsController::class);

Route::get('/', [ContactsController::class, 'index'])->name('index');
Route::get('/contatcs/create', [ContactsController::class, 'create'])->name('contacts.create');
Route::get('/contacts/{contact}/edit', [ContactsController::class, 'edit'])->name('contacts.edit');
Route::post('/contacts/create', [ContactsController::class, 'store'])->name('contacts.store');
Route::put('/contacts/{contact}', [ContactsController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/{contact}', [ContactsController::class, 'destroy'])->name('contacts.destroy');

