<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Pengguna | Planning</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      
      <div class="form-card p-4 shadow-sm bg-white" style="border-radius: var(--radius); border: 1px solid var(--border);">
        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
          <div class="brand-badge text-white d-grid place-items-center" style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), #9b7bff);">
            <i class="fa-solid fa-user-pen"></i>
          </div>
          <div>
            <h5 class="view-title m-0" style="font-size: 1.35rem; font-weight: 800; letter-spacing: -.03em;">Edit Data Pengguna</h5>
            <div class="section-sub text-muted" style="font-size: .92rem;">Perbarui kredensial akun sistem</div>
          </div>
        </div>

        <form action="/pengguna/{{ $pengguna->id_pengguna }}" method="POST">
          @csrf
          @method('PUT') <div class="mb-3">
            <label class="form-label" style="font-weight: 700; color: #394150; font-size: .88rem;">Username</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-user"></i></span>
              <input type="text" name="username" class="form-control border-start-0" style="border-radius: 0 14px 14px 0;" 
                     value="{{ $pengguna->username }}" placeholder="Masukkan username baru" required>
            </div>
          </div>
          </div>

          <div class="mb-4">
            <label class="form-label" style="font-weight: 700; color: #394150; font-size: .88rem;">Role Pengguna</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-user-shield"></i></span>
              <select name="id_role" class="form-select border-start-0" style="border-radius: 0 14px 14px 0;" required>
                <option value="" disabled>-- Pilih Hak Akses --</option>
                <option value="1" {{ $pengguna->id_role == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $pengguna->id_role == 2 ? 'selected' : '' }}>User</option>
              </select>
            </div>
          </div>

          <div class="d-flex gap-2">
            <a href="/dashboard" class="btn btn-light w-50" style="border-radius: 14px; border: 1px solid var(--border); font-weight: 600;">Batal</a>
            <button type="submit" class="btn btn-primary w-50" style="background: var(--primary); border-color: var(--primary); border-radius: 14px; font-weight: 600;">
              Simpan Perubahan
            </button>
          </div>
        </form>

      </div> </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>