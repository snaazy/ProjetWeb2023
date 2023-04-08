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
    Route::get('/profil', [App\Http\Controllers\UserController::class, 'profil'])->name('profil');
});


Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);



Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.users.index');
    Route::resource('formations', App\Http\Controllers\FormationController::class);
    Route::resource('admin/formations',App\Http\Controllers\FormationController::class)->except(['show']);
    Route::get('admin/formations/create', [App\Http\Controllers\FormationController::class, 'create'])->name('admin.formations.create');
    Route::post('admin/formations', [App\Http\Controllers\FormationController::class, 'store'])->name('admin.formations.store');
    Route::get('admin/formations', [App\Http\Controllers\FormationController::class, 'index'])->name('admin.formations.index');
    Route::get('/admin/formations/{formation}/edit', [App\Http\Controllers\FormationController::class, 'edit'])->name('admin.formations.edit');
    Route::delete('/admin/formations/{formation}', [App\Http\Controllers\FormationController::class, 'destroy'])->name('admin.formations.destroy');
    Route::put('/admin/formations/{formation}', [App\Http\Controllers\FormationController::class, 'update'])->name('admin.formations.update');
    Route::post('/admin/users/{user}/approve', 'App\Http\Controllers\AdminController@approveUser')->name('admin.users.approve');

    // ...
});

Route::get('/inactive', function () {
    return view('inactive');
})->name('inactive')->middleware('auth');

Route::middleware(['ensureUserIsActive'])->group(function () {
    // Ajoutez ici toutes les routes à protéger
});
