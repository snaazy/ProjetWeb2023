<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('main');
});



// Route pour la page de connexion
Route::get('/login', [App\Http\Controllers\AuthenticatedSessionController::class, 'showLoginForm'])
    ->name('login');

// Route pour la soumission du formulaire de connexion
Route::post('/login', [App\Http\Controllers\AuthenticatedSessionController::class, 'login']);

// Route pour la déconnexion
Route::post('/logout', [App\Http\Controllers\AuthenticatedSessionController::class, 'logout'])
    ->name('logout');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::view('/admin', 'admin.home')->name('admin.home');
    });
    
Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [App\Http\Controllers\AuthenticatedSessionController::class, 'logout'])->name('logout');
});


Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);

