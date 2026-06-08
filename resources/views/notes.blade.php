<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notes | Planning</title>

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

    .form-label{
      font-weight:700;
      color:#394150;
      font-size:.88rem;
      margin-bottom:.35rem;
    }

    .form-control,
    .form-select,
    textarea.form-control{
      border-radius:14px;
      border:1px solid #dfe4ee;
      padding:.8rem .95rem;
      box-shadow:none !important;
    }

    .table thead th{
      color:#5b6270;
      font-size:.82rem;
      text-transform:uppercase;
      letter-spacing:.04em;
      border-bottom:1px solid var(--border) !important;
    }
    .table tbody td{
      vertical-align:middle;
      border-color:#eef1f7;
    }

    .action-btn{
      border:1px solid var(--border);
      background:#fff;
      border-radius:12px;
      width:36px;height:36px;
      display:inline-grid;
      place-items:center;
      color:#555;
      margin-left:.2rem;
    }
    .action-btn.edit{color:var(--primary)}
    .action-btn.delete{color:#ef4444}

    .summary-mini{
      background:#fff;
      border:1px solid var(--border);
      border-radius:18px;
      padding:14px 16px;
      box-shadow:var(--shadow);
    }

    .empty-state{
      text-align:center;
      padding:28px 16px;
      border:1px dashed #d9dfe9;
      border-radius:18px;
      color:#6f7786;
      background:#fafbff;
    }

    .note-card{
      border:1px solid var(--border);
      border-radius:18px;
      padding:16px;
      background:#fff;
      margin-bottom:12px;
    }

    .note-preview{
      color:var(--muted);
      font-size:.92rem;
      line-height:1.5;
    }

    .audio-chip{
      display:inline-flex;
      align-items:center;
      gap:.4rem;
      border-radius:999px;
      padding:.35rem .7rem;
      background:#f4efff;
      color:var(--primary);
      font-size:.8rem;
      font-weight:700;
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
        <li class="nav-item"><a class="nav-link" href="/index">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/todo">To-Do List</a></li>
        <li class="nav-item"><a class="nav-link" href="/habit">Habit Tracker</a></li>
        <li class="nav-item"><a class="nav-link" href="/pengeluaran">Expense Tracker</a></li>
        <li class="nav-item"><a class="nav-link active" href="/notes">Notes</a></li>
        <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
        <li class="nav-item"><a class="nav-link" href="/reminder">Reminder</a></li>
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
              <div class="view-title">Notes</div>
            </div>
          </div>

          <form id="notesForm" action="/notes" method="POST">
            @csrf
            <input type="hidden" id="notes_id_notes">
            <input type="hidden" id="notes_id_pengguna" value="1">

            <!-- Judul Notes -->
            <div class="mb-3">
              <label class="form-label">Judul Notes</label>
              <input type="text" name="judul_notes" class="form-control" id="notes_judul_notes" placeholder="Misal: Ide Project" required>
            </div>

            <!-- Isi Notes -->
            <div class="mb-3">
              <label class="form-label">Isi Notes</label>
              <textarea class="form-control" name="isi_notes" id="notes_isi_notes" rows="6" placeholder="Tulis isi catatan..." required></textarea>
            </div>

            <!-- Tombol Simpan -->
            <button class="btn btn-primary w-100" style="background:var(--primary);border-color:var(--primary);border-radius:14px;" type="submit">
              Simpan Notes
            </button>
          </form>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="panel-card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="section-title">Daftar Notes</h5>
              <div class="section-sub">Tabel data dari sistem</div>
            </div>
          </div>

          <div class="d-flex gap-3 mb-3 flex-wrap">
            <div class="summary-mini">
              <div class="muted">Jumlah Notes</div>
              <div class="fw-bold fs-5" id="notesCountPage">{{ $notes->count() }}</div>
            </div>
          </div>

          <div id="notesListPage"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="app.js"></script>
</body>
</html>