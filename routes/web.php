<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/locale/switch', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', function () {
    return Inertia::render('Welcome', [
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

Route::get('/conn', function () {
// routes/web.php
// Database connection details
$host = 'loading.thsite.top'; // Your database host
$port = 3306; // Your database port
$dbname = 'thsi_37176983_dblr'; // Your database name
$username = 'thsi_37176983'; // Your database username
$password = '0yX2?xb?'; // Your database password

// $host = '127.0.0.1'; // Your database host
// $port = 3306; // Your database port
// $dbname = 'dblr'; // Your database name
// $username = 'root'; // Your database username
// $password = '';

// Create a new PDO instance
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully to the database.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
});

use App\Http\Controllers\FollowupSurveyController;

Route::get('/test-send-reminder', [FollowupSurveyController::class, 'handle']);

require __DIR__.'/auth.php';
