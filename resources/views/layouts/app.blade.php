<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Moment.js dan Date Range Picker -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .card-stats {
            min-height: 120px;
        }

        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        .dark-mode .card {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .dark-mode .navbar,
        .dark-mode .nav-tabs {
            background-color: #1c1c1c !important;
        }

        .dark-mode .table {
            color: #fff;
        }

        .dark-mode .btn {
            border-color: #888;
        }
    </style>

    </stylbody.dark-mode>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-warning" href="#">🧾 EasyKasir</a>
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Logout</button>
                </form>
                <button id="darkModeToggle" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-moon"></i> Dark Mode
                </button>
            </div>
        </div>
    </nav>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                <i class="bi bi-cart-check"></i> Penjualan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}" href="{{ route('pembelian.index') }}">
                <i class="bi bi-truck"></i> Pembelian
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                <i class="bi bi-box-seam"></i> Produk
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('kategori-produk*') ? 'active' : '' }}" href="{{ route('kategori-produk.index') }}">
                <i class="bi bi-layers"></i> Jenis Produk
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('satuan*') ? 'active' : '' }}" href="{{ route('satuan.index') }}">
                <i class="bi bi-rulers"></i> Satuan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}" href="{{ route('supplier.index') }}">
                <i class="bi-person-badge"></i> Supplier
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>
        </li>


    </ul>

    <div class="container-fluid mt-4">
        @yield('content')
    </div>

    {{-- Notifikasi SweetAlert --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif


    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'error',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif

    @if(session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'warning'
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: 'error'
        });
    </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.form-hapus').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data ini tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        const toggle = document.getElementById('darkModeToggle');
        const body = document.body;

        // Cek preferensi sebelumnya
        if (localStorage.getItem('darkMode') === 'true') {
            body.classList.add('dark-mode');
        }

        toggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
        });
    </script>
</body>

</html>