<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\CalendarController;
use App\Models\ToDo;
use App\Models\Pengeluaran;
use App\Models\notes;
use App\Models\HabitTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

// 1. Jalur Umum
Route::get('/login', function(){ 
    if (Auth::check()) {
        return redirect('/index');
    }
    return view('login'); 
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/logout', [AuthController::class, 'logout']);

// 2. Gerbang Wajib Login (User & Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/index', function(Request $request) {
        $userId = Auth::id();
        $alltask = ToDo::where('id_pengguna', $userId)->where('status', '!=', 'Completed')->count();
        $activehabit = HabitTracker::where('id_pengguna', $userId)->where('status','active')->count();
        $recenthabit = HabitTracker::where('id_pengguna', $userId)->latest('id_habit_tracker')->limit(3)->get();
        $todolist = ToDo::where('id_pengguna', $userId)->latest('id_to_do_list')->limit(3)->get();
        $totalExpense = Pengeluaran::where('id_pengguna', $userId)->sum('nominal');
        $expenseCount = Pengeluaran::where('id_pengguna', $userId)->count();
        $recentNotes = Notes::where('id_pengguna', $userId)->latest('id_notes')->limit(5)->get();
        
        // Calendar data
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));
        $currentDate = \Carbon\Carbon::createFromDate($year, $month, 1);
        
        // Ambil Google Calendar API data
        $apiKey = env('GOOGLE_CALENDAR_API_KEY');
        $calendarId = env('GOOGLE_CALENDAR_ID');
        
        $timeMin = $currentDate->copy()->startOfMonth()->toRfc3339String();
        $timeMax = $currentDate->copy()->endOfMonth()->toRfc3339String();
        
        $eventsByDate = [];
        
        if ($apiKey && $calendarId) {
            $apiUrl = "https://www.googleapis.com/calendar/v3/calendars/" . urlencode($calendarId) . "/events";
            
            $response = Http::get($apiUrl, [
                'key' => $apiKey,
                'timeMin' => $timeMin,
                'timeMax' => $timeMax,
                'singleEvents' => 'true',
                'orderBy' => 'startTime'
            ]);
            
            $googleEvents = $response->json()['items'] ?? [];
            
            foreach ($googleEvents as $event) {
                $start = $event['start']['dateTime'] ?? $event['start']['date'] ?? null;
                if ($start) {
                    $dateKey = substr($start, 0, 10);
                    
                    $waktu_mulai = '00:00';
                    $waktu_selesai = '23:59';
                    
                    if (isset($event['start']['dateTime'])) {
                        $waktu_mulai = substr($event['start']['dateTime'], 11, 5);
                    }
                    if (isset($event['end']['dateTime'])) {
                        $waktu_selesai = substr($event['end']['dateTime'], 11, 5);
                    }
                    
                    $eventsByDate[$dateKey][] = [
                        'judul_list' => $event['summary'] ?? 'Tanpa Judul',
                        'isi_list' => $event['description'] ?? '',
                        'waktu_mulai' => $waktu_mulai,
                        'waktu_selesai' => $waktu_selesai,
                        'status' => 'completed'
                    ];
                }
            }
        }
        
        // Ambil TODO dari database
        $todos = ToDo::where('id_pengguna', $userId)->get();
        foreach ($todos as $todo) {
            $dateKey = $todo->tanggal_selesai;
            
            if (!isset($eventsByDate[$dateKey])) {
                $eventsByDate[$dateKey] = [];
            }
            
            $user = Auth::user();
            $eventsByDate[$dateKey][] = [
                'judul_list' => $user->username . ' - ' . $todo->judul_list,
                'isi_list' => $todo->isi_list,
                'waktu_mulai' => $todo->waktu_mulai,
                'waktu_selesai' => $todo->waktu_selesai,
                'status' => $todo->status
            ];
        }
        
        $daysInMonth = $currentDate->daysInMonth;
        $firstDayOfWeek = $currentDate->dayOfWeek;
        $selectedDate = $request->query('date', (date('m') == $month && date('Y') == $year) ? date('Y-m-d') : $currentDate->format('Y-m-d'));
        $selectedDayEvents = collect($eventsByDate[$selectedDate] ?? []);
        
        return view('index', compact('totalExpense', 'expenseCount', 'recentNotes', 'todolist', 'recenthabit', 'activehabit', 'alltask', 'month', 'year', 'currentDate', 'daysInMonth', 'firstDayOfWeek', 'eventsByDate', 'selectedDate', 'selectedDayEvents', 'todos'));
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
    Route::get('/notes', [NotesController::class, 'index']);
    Route::post('/notes', [NotesController::class, 'store']);
    Route::get('/notes/{id}/edit', [NotesController::class, 'edit']);
    Route::put('/notes/{id}', [NotesController::class, 'update']);
    Route::delete('/notes/{id}', [NotesController::class, 'destroy']); 

    // 3. Gerbang Khusus Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [PenggunaController::class, 'index']);
        Route::get('/pengguna/{id}/edit', [PenggunaController::class, 'edit']);
        Route::put('/pengguna/{id}', [PenggunaController::class, 'update']);
        Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy']);
    });
});