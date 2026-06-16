<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Tugas Kuliah Backend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="d-flex" id="wrapper">
        <div class="bg-dark text-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 border-bottom fs-5 fw-bold text-uppercase border-secondary">
                <i class="lni lni-grid-alt me-2 text-primary"></i>Admin
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="#" class="list-group-item list-group-item-action bg-transparent text-white active-link">
                    <i class="lni lni-home me-3"></i>Dashboard
                </a>
                <a href="/index" class="list-group-item list-group-item-action bg-transparent text-white opacity-75">
                    <i class="lni lni-users me-3"></i>Main Page
                </a>
                
            </div>
        </div>
        <div id="page-content-wrapper" class="w-100" style="position: relative;">
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 px-4 border-bottom shadow-sm d-flex justify-content-between" style="position: relative; z-index: 1040; overflow: visible;">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light me-3 border" id="menu-toggle">
                        <i class="lni lni-menu"></i>
                    </button>
                    <h4 class="m-0 fw-bold text-secondary fs-5">Sistem Informasi Manajemen</h4>
                </div>
                
                <div class="dropdown" style="position: relative; z-index: 1060;">
                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 14px; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}{{ strtoupper(substr(Auth::user()->username, 1, 1)) }}
                        </div>
                        <span class="fw-medium">{{ ucfirst(Auth::user()->username) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu" style="z-index: 1061;">
                        <li><a class="dropdown-item py-2" href="#"><i class="lni lni-user me-2 text-secondary"></i> Profil Saya</a></li>
                        <li><a class="dropdown-item py-2" href="#"><i class="lni lni-lock-alt me-2 text-secondary"></i> Keamanan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="/logout"><i class="lni lni-exit me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4 py-4" style="position: relative; z-index: 1;">
                
                <form action="/dashboard" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari data berdasarkan username..." name="keyword" value="{{ request('keyword') }}" style="border-radius: 14px 0 0 14px;">
                        <button class="btn btn-primary px-4" type="submit" id="button-addon2" style="background: var(--primary); border-color: var(--primary); border-radius: 0 14px 14px 0;">
                            <i class="lni lni-search-alt me-2"></i>Find
                        </button>
                    </div>
                </form>

                <div class="panel-card p-3 bg-white">
                    <table class="table table-striped align-middle m-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 8%">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_pengguna as $pengguna)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><span class="fw-semibold text-dark">{{ $pengguna->username }}</span></td>
                                    <td class="text-muted small">{{ Str::limit($pengguna->password, 20) }}</td>
                                    <td><span class="fw-semibold text-dark">{{ $pengguna->nama_role }}</span></td>
                                    <td class="text-center">
                                        @if(Auth::id() != $pengguna->id_pengguna)
                                            <a href="/pengguna/{{ $pengguna->id_pengguna }}/edit" class="action-btn edit" title="Edit Data">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus{{ $pengguna->id_pengguna }}">
                                                <i class="lni lni-trash"></i>
                                            Hapus   
                                            </button>
                                        @else
                                            <span class="badge bg-secondary" title="Tidak bisa mengedit akun sendiri">Anda</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @foreach($data_pengguna as $pengguna)
    <div class="modal fade" id="hapus{{ $pengguna->id_pengguna }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="/pengguna/{{ $pengguna->id_pengguna }}" method="POST">
      @csrf
      @method('DELETE') 
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi!!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Konfirmasi untuk menghapus {{ $pengguna->username }} dari data pengguna?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Ya, Hapus</button>
      </div>
</form>
  </div>
</div>
@endforeach
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>