<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\AuthController;

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

// Home
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/quizgo', [HomeController::class, 'quizgo'])->name('quizgo');
Route::get('/search', [HomeController::class, 'search'])->name('search');



// Set
Route::get('/create-set', [SetController::class, 'createSet'])->name('create-set');
Route::post('/save-set', [SetController::class, 'saveSet'])->name('save-set');

Route::get('show-set/{set}',[SetController::class, 'showSet'])->name('show-set');
Route::get('test-set/{set}',[SetController::class, 'testSet'])->name('test-set');
Route::post('/delete-set/{set}',[SetController::class, 'deleteSet'])->name('delete-set');

Route::get('/modify-set/{set}',[SetController::class, 'modifySet'])->name('modify-set');
Route::post('/update-set/{set}',[SetController::class, 'updateSet'])->name('update-set');
Route::post('/delete-card',[SetController::class, 'deleteCard'])->name('delete-card');

Route::get('creator/{name}',[SetController::class, 'Creator'])->name('creator');
Route::post('/search-creator', [SetController::class, 'searchCreator'])->name('search-creator');



// Auth
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::post('join', [AuthController::class, 'join'])->name('join');
Route::get('forgotton', [AuthController::class, 'forgotton'])->name('forgotton');

Route::get('/settings', [AuthController::class, 'settings'])->name('settings');
Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
Route::post('/update-name', [AuthController::class, 'updateName'])->name('update-name');
Route::post('/update-email', [AuthController::class, 'updateEmail'])->name('update-email');
Route::post('/delete-account', [AuthController::class, 'deleteAccount'])->name('delete-account');