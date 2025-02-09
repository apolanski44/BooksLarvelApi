<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/books/{book_id}/reviews', [ReviewController::class, 'store']); 
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'delete']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/reviews/{id}', [ReviewController::class, 'show']);
});
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']); 
    Route::post('/', [BookController::class, 'store']);
    Route::get('/{book_id}/reviews', [ReviewController::class, 'index']);
    Route::get('/{id}', [BookController::class, 'show']);

});

