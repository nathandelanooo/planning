<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ToDo;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        // 1. Setup Bulan dan Tahun aktif dari URL
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

        $currentDate = Carbon::createFromDate($year, $month, 1);
        $monthName = $currentDate->translatedFormat('F');

        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        // 2. Ambil data dari Google Calendar API
        $apiKey = env('GOOGLE_CALENDAR_API_KEY');
        $calendarId = env('GOOGLE_CALENDAR_ID');
        
        $timeMin = $currentDate->copy()->startOfMonth()->toRfc3339String();
        $timeMax = $currentDate->copy()->endOfMonth()->toRfc3339String();

        $apiUrl = "https://www.googleapis.com/calendar/v3/calendars/" . urlencode($calendarId) . "/events";

        $response = Http::get($apiUrl, [
            'key' => $apiKey,
            'timeMin' => $timeMin,
            'timeMax' => $timeMax,
            'singleEvents' => 'true',
            'orderBy' => 'startTime'
        ]);
        
        $googleEvents = $response->json()['items'] ?? [];
        
        // DEBUG: Lihat response API
        \Log::info('Google Calendar API Response:', [
            'status' => $response->status(),
            'events_count' => count($googleEvents),
            'first_event' => $googleEvents[0] ?? null
        ]);

        // 3. Kelompokkan data event Google berdasarkan tanggal (Y-m-d)
        $eventsByDate = [];
        foreach ($googleEvents as $event) {
            $start = $event['start']['dateTime'] ?? $event['start']['date'] ?? null;
            if ($start) {
                $dateKey = substr($start, 0, 10);
                
                // Handle all-day events (format: date saja, tidak ada time)
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

        // 4. Ambil TODO dari database dan tambahkan ke eventsByDate
        $todos = ToDo::where('id_pengguna', Auth::id())->get();
        foreach ($todos as $todo) {
            $dateKey = $todo->tanggal_selesai; // Ambil tanggal selesai
            
            if (!isset($eventsByDate[$dateKey])) {
                $eventsByDate[$dateKey] = [];
            }
            
            // Format: "username - judul"
            $user = Auth::user();
            $eventsByDate[$dateKey][] = [
                'judul_list' => $user->username . ' - ' . $todo->judul_list,
                'isi_list' => $todo->isi_list,
                'waktu_mulai' => $todo->waktu_mulai,
                'waktu_selesai' => $todo->waktu_selesai,
                'status' => $todo->status
            ];
        }

        // 5. Hitung Struktur Grid Kalender
        $daysInMonth = $currentDate->daysInMonth;
        $firstDayOfWeek = $currentDate->dayOfWeek;

        // Ambil agenda khusus tanggal terpilih
        $selectedDate = $request->query('date', (date('m') == $month && date('Y') == $year) ? date('Y-m-d') : $currentDate->format('Y-m-d'));
        $selectedDayEvents = collect($eventsByDate[$selectedDate] ?? []);

        return view('calendar', [
            'month' => $month,
            'year' => $year,
            'monthName' => $monthName,
            'daysInMonth' => $daysInMonth,
            'firstDayOfWeek' => $firstDayOfWeek,
            'eventsByDate' => $eventsByDate,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'selectedDate' => $selectedDate,
            'selectedDayEvents' => $selectedDayEvents,
            'todos' => $todos
        ]);
    }
}