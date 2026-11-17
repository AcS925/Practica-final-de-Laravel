<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return redirect()->route('proyectos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::resource('proyectos', ProjectController::class);
});

Route::post(
  '/proyectos/{proyecto}/participantes',
  [ProjectController::class, 'addParticipant']
)->name('proyectos.participants.add');

Route::get('/mis-proyectos', [ProjectController::class, 'myProjects'])
  ->name('proyectos.mine');


require __DIR__ . '/auth.php';
