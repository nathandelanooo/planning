<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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

        // 2. Ambil data dari Google Calendar API secara langsung
        $apiKey = env('GOOGLE_CALENDAR_API_KEY');
        $calendarId = env('GOOGLE_CALENDAR_ID');
        
        $timeMin = $currentDate->copy()->startOfMonth()->toRfc3339String();
        $timeMax = $currentDate->copy()->endOfMonth()->toRfc3339String();

        // Base URL saja
        $apiUrl = "https://www.googleapis.com/calendar/v3/calendars/" . urlencode($calendarId) . "/events";

        // Tembak API Google pakai format Array (Biar tanda + dan @ di-encode otomatis)
        $response = Http::get($apiUrl, [
            'key' => $apiKey,
            'timeMin' => $timeMin,
            'timeMax' => $timeMax,
            'singleEvents' => 'true',
            'orderBy' => 'startTime'
        ]);
        
        // Hapus dd() kalau datanya sudah sukses muncul di layar
        // dd($response->json());
        
        $googleEvents = $response->json()['items'] ?? [];
        // dd($response->json());

        // 3. Kelompokkan data event Google berdasarkan tanggal (Y-m-d)
        $eventsByDate = [];
        foreach ($googleEvents as $event) {
            $start = $event['start']['dateTime'] ?? $event['start']['date'] ?? null;
            if ($start) {
                $dateKey = substr($start, 0, 10); // Ambil format Y-m-d
                
                $eventsByDate[$dateKey][] = [
                    'judul_list' => $event['summary'] ?? 'Tanpa Judul',
                    'isi_list' => $event['description'] ?? 'Event dari Google Calendar',
                    'waktu_mulai' => isset($event['start']['dateTime']) ? substr($event['start']['dateTime'], 11, 5) : '00:00',
                    'waktu_selesai' => isset($event['end']['dateTime']) ? substr($event['end']['dateTime'], 11, 5) : '23:59',
                    'status' => 'completed' // warna hijau default
                ];
            }
        }

        // 4. Hitung Struktur Grid Kalender
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
            'todos' => collect($googleEvents) // Hitung total untuk kolom kanan
        ]);
    }
}