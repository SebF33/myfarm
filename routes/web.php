<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Models\Animal;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

require __DIR__ . '/auth.php';


Route::get('/', function () {

    $animals = Animal::with('breed', 'mammal', 'photos', 'status')->get();

    return Inertia::render('Welcome', [
        'animals' => $animals,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {

    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('animals', AnimalController::class);
Route::get('animals/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
Route::put('animals/{animal}', [AnimalController::class, 'update'])->name('animals.update');
Route::post('animals/{animal}/photos', [PhotoController::class, 'store'])->name('photos.store');
Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
