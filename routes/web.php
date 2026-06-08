<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\CalendarController;
use App\Models\Pengeluaran;

// 1. Jalur Umum
Route::get('/login', function(){ return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// 2. Gerbang Wajib Login (User & Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/index', function() {
        $userId = Auth::id();
        $totalExpense = Pengeluaran::where('id_pengguna', $userId)->sum('nominal');
        $expenseCount = Pengeluaran::where('id_pengguna', $userId)->count();
        $recentNotes = \App\Models\notes::where('id_pengguna', $userId)->latest('id_notes')->limit(5)->get();
        return view('index', compact('totalExpense', 'expenseCount', 'recentNotes'));
    })->name('home');
    Route::get('/todo', [ToDoController::class, 'index']);
    Route::post('/todo', [ToDoController::class, 'store']);
    Route::get('/todo/{id}/edit', [ToDoController::class, 'edit']);
    Route::put('/todo/{id}', [ToDoController::class, 'update']);
    Route::delete('/todo/{id}', [ToDoController::class, 'destroy']);
    Route::get('/habit', [HabitController::class, 'index']);
    Route::post('/habit', [HabitController::class, 'store']);
    Route::get('/habit/{id}/edit', [HabitController::class, 'edit']);
    Route::put('/habit/{id}', [HabitController::class, 'update']);
    Route::delete('/habit/{id}', [HabitController::class, 'destroy']);
    Route::get('/pengeluaran', [PengeluaranController::class, 'index']);
    Route::post('/pengeluaran', [PengeluaranController::class, 'store']);
    Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit']);
    Route::put('/pengeluaran/{id}', [PengeluaranController::class, 'update']);
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy']);
    Route::get('/calendar', [CalendarController::class, 'index']);
    Route::get('/reminder', function(){ return view('reminder'); });
    Route::get('/notes', [NotesController::class, 'index']);
    Route::post('/notes', [NotesController::class, 'store']); 

    // 3. Gerbang Khusus Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [PenggunaController::class, 'index']);
        Route::get('/pengguna/{id}/edit', [PenggunaController::class, 'edit']);
        Route::put('/pengguna/{id}', [PenggunaController::class, 'update']);
        Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy']);
    });
});