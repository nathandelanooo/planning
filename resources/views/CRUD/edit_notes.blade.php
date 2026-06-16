<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Notes | Planning</title>

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
    .form-select,
    textarea.form-control{
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
        
        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
          <div class="brand-badge">
            <i class="fa-solid fa-note-sticky"></i>
          </div>
          <div>
            <h5 class="view-title m-0">Edit Notes</h5>
            <div class="section-sub">Perbarui catatan kamu</div>
          </div>
        </div>

        <form action="/notes/{{ $note->id_notes }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Judul Notes</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-heading"></i></span>
              <input type="text" name="judul_notes" class="form-control border-start-0" style="border-radius: 0 14px 14px 0;" 
                     placeholder="Misal: Ide Project Baru" value="{{ $note->judul_notes }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Isi Notes</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0 align-items-start pt-2" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-pencil"></i></span>
              <textarea name="isi_notes" class="form-control border-start-0" style="border-radius: 0 14px 14px 0;" 
                        placeholder="Tulis catatan lengkapmu di sini..." rows="8" required>{{ $note->isi_notes }}</textarea>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Voice Memo (Opsional)</label>
            
            @if($note->file_m)
              <div class="mb-2 p-3 border rounded" style="background: #fafbff; border-color: #e9ebf2 !important;">
                <small class="text-muted d-block mb-2 fw-semibold"><i class="fa-solid fa-headphones me-1"></i> Audio Saat Ini:</small>
                <audio controls style="width: 100%; height: 36px;">
                  <source src="{{ asset('storage/' . $note->file_m) }}" type="audio/mpeg">
                  Browser Anda tidak mendukung elemen audio.
                </audio>
              </div>
            @endif

            <div class="input-group mt-2">
              <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-microphone"></i></span>
              <input type="file" name="voice_memo" class="form-control border-start-0" style="border-radius: 0 14px 14px 0;" accept="audio/mp3, audio/wav">
            </div>
            <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">*Upload file baru jika ingin mengganti audio yang lama (Maks 5MB).</small>
          </div>

          <div class="d-flex gap-2">
            <a href="/notes" class="btn btn-light w-50" style="border-radius: 14px; border: 1px solid var(--border); font-weight: 600;">Batal</a>
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