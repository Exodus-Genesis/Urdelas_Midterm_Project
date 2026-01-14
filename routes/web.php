<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;

// Dummy Login Routes (Must be first, no middleware)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    session(['user_logged_in' => true]);
    return redirect()->route('dashboard');
})->name('login.store');

Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('login');
})->name('logout');

// Dashboard and Movie/Genre Routes (Define once!)
Route::get('/', [MovieController::class, 'index'])->name('dashboard');
Route::resource('movies', MovieController::class)->except(['show', 'create', 'edit']);
Route::resource('genres', GenreController::class)->except(['show', 'create', 'edit']);
Route::patch('/movies/{id}/restore', [MovieController::class, 'restore'])
    ->name('movies.restore');

Route::delete('/movies/{id}/force-delete', [MovieController::class, 'forceDelete'])
    ->name('movies.forceDelete');

Route::get('/movies/trash', [MovieController::class, 'trash'])
    ->name('movies.trash');

Route::get('/movies/export', [MovieController::class, 'export'])->name('movies.export');
