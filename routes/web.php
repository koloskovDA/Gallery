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
Route::middleware('auth')->get('/mylots', [\App\Http\Controllers\HomeController::class, 'myLots'])->name('mylots');
Route::middleware('auth')->get('/mytickets', [\App\Http\Controllers\HomeController::class, 'myTickets'])->name('mytickets');
Route::middleware('auth')->get('/favourites', [\App\Http\Controllers\HomeController::class, 'favourites'])->name('favourites');


Route::get('/exhibitions', \App\Http\Livewire\Exhibitions::class)->name('exhibitions');
Route::get('/exhibition/{exhibition_id}', \App\Http\Livewire\Exhibition::class)->name('admin.exhibition');
Route::get('/exposition/{exposition_id}', \App\Http\Livewire\Exposition::class)->name('admin.exposition');

Route::get('/directions', \App\Http\Livewire\Directions::class)->name('directions');
Route::get('/types', \App\Http\Livewire\Types::class)->name('types');
Route::get('/authors', \App\Http\Livewire\Authors::class)->name('authors');
Route::get('/owners', \App\Http\Livewire\Owners::class)->name('owners');

Route::get('/d_p/{direction_id}', [\App\Http\Controllers\HomeController::class, 'directionPaintings'])->name('direction.paintings');
Route::get('/t_p/{type_id}', [\App\Http\Controllers\HomeController::class, 'typePaintings'])->name('type.paintings');
Route::get('/a_p/{author_id}', [\App\Http\Controllers\HomeController::class, 'authorPaintings'])->name('author.paintings');
Route::get('/o_p/{owner_id}', [\App\Http\Controllers\HomeController::class, 'ownerPaintings'])->name('owner.paintings');
Route::get('/painting/{painting_id}', \App\Http\Livewire\Painting::class)->name('painting');

Route::get('/receipts', \App\Http\Livewire\Receipts::class)->middleware('admin')->name('receipts');
Route::get('/user/{user_id}', \App\Http\Livewire\User::class)->middleware('admin')->name('user');

Route::get('generate-pdf/{ticket_id}', [\App\Http\Controllers\HomeController::class, 'generatePDF'])->name('generatePDF');
