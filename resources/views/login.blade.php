<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Planning</title>

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

    .demo-box{
      border:1px solid #eadfff;
      background:#faf7ff;
      border-radius:18px;
      padding:14px 16px;
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
                <h2 class="login-title mb-3">Plan your day, organize your life.</h2>
                <p class="login-sub mb-0">
                  Kelola To-Do, Habit, Expense, Notes, Calendar, dan Reminder dalam satu aplikasi.
                </p>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="login-form">
                <div class="d-flex align-items-center gap-3 mb-4">
                  <div class="brand-badge">P</div>
                  <div>
                    <div class="fw-bold fs-5">Planning</div>
                    <div class="small-note">Sign in to continue</div>
                  </div>
                </div>

                <div id="loginAlert" class="alert alert-danger d-none" role="alert"></div>

                <form id="loginForm" action="/login" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="position-relative">
                      <input type="password" id="password" name="password" class="form-control pe-5" placeholder="Masukkan password" required>
                      <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label small-note" for="rememberMe">
                        Remember me
                      </label>
                    </div>
                    <a href="#" class="small-note text-decoration-none" style="color:var(--primary);">
                      Lupa password?
                    </a>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-2">
                    Login
                  </button>
                </form>

                <p class="small-note text-center mt-4 mb-0">
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
</body>
</html>