<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | Planning</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
      min-height:100vh;
    }

    .login-wrap{
      min-height:100vh;
      display:flex;
      align-items:center;
      padding:24px 0;
      background:
        radial-gradient(circle at top left, rgba(111,66,255,.12), transparent 35%),
        radial-gradient(circle at bottom right, rgba(111,66,255,.10), transparent 30%),
        var(--bg);
    }

    .login-card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:28px;
      box-shadow:var(--shadow);
      overflow:hidden;
    }

    .brand-badge{
      width:48px;height:48px;border-radius:16px;
      background:linear-gradient(135deg,var(--primary),#9b7bff);
      color:#fff;display:grid;place-items:center;
      box-shadow:0 10px 24px rgba(111,66,255,.25);
      font-weight:800;
      flex:0 0 auto;
      font-size:1.1rem;
    }

    .login-side{
      background:
        radial-gradient(circle at 20% 20%, rgba(111,66,255,.10), transparent 28%),
        linear-gradient(135deg,#f8f4ff 0%, #ffffff 65%);
      min-height:100%;
      padding:32px;
      position:relative;
    }

    .login-illus{
      width:100%;
      max-width:320px;
      aspect-ratio:1/1;
      margin:0 auto;
      border-radius:34px;
      background:linear-gradient(180deg,#fff,#f6f1ff);
      box-shadow:0 18px 40px rgba(111,66,255,.10);
      position:relative;
      border:1px solid rgba(111,66,255,.12);
      overflow:hidden;
    }

    .login-illus:before{
      content:"";
      position:absolute;
      left:28px;right:28px;top:28px;height:14px;
      border-radius:999px;
      background:rgba(111,66,255,.18);
    }

    .login-illus:after{
      content:"";
      position:absolute;
      left:40px;right:40px;bottom:38px;height:120px;
      border-radius:24px;
      background:linear-gradient(180deg,rgba(111,66,255,.12),rgba(111,66,255,.04));
    }

    .illus-check{
      position:absolute;
      right:24px;top:76px;
      width:92px;height:92px;border-radius:24px;
      background:#fff;
      display:grid;place-items:center;
      box-shadow:0 14px 30px rgba(31,36,48,.08);
      border:1px solid var(--border);
      font-size:2rem;color:var(--primary);
    }

    .illus-clock{
      position:absolute;
      left:22px;bottom:28px;
      width:68px;height:68px;border-radius:20px;
      background:#fff;
      display:grid;place-items:center;
      box-shadow:0 14px 30px rgba(31,36,48,.08);
      border:1px solid var(--border);
      color:var(--primary);
      font-size:1.4rem;
    }

    .login-form{
      padding:40px 36px;
    }

    .form-label{
      font-weight:700;
      color:#394150;
      font-size:.88rem;
      margin-bottom:.35rem;
    }

    .form-control{
      border-radius:14px;
      border:1px solid #dfe4ee;
      padding:.8rem .95rem;
      box-shadow:none !important;
    }

    .form-control:focus{
      border-color:rgba(111,66,255,.45);
      box-shadow:0 0 0 .2rem rgba(111,66,255,.08) !important;
    }

    .form-control.is-invalid{
      border-color:#dc3545;
    }

    .form-control.is-invalid:focus{
      border-color:#dc3545;
      box-shadow:0 0 0 .2rem rgba(220,53,69,.25) !important;
    }

    .invalid-feedback{
      font-size:.85rem;
      margin-top:.25rem;
    }

    .login-title{
      font-size:clamp(1.8rem,3vw,2.4rem);
      font-weight:800;
      letter-spacing:-.03em;
      line-height:1.05;
    }

    .login-sub{
      color:var(--muted);
    }

    .btn-primary{
      background:var(--primary);
      border-color:var(--primary);
      border-radius:14px;
      font-weight:700;
    }

    .btn-primary:hover{
      background:#5f34e6;
      border-color:#5f34e6;
    }

    .small-note{
      color:var(--muted);
      font-size:.88rem;
    }

    .password-toggle{
      position:absolute;
      right:14px;
      top:50%;
      transform:translateY(-50%);
      border:none;
      background:transparent;
      color:#7a8191;
      padding:0;
    }

    .signup-link{
      text-align:center;
      margin-top:1rem;
    }

    .signup-link a{
      color:var(--primary);
      font-weight:600;
      text-decoration:none;
    }

    .signup-link a:hover{
      text-decoration:underline;
    }

    @media (max-width: 991px){
      .login-form{padding:28px 22px}
      .login-side{min-height:auto;padding:26px 22px}
    }
  </style>
</head>
<body>

<div class="login-wrap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="login-card">
          <div class="row g-0">
            <div class="col-lg-6 login-side d-flex align-items-center">
              <div class="w-100 text-center">
                <div class="login-illus mb-4">
                  <div class="illus-check">
                    <i class="fa-solid fa-check"></i>
                  </div>
                  <div class="illus-clock">
                    <i class="fa-regular fa-clock"></i>
                  </div>
                </div>
                <h2 class="login-title mb-3">Bergabunglah dengan kami</h2>
                <p class="login-sub mb-0">
                  Mulai kelola To-Do, Habit, Expense, Notes, Calendar, dan Reminder dalam satu aplikasi.
                </p>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="login-form">
                <div class="d-flex align-items-center gap-3 mb-4">
                  <div class="brand-badge">P</div>
                  <div>
                    <div class="fw-bold fs-5">Planning</div>
                    <div class="small-note">Create your account</div>
                  </div>
                </div>

                @if ($errors->any())
                  <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                @if (session('success'))
                  <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                  </div>
                @endif

                <form id="signupForm" action="/signup" method="POST" novalidate>
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" value="{{ old('username') }}" required>
                    @error('username')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="position-relative">
                      <input type="password" id="password" name="password" class="form-control pe-5 @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                      <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                    @error('password')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="position-relative">
                      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pe-5 @error('password_confirmation') is-invalid @enderror" placeholder="Ulangi password" required>
                      <button type="button" class="password-toggle" id="togglePasswordConfirm">
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                    @error('password_confirmation')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-2">
                    Buat Akun
                  </button>
                </form>

                <p class="small-note text-center mt-4 mb-0">
                  Sudah punya akun? <a href="/login" style="color:var(--primary);font-weight:600;text-decoration:none;">Login di sini</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    if (password.type === 'password') {
      password.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      password.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  });

  document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
    const password = document.getElementById('password_confirmation');
    const icon = this.querySelector('i');
    if (password.type === 'password') {
      password.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      password.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  });
</script>
</body>
</html>
