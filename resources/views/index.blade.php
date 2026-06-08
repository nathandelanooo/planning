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

      <div class="d-flex align-items-center gap-2">
        <button class="top-action"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="top-action position-relative">
          <i class="fa-regular fa-bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </button>
        
        <div class="dropdown ms-1">
          <button class="btn p-0 border-0 d-flex align-items-center gap-2 dropdown-toggle text-start" type="button" id="profileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
            <img src="https://i.pravatar.cc/80?img=12" alt="user" style="width:42px;height:42px;border-radius:14px;object-fit:cover;border:1px solid var(--border);">
            <div class="d-none d-md-block">
              <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ ucfirst(Auth::user()->username) }}</div>
              <div class="text-muted small" style="font-size: 0.78rem; margin-top: -2px;">
                {{ Auth::user()->id_role == 1 ? 'Administrator' : 'User' }}
              </div>
            </div>
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" aria-labelledby="profileMenuButton" style="border-radius: 16px; min-width: 180px;">
            <li>
              <a class="dropdown-item py-2 d-flex align-items-center gap-2 text-muted" href="#profile" style="border-radius: 10px; font-size: 0.9rem;">
                <i class="fa-regular fa-user" style="width: 16px;"></i> Profil Saya
              </a>
            </li>
            <li>
              <a class="dropdown-item py-2 d-flex align-items-center gap-2 text-muted" href="#settings" style="border-radius: 10px; font-size: 0.9rem;">
                <i class="fa-solid fa-sliders" style="width: 16px;"></i> Pengaturan
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
          <div class="stat-value" id="statTasks">12</div>
          <div class="stat-label">Tasks Today</div>
          <a href="#todo" class="stat-link d-inline-block mt-4">Lihat semua <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <div class="stat-card soft-green">
          <div class="mini-icon mb-3" style="color:#16a34a;background:#eafbf0;"><i class="fa-solid fa-bullseye"></i></div>
          <div class="stat-value" id="statHabits">5</div>
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

      <div class="col-6 col-lg-2">
        <div class="stat-card soft-blue">
          <div class="mini-icon mb-3" style="color:#2563eb;background:#eaf1ff;"><i class="fa-solid fa-chart-line"></i></div>
          <div class="stat-value" id="statScore">85%</div>
          <div class="stat-label">Productivity Score</div>
          <a href="#analytics" class="stat-link d-inline-block mt-4" style="color:#2563eb;">Lihat analitik <i class="fa-solid fa-chevron-right ms-1"></i></a>
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
              <a href="todo.html" style="color: white; text-decoration: none;"><i class="fa-solid fa-plus me-1"></i>Tambah Tugas</a>
            </button>
          </div>

          <div class="d-flex flex-wrap gap-2 tabs-btns mb-3">
            <button class="btn btn-sm active" data-filter="all">Semua</button>
            <button class="btn btn-sm" data-filter="pending">Pending</button>
            <button class="btn btn-sm" data-filter="progress">In Progress</button>
            <button class="btn btn-sm" data-filter="completed">Completed</button>
          </div>

          <div id="todoList"></div>
          <div class="pt-2">
            <a href="#" class="stat-link">Lihat semua tugas <i class="fa-solid fa-chevron-right ms-1"></i></a>
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
          <div id="habitList"></div>
        </div>
      </div>

      <div class="col-lg-3" id="reminder">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Reminders</h5>
              <div class="section-sub">Pengingat aktif</div>
            </div>
            <a href="#" class="stat-link">Lihat semua</a>
          </div>
          <div id="reminderList"></div>
        </div>
      </div>
    </div>

    <div class="row g-3 mt-1">
      <div class="col-lg-4" id="calendar">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Calendar</h5>
              <div class="section-sub" id="calendarMonth"></div>
            </div>
            <div class="d-flex gap-2">
              <button class="top-action" id="prevMonth"><i class="fa-solid fa-chevron-left"></i></button>
              <button class="top-action" id="nextMonth"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
          </div>

          <div class="calendar-box">
            <div class="cal-grid mb-2" id="calHead"></div>
            <div class="cal-grid" id="calGrid"></div>
          </div>

          <div class="mt-4">
            <div class="fw-bold mb-2">Today’s Schedule</div>
            <div id="todaySchedule"></div>
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

    <div class="row g-3 mt-1" id="analytics">
      <div class="col-lg-12">
        <div class="panel-card p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Activity Summary</h5>
              <div class="section-sub">Ringkasan aktivitas mingguan</div>
            </div>
            <select class="form-select form-select-sm" style="width:auto;border-radius:14px;">
              <option>This Week</option>
              <option>This Month</option>
            </select>
          </div>
          <div class="chart-wrap">
            <canvas id="activityChart"></canvas>
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