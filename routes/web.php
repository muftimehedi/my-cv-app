<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use App\Models\User;
use App\Models\Cv;

// Import your Dashboard\CvController
use App\Http\Controllers\Dashboard\CvController; // <-- IMPORTANT: Add this line

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

// --- WELCOME PAGE ROUTE ---
// This route is for displaying the CV on the public welcome page.
// It should NOT use CvController directly for the welcome page.
Route::get('/', function () {
    // Fetch the CV of a specific user (e.g., user with ID 1)
    // IMPORTANT: Ensure your User and Cv models have the correct relationships defined
    // and that Cv model has 'casts' for JSON fields (education, experience, etc.)
    $user = User::where('id', 1)->with('cv')->first();

    $cvData = $user ? $user->cv : null;

    return Inertia::render('Welcome', [
        'cv' => $cvData,
    ]);
})->name('welcome'); // Give it a name, often useful

// --- AUTHENTICATED ROUTES (e.g., Dashboard, including CV editing) ---
// These routes are typically protected and would use your Dashboard\CvController.
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // ROUTES FOR YOUR DASHBOARD CV CONTROLLER
    // Make sure to use the full class path with ::class
    Route::get('/dashboard/cv', [CvController::class, 'edit'])->name('dashboard.cv.edit');
    Route::post('/dashboard/cv', [CvController::class, 'update'])->name('dashboard.cv.update');
});


// You might have other public CV viewing routes like:
// Route::get('/cv/{username}', [App\Http\Controllers\PublicCvController::class, 'show'])->name('public.cv.show');
