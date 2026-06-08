<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Habit | Planning</title>

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
      --border:#e9ebf2;
      --radius:22px;
    }

    body{
      font-family:'Inter',sans-serif;
      background:var(--bg);
      color:var(--text);
    }

    .form-card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:0 12px 30px rgba(31,36,48,.06);
    }

    .form-label{
      font-weight:700;
      color:#394150;
      font-size:.88rem;
      margin-bottom:.35rem;
    }

    .form-control,
    .form-select{
      border-radius:14px;
      border:1px solid #dfe4ee;
      padding:.8rem .95rem;
      box-shadow:none !important;
    }

    .view-title{
      font-size:1.35rem;
      font-weight:800;
      letter-spacing:-.03em;
    }

    .section-sub{
      color:var(--muted);
      font-size:.92rem;
    }

    .brand-badge{
      width:42px;
      height:42px;
      border-radius:12px;
      background:linear-gradient(135deg,var(--primary),#9b7bff);
      color:#fff;
      display:grid;
      place-items:center;
      font-weight:800;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7"> 
      <div class="form-card p-4 shadow-sm bg-white">
        
        <!-- Header Section -->
        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
          <div class="brand-badge">
            <i class="fa-solid fa-check-double"></i>
          </div>
          <div>
            <h5 class="view-title m-0">Edit Data Habit</h5>
            <div class="section-sub">Perbarui detail habit tracker kamu</div>
          </div>
        </div>

        <form action="/habit/{{ $habit->id_habit_tracker }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Nama Habit</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-list-check"></i></span>
              <input type="text" name="nama_habit" class="form-control border-start-0" style="border-radius: 0 14px 14px 0;" 
                     placeholder="Misal: Lari pagi" value="{{ $habit->nama_habit }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Kategori Habit</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-tag"></i></span>
              <select name="kategori_habit" class="form-select border-start-0" style="border-radius: 0 14px 14px 0;" required>
                <option value="Kesehatan & Kebugaran" {{ $habit->kategori_habit == 'Kesehatan & Kebugaran' ? 'selected' : '' }}>Kesehatan & Kebugaran</option>
                <option value="Edukasi & Produktivitas" {{ $habit->kategori_habit == 'Edukasi & Produktivitas' ? 'selected' : '' }}>Edukasi & Produktivitas</option>
                <option value="Mental & Spiritual" {{ $habit->kategori_habit == 'Mental & Spiritual' ? 'selected' : '' }}>Mental & Spiritual</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-circle-notch"></i></span>
              <select name="status" class="form-select border-start-0" style="border-radius: 0 14px 14px 0;" required>
                <option value="active" {{ $habit->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $habit->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="completed" {{ $habit->status == 'completed' ? 'selected' : '' }}>Completed</option>
              </select>
            </div>
          </div>

          <div class="d-flex gap-2">
            <a href="/habit" class="btn btn-light w-50" style="border-radius: 14px; border: 1px solid var(--border); font-weight: 600;">Batal</a>
            <button type="submit" class="btn btn-primary w-50" style="background: var(--primary); border-color: var(--primary); border-radius: 14px; font-weight: 600;">
              Simpan Perubahan
            </button>
          </div>
        </form>

      </div> 
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
