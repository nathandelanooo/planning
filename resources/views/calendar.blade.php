<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendar | Planning</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    :root{
      --bg:#f6f7fb;
      --card:#ffffff;
      --text:#1f2430;
      --muted:#7a8191;
      --primary:#6f42ff;
      --soft-purple:#f3edff;
      --border:#e9ebf2;
      --shadow:0 12px 30px rgba(31,36,48,.06);
      --radius:22px;
    }

    *{box-sizing:border-box}
    body{
      font-family:'Inter',sans-serif;
      background:var(--bg);
      color:var(--text);
    }

    .navbar{
      background:rgba(255,255,255,.92);
      backdrop-filter: blur(10px);
      border-bottom:1px solid var(--border);
    }

    .brand-badge{
      width:40px;height:40px;border-radius:14px;
      background:linear-gradient(135deg,var(--primary),#9b7bff);
      color:#fff;display:grid;place-items:center;
      box-shadow:0 10px 24px rgba(111,66,255,.25);
      font-weight:800;
      flex:0 0 auto;
    }

    .nav-link{
      color:#4b5160 !important;
      font-weight:600;
      border-radius:999px;
      padding:.55rem .9rem !important;
      margin:0 .1rem;
    }
    .nav-link.active{
      color:var(--primary) !important;
      background:#f4efff;
    }

    .page-wrap{padding:24px 0 40px}

    .panel-card,
    .form-card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
    }

    .section-title{
      font-size:1.05rem;
      font-weight:800;
      letter-spacing:-.02em;
      margin-bottom:0;
    }
    .section-sub{color:var(--muted);font-size:.92rem}

    .view-title{
      font-size:1.35rem;
      font-weight:800;
      letter-spacing:-.03em;
      margin-bottom:.15rem;
    }

    .summary-mini{
      background:#fff;
      border:1px solid var(--border);
      border-radius:18px;
      padding:14px 16px;
      box-shadow:var(--shadow);
    }

    .calendar-box{
      border:1px solid var(--border);
      border-radius:20px;
      background:#fff;
      padding:18px;
    }

    .cal-grid{
      display:grid;
      grid-template-columns:repeat(7,1fr);
      gap:8px;
    }
    .cal-day-head{
      font-size:.78rem;
      color:var(--muted);
      text-align:center;
      font-weight:700;
    }
    .cal-day{
      aspect-ratio:1 / 1;
      border-radius:14px;
      border:1px solid var(--border);
      display:flex;
      align-items:center;
      justify-content:center;
      background:#fff;
      font-weight:700;
      color:#4b5160;
      position:relative;
      cursor:pointer;
      user-select:none;
    }
    .cal-day.empty{
      border-style:dashed;
      background:transparent;
      color:transparent;
      cursor:default;
    }
    .cal-day.today{
      background:var(--primary);
      color:#fff;
      border-color:var(--primary);
      box-shadow:0 10px 20px rgba(111,66,255,.22);
    }
    .cal-day.active-day{
      outline:3px solid rgba(111,66,255,.15);
    }
    .cal-day.has-event::after{
      content:"";
      width:7px;height:7px;border-radius:999px;
      background:#22c55e;
      position:absolute;bottom:8px;
    }

    .event-card{
      border:1px solid var(--border);
      border-radius:18px;
      padding:16px;
      background:#fff;
      margin-bottom:12px;
    }

    .badge-soft{
      display:inline-flex;
      align-items:center;
      gap:.35rem;
      border-radius:999px;
      padding:.38rem .7rem;
      font-size:.75rem;
      font-weight:700;
    }

    .badge-pending{background:#fff2f1;color:#ef4444}
    .badge-progress{background:#fff7ed;color:#f59e0b}
    .badge-completed{background:#eefbf1;color:#16a34a}

    .empty-state{
      text-align:center;
      padding:28px 16px;
      border:1px dashed #d9dfe9;
      border-radius:18px;
      color:#6f7786;
      background:#fafbff;
    }

    .top-action{
      width:42px;height:42px;border-radius:14px;
      border:1px solid var(--border);
      background:#fff;
      display:grid;place-items:center;
      color:#4b5160;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container py-2">
    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="dashboard.html">
      <div class="brand-badge">P</div>
      <span style="font-size:1.15rem;">Planning</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/todo">To-Do List</a></li>
        <li class="nav-item"><a class="nav-link" href="/habit">Habit Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/pengeluaran">Expense Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/notes">Notes</a></li>
        <li class="nav-item"><a class="nav-link active" href="/calendar">Calendar</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="page-wrap">
  <div class="container">
    <div class="row g-3">
      <div class="col-lg-8">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <!-- Judul Kalender dinamis mengikuti Bulan & Tahun dari Controller -->
              <div class="view-title">Calendar {{ $monthName }} {{ $year }}</div>
              <div class="section-sub">Lihat agenda dari Google Calendar</div>
            </div>
            <div class="d-flex gap-2">
              <!-- Tombol Prev & Next diubah jadi link agar otomatis pindah bulan -->
              <a href="?month={{ $prevMonth->format('m') }}&year={{ $prevMonth->format('Y') }}" class="top-action text-decoration-none">
                <i class="fa-solid fa-chevron-left"></i>
              </a>
              <a href="?month={{ $nextMonth->format('m') }}&year={{ $nextMonth->format('Y') }}" class="top-action text-decoration-none">
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </div>
          </div>

          <div class="calendar-box mb-4">
            <!-- Header Hari (Minggu - Sabtu) -->
            <div class="cal-grid mb-2">
              <div class="cal-day-head">Min</div>
              <div class="cal-day-head">Sen</div>
              <div class="cal-day-head">Sel</div>
              <div class="cal-day-head">Rab</div>
              <div class="cal-day-head">Kam</div>
              <div class="cal-day-head">Jum</div>
              <div class="cal-day-head">Sab</div>
            </div>
            
            <!-- Grid Kalender Dinamis dari Laravel -->
            <div class="cal-grid">
                {{-- Kotak kosong sebelum tanggal 1 --}}
                @for ($i = 0; $i < $firstDayOfWeek; $i++)
                    <div class="cal-day empty"></div>
                @endfor

                {{-- Tanggal 1 sampai akhir bulan --}}
                @for ($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $dateStr = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
                        $hasEvent = isset($eventsByDate[$dateStr]) ? 'has-event' : '';
                        $isToday = ($dateStr == date('Y-m-d')) ? 'today' : '';
                        $isActive = ($dateStr == $selectedDate) ? 'active-day' : '';
                    @endphp
                    <!-- Klik tanggal untuk melihat agenda detail di bawahnya -->
                    <a href="?month={{ $month }}&year={{ $year }}&date={{ $dateStr }}" class="cal-day text-decoration-none {{ $hasEvent }} {{ $isToday }} {{ $isActive }}">
                        {{ $d }}
                    </a>
                @endfor
            </div>
          </div>

          <div class="summary-mini">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <div class="fw-bold">Agenda Terpilih</div>
                <!-- Tanggal yang sedang diklik -->
                <div class="section-sub">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</div>
              </div>
              <div class="fw-bold text-success">{{ count($selectedDayEvents) }} agenda</div>
            </div>
            
            <!-- List Event pada tanggal tersebut -->
            <div>
              @forelse($selectedDayEvents as $event)
                  <div class="event-card">
                      <div class="badge-soft badge-completed mb-2">Google Calendar</div>
                      <div class="fw-bold">{{ $event['judul_list'] }}</div>
                      <div class="text-muted small mt-1">
                          <i class="fa-regular fa-clock"></i> {{ $event['waktu_mulai'] }} - {{ $event['waktu_selesai'] }}
                      </div>
                      @if($event['isi_list'])
                          <div class="text-muted small mt-2" style="font-style: italic;">{{ $event['isi_list'] }}</div>
                      @endif
                  </div>
              @empty
                  <div class="empty-state">Tidak ada agenda di tanggal ini.</div>
              @endforelse
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Ringkasan Kalender</h5>
              <div class="section-sub">Semua event bulan ini</div>
            </div>
          </div>

          <div class="d-flex gap-3 mb-3 flex-wrap">
            <div class="summary-mini w-100">
              <div class="muted">Total Event Bulan Ini</div>
              <!-- Hitung total seluruh event di bulan ini -->
              @php
                $totalEvents = 0;
                foreach($eventsByDate ?? [] as $events) {
                  $totalEvents += count($events);
                }
              @endphp
              <div class="fw-bold fs-5">{{ $totalEvents }} Event</div>
            </div>
          </div>

          <!-- Daftar Lengkap Semua Event di Sidebar Kanan -->
          <div style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
              @php
                $allEvents = [];
                foreach($eventsByDate ?? [] as $dateEvents) {
                  $allEvents = array_merge($allEvents, $dateEvents);
                }
              @endphp
              @forelse($allEvents as $event)
                  <div class="event-card mb-2">
                      <div class="fw-bold">{{ $event['judul_list'] ?? 'Tanpa Judul' }}</div>
                      <div class="text-muted small">
                          <i class="fa-regular fa-clock me-1"></i> {{ $event['waktu_mulai'] }} - {{ $event['waktu_selesai'] }}
                      </div>
                      @if($event['isi_list'])
                          <div class="text-muted small" style="font-size: 0.8rem; margin-top: 4px;">{{ $event['isi_list'] }}</div>
                      @endif
                  </div>
              @empty
                  <div class="empty-state">Belum ada event bulan ini.</div>
              @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Kalau di app.js lu ada kode buat generate tanggal, mending dihapus aja/dikomen biar gak nabrak sama Blade PHP ini -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>