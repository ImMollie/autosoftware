<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\MessageController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/',[MessageController::class, 'index'])->name('index');
Route::post('/create',[MessageController::class, 'create'])->name('create');
Route::get('/get',[MessageController::class, 'get'])->name('get');
Route::get('/read/{uuid}',[MessageController::class, 'read'])->name('read');
Route::get('/save/{message}',[MessageController::class, 'saveToFile'])->name('save');
Route::get('/load',[MessageController::class, 'loadMessages'])->name('load');
Route::get('/list',[MessageController::class, 'listMessages'])->name('list');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
