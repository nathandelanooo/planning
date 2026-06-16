<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Planning Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container py-2">
    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
      <div class="brand-badge">P</div>
      <span style="font-size:1.15rem;">Planning</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
        <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/todo">To-Do List</a></li>
        <li class="nav-item"><a class="nav-link" href="/habit">Habits Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/pengeluaran">Expense Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/notes">Notes</a></li>
        <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
      </ul>


        
        <div class="dropdown ms-1">
          <button class="btn p-0 border-0 d-flex align-items-center gap-2 dropdown-toggle text-start" type="button" id="profileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
            
            <div class="d-none d-md-block">
              <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ ucfirst(Auth::user()->username) }}</div>
              <div class="text-muted small" style="font-size: 0.78rem; margin-top: -2px;">
                {{ Auth::user()->id_role == 1 ? 'Administrator' : 'User' }}
              </div>
            </div>
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" aria-labelledby="profileMenuButton" style="border-radius: 16px; min-width: 180px;">
            <li>
              <a href="/dashboard" class="dropdown-item py-2 d-flex align-items-center gap-2 text-muted"   style="border-radius: 10px; font-size: 0.9rem;">
                <i class="fa-solid fa-sliders" style="width: 16px;"></i> Dashboard
              </a>
            </li>
            <li><hr class="dropdown-divider border-light my-2"></li>
            <li>
              <a class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger fw-semibold" href="/logout" 
                 style="border-radius: 10px; font-size: 0.9rem; background-color: #fff5f5;">
                <i class="fa-solid fa-arrow-right-from-bracket" style="width: 16px;"></i> Keluar
              </a>
            </li>
          </ul>
        </div>
        </div>
    </div>
  </div>
</nav>

<div class="page-wrap" id="home">
  <div class="container">
    <div class="row g-3 align-items-stretch">
      <div class="col-lg-4">
        <div class="hero-card p-4 p-md-5 h-100">
          <div class="row align-items-center h-100 g-4">
            <div class="col-md-7">
              <div class="badge rounded-pill text-bg-light border px-3 py-2 mb-3 fw-semibold" style="color:var(--primary);">
                Good Morning,
              </div>
              <div class="hero-title">{{ ucfirst(Auth::user()->username) }} 👋</div>
              <p class="hero-desc mt-3 mb-2">Let’s make today productive!</p>
              <p class="hero-desc fst-italic mb-4">“Small steps every day lead to big results.”</p>
            </div>
            <div class="col-md-5">
              <div class="hero-illustration">
                <div class="illus-board"></div>
                <div class="illus-check"><i class="fa-solid fa-check"></i></div>
                <div class="illus-clock"><i class="fa-regular fa-clock"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <div class="stat-card soft-purple">
          <div class="mini-icon mb-3"><i class="fa-regular fa-clipboard"></i></div>
          <div class="stat-value" id="statTasks">{{ $alltask ?? 0 }}</div>
          <div class="stat-label">Tasks To Do</div>
          <a href="#todo" class="stat-link d-inline-block mt-4">Lihat semua <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <div class="stat-card soft-green">
          <div class="mini-icon mb-3" style="color:#16a34a;background:#eafbf0;"><i class="fa-solid fa-bullseye"></i></div>
          <div class="stat-value" id="statHabits">{{ $activehabit ?? 0 }}</div>
          <div class="stat-label">Active Habits</div>
          <a href="#habit" class="stat-link d-inline-block mt-4" style="color:#16a34a;">Lihat semua <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <div class="stat-card soft-orange">
          <div class="mini-icon mb-3" style="color:#f59e0b;background:#fff3df;"><i class="fa-solid fa-wallet"></i></div>
          <div class="stat-value" id="statExpense">Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}</div>
          <div class="stat-label">Total Expense</div>
          <a href="#expense" class="stat-link d-inline-block mt-4" style="color:#f59e0b;">Lihat detail <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
      </div>
    </div>

    <div class="row g-3 mt-1">
      <div class="col-lg-5" id="todo">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">To-Do List</h5>
              <div class="section-sub">Daftar tugas harian dari backend</div>
            </div>
            <button class="btn btn-sm btn-primary px-3" style="background:var(--primary);border-color:var(--primary);border-radius:14px;">
              <a href="/todo" style="color: white; text-decoration: none;"><i class="fa-solid fa-plus me-1"></i>Tambah Tugas</a>
            </button>
          </div>

          <div id="todoList">
            @forelse($todolist ?? [] as $todo)
              <div class="note-item d-flex align-items-center justify-content-between gap-3 mb-3 p-2" style="border-bottom: 1px solid var(--border);">
                <div class="d-flex align-items-start gap-3">
                  <div class="mini-icon" style="background:var(--soft-purple); color:var(--primary); margin-top:2px; width:36px; height:36px; display:grid; place-items:center; border-radius:10px;">
                    <i class="fa-regular fa-square-check"></i>
                  </div>
                  <div>
                    <div class="fw-semibold" style="font-size: 0.95rem;">{{ $todo->judul_list }}</div>
                    <div class="text-muted" style="font-size:0.82rem;">
                      <i class="fa-regular fa-calendar-days me-1"></i> {{ \Carbon\Carbon::parse($todo->tanggal_mulai)->format('d M Y') }} 
                      <span class="mx-1">•</span>
                      <i class="fa-regular fa-clock me-1"></i> {{ $todo->waktu_mulai }}
                    </div>
                  </div>
                </div>

                <div>
                  @if($todo->status == 'pending')
                    <span class="badge-soft badge-pending">Pending</span>
                  @elseif($todo->status == 'progress')
                    <span class="badge-soft badge-progress">In Progress</span>
                  @elseif($todo->status == 'completed')
                    <span class="badge-soft badge-completed">Completed</span>
                  @endif
                </div>
              </div>
            @empty
              <div class="empty-state">Belum ada tugas hari ini.</div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="col-lg-4" id="habit">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title"></h5>
              <div class="section-sub">Progress kebiasaan harian</div>
            </div>
            <a href="#" class="stat-link">Lihat semua</a>
          </div>
          <div id="habitList">
            @forelse($recenthabit ?? [] as $habit)
              <div class="note-item d-flex align-items-center justify-content-between gap-3 mb-3 p-2" style="border-bottom: 1px solid var(--border);">
                <div class="d-flex align-items-start gap-3">
                  <div class="mini-icon" style="background:var(--soft-green); color:#16a34a; margin-top:2px; width:36px; height:36px; display:grid; place-items:center; border-radius:10px;">
                    <i class="fa-solid fa-bullseye"></i>
                  </div>
                  <div>
                    <div class="fw-semibold" style="font-size: 0.95rem;">{{ $habit->kategori_habit }}</div>
                    <div class="muted" style="font-size:0.85rem;">{{ Str::limit($habit->nama_habit, 50) }}</div>
                  </div>
                </div>
                
                <div>
                  @if($habit->status == 'active')
                    <span class="badge-soft badge-progress"><i class="fa-solid fa-spinner"></i> Active</span>
                  @elseif($habit->status == 'completed')
                    <span class="badge-soft badge-completed"><i class="fa-solid fa-check-circle"></i> Completed</span>
                  @else
                    <span class="badge-soft badge-pending"><i class="fa-solid fa-circle-pause"></i> Inactive</span>
                  @endif
                </div>
              </div>
            @empty
              <div class="empty-state">Belum ada kebiasaan.</div>
            @endforelse
          </div>
        </div>
      </div>


    </div>

    <div class="row g-3 mt-1">
      <div class="col-lg-4" id="calendar">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Calendar</h5>
              <div class="section-sub" id="calendarMonth">{{ $currentDate->translatedFormat('F Y') }}</div>
            </div>
            <div class="d-flex gap-2">
              <a href="?month={{ ($month == 1 ? 12 : $month - 1) }}&year={{ ($month == 1 ? $year - 1 : $year) }}" class="top-action"><i class="fa-solid fa-chevron-left"></i></a>
              <a href="?month={{ ($month == 12 ? 1 : $month + 1) }}&year={{ ($month == 12 ? $year + 1 : $year) }}" class="top-action"><i class="fa-solid fa-chevron-right"></i></a>
            </div>
          </div>

          <div class="calendar-box">
            <div class="cal-grid mb-2">
              @foreach(['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $day)
                <div class="cal-day-head">{{ $day }}</div>
              @endforeach
            </div>
            <div class="cal-grid">
              {{-- Empty cells untuk hari sebelum bulan dimulai --}}
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
                  <a href="?month={{ $month }}&year={{ $year }}&date={{ $dateStr }}" class="cal-day text-decoration-none {{ $hasEvent }} {{ $isToday }} {{ $isActive }}">
                      {{ $d }}
                  </a>
              @endfor
            </div>
          </div>

          <div class="mt-4">
            <div class="fw-bold mb-2">Today's Schedule</div>
            @forelse($selectedDayEvents as $event)
              <div class="event-card mb-2">
                <div class="fw-bold" style="font-size: 0.9rem;">{{ $event['judul_list'] }}</div>
                <div class="text-muted small">
                  <i class="fa-regular fa-clock me-1"></i> {{ $event['waktu_mulai'] }} - {{ $event['waktu_selesai'] }}
                </div>
                @if($event['isi_list'])
                  <div class="text-muted small mt-1" style="font-size: 0.8rem;">{{ $event['isi_list'] }}</div>
                @endif
              </div>
            @empty
              <div class="empty-state">Tidak ada agenda.</div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="col-lg-4" id="expense">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Expense Tracker </h5>
              <div class="section-sub">Catatan pengeluaran terbaru</div>
            </div>
            <a href="#" class="stat-link">Lihat detail</a>
          </div>

          <div class="stat-card soft-orange mb-3" style="padding:16px;border-radius:18px;">
            <div class="d-flex justify-content-between align-items-center">
              <div class="fw-semibold">Total Pengeluaran</div>
              <div class="fw-bold fs-5" id="expenseTotal">Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}</div>
            </div>
          </div>

          <div class="stat-card soft-green mb-3" style="padding:16px;border-radius:18px;">
            <div class="d-flex justify-content-between align-items-center">
              <div class="fw-semibold">Jumlah Catatan</div>
              <div class="fw-bold fs-5" id="expenseCount">{{ $expenseCount ?? 0 }}</div>
            </div>
          </div>

          <div id="expenseList"></div>
        </div>
      </div>

      <div class="col-lg-4" id="notes">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Recent Notes</h5>
              <div class="section-sub">Catatan terbaru</div>
            </div>
            <a href="#" class="stat-link">Lihat semua</a>
          </div>
           <div id="notesList">
             @forelse($recentNotes ?? [] as $note)
               <div class="note-item d-flex align-items-start gap-3 mb-3">
                 <div class="mini-icon" style="background:#fff7e9;color:#f59e0b;margin-top:2px;"><i class="fa-solid fa-note-sticky"></i></div>
                 <div class="flex-grow-1">
                   <div class="fw-semibold">{{ $note->judul_notes }}</div>
                   <div class="muted" style="font-size:0.85rem;">{{ Str::limit($note->isi_notes, 70) }}</div>
                 </div>
               </div>
             @empty
               <div class="empty-state">Belum ada notes.</div>
             @endforelse
           </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>