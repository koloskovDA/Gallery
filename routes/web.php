<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

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
Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('/');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->get('/profile', \App\Http\Livewire\Profile::class)->name('profile');

Route::get('/exhibitions', \App\Http\Livewire\Exhibitions::class)->name('exhibitions');
Route::get('/expositions', \App\Http\Livewire\Expositions::class)->name('expositions');


Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/exhibitions', \App\Http\Livewire\Exhibitions::class)->name('admin.exhibitions');
    Route::get('/exhibition/{exhibition_id}', \App\Http\Livewire\Exhibition::class)->name('admin.exhibition');
    Route::get('/exposition/{exposition_id}', \App\Http\Livewire\Exposition::class)->name('admin.exposition');
    Route::get('/directions', \App\Http\Livewire\Directions::class)->name('admin.directions');
    Route::get('/types', \App\Http\Livewire\Types::class)->name('admin.types');
    Route::get('/authors', \App\Http\Livewire\Authors::class)->name('admin.authors');
    Route::get('/owners', \App\Http\Livewire\Owners::class)->name('admin.owners');
});
