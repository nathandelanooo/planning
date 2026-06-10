<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>To-Do List | Planning</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css\style.css">
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
    body{ font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); }
    .navbar{ background:rgba(255,255,255,.92); backdrop-filter: blur(10px); border-bottom:1px solid var(--border); }
    .brand-badge{ width:40px;height:40px;border-radius:14px; background:linear-gradient(135deg,var(--primary),#9b7bff); color:#fff;display:grid;place-items:center; box-shadow:0 10px 24px rgba(111,66,255,.25); font-weight:800; flex:0 0 auto; }
    .nav-link{ color:#4b5160 !important; font-weight:600; border-radius:999px; padding:.55rem .9rem !important; margin:0 .1rem; }
    .nav-link.active{ color:var(--primary) !important; background:#f4efff; }
    .page-wrap{padding:24px 0 40px}
    .panel-card, .form-card{ background:var(--card); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow); }
    .section-title{ font-size:1.05rem; font-weight:800; letter-spacing:-.02em; margin-bottom:0; }
    .section-sub{color:var(--muted);font-size:.92rem}
    .view-title{ font-size:1.35rem; font-weight:800; letter-spacing:-.03em; margin-bottom:.15rem; }
    .form-label{ font-weight:700; color:#394150; font-size:.88rem; margin-bottom:.35rem; }
    .form-control, .form-select, textarea.form-control{ border-radius:14px; border:1px solid #dfe4ee; padding:.8rem .95rem; box-shadow:none !important; }
    .table thead th{ color:#5b6270; font-size:.82rem; text-transform:uppercase; letter-spacing:.04em; border-bottom:1px solid var(--border) !important; }
    .table tbody td{ vertical-align:middle; border-color:#eef1f7; }
    .badge-soft{ display:inline-flex; align-items:center; gap:.35rem; border-radius:999px; padding:.38rem .7rem; font-size:.75rem; font-weight:700; }
    .badge-pending{background:#fff2f1;color:#ef4444}
    .badge-progress{background:#fff7ed;color:#f59e0b}
    .badge-completed{background:#eefbf1;color:#16a34a}
    .action-btn{ border:1px solid var(--border); background:#fff; border-radius:12px; width:36px;height:36px; display:inline-grid; place-items:center; color:#555; margin-left:.2rem; }
    .action-btn.edit{color:var(--primary)}
    .action-btn.delete{color:#ef4444}
    .summary-mini{ background:#fff; border:1px solid var(--border); border-radius:18px; padding:14px 16px; box-shadow:var(--shadow); }
    .empty-state{ text-align:center; padding:28px 16px; border:1px dashed #d9dfe9; border-radius:18px; color:#6f7786; background:#fafbff; }
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
        <li class="nav-item"><a class="nav-link" href="/index">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="/todo">To-Do List</a></li>
        <li class="nav-item"><a class="nav-link" href="/habit">Habit Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/pengeluaran">Expense Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/notes">Notes</a></li>
        <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="page-wrap">
  <div class="container">
    <div class="row g-3">
      <div class="col-lg-4">
        <div class="form-card p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <div class="view-title">To-Do List</div>
            </div>
          </div>

          <form id="todoForm" action="/todo" method="POST">
            @csrf
            
            <input type="hidden" id="todo_id_toDoList">
            <div class="mb-3">
              <label class="form-label">Judul List</label>
              <input type="text" name="judul_list" class="form-control" id="todo_judul_list" placeholder="Misal: Kerjakan Laporan UTS" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Isi List</label>
              <textarea class="form-control" name="isi_list" id="todo_isi_list" rows="4" placeholder="Detail tugas..." required></textarea>
            </div>

            <div class="row g-2">
              <div class="col-6 mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" id="todo_tanggal_mulai" required>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" class="form-control" id="todo_waktu_mulai" required>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" id="todo_tanggal_selesai" required>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" class="form-control" id="todo_waktu_selesai" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-select" name="status" id="todo_status">
                <option value="pending">Pending</option>
                <option value="progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div>

            <button class="btn btn-primary w-100" style="background:var(--primary);border-color:var(--primary);border-radius:14px;" type="submit">
              Simpan To-Do
            </button>
          </form>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Daftar To-Do</h5>
              <div class="section-sub">Tabel data dari sistem</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
              <a href="/todo?status=all" class="btn btn-sm btn-outline-secondary {{ $status === 'all' ? 'active' : '' }}">Semua</a>
              <a href="/todo?status=pending" class="btn btn-sm btn-outline-secondary {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
              <a href="/todo?status=progress" class="btn btn-sm btn-outline-secondary {{ $status === 'progress' ? 'active' : '' }}">In Progress</a>
              <a href="/todo?status=completed" class="btn btn-sm btn-outline-secondary {{ $status === 'completed' ? 'active' : '' }}">Completed</a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Judul</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Status</th>
                  <th class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody id="todoTable">
                
                @forelse($todos as $item)
                  <tr>
                    <td>
                      <div class="fw-bold">{{ $item->judul_list }}</div>
                      <div class="muted" style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $item->isi_list }}
                      </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}<br><span class="muted">{{ $item->waktu_mulai }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}<br><span class="muted">{{ $item->waktu_selesai }}</span></td>
                    <td>
                      @if($item->status == 'completed')
                        <span class="badge-soft badge-completed">Completed</span>
                      @elseif($item->status == 'progress')
                        <span class="badge-soft badge-progress">In Progress</span>
                      @else
                        <span class="badge-soft badge-pending">Pending</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <a href="/todo/{{ $item->id_to_do_list }}/edit" class="action-btn edit"><i class="fa-solid fa-pencil"></i></a>
                      <button class="action-btn delete"><i class="fa-solid fa-trash"></i></button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5">
                      <div class="empty-state">Belum ada data to-do.</div>
                    </td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function deleteTodo(id) {
    if (confirm('Yakin hapus?')) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/todo/${id}`;
      form.innerHTML = `
        @csrf
        <input type="hidden" name="_method" value="DELETE">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  }
</script>
</body>
</html>