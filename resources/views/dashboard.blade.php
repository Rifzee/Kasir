@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<!-- Include Chart.js and daterangepicker -->
<!-- @push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endpush -->

@if($produkStokMenipis->count())
<div class="alert alert-warning">
    <strong>⚠️ Peringatan:</strong> Beberapa produk memiliki stok kurang dari 10:
    <ul class="mb-0 mt-2">
        @foreach($produkStokMenipis as $p)
        <li>{{ $p->nama }} (stok: {{ $p->stok }})</li>
        @endforeach
    </ul>
</div>
@endif

<h4 class="mb-4 fw-semibold">Overview</h4>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card card-stats shadow-sm">
            <div class="card-body">
                <h6>Penjualan</h6>
                <h4>{{ $totalPenjualan }}</h4>
                <small class="text-success"></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats shadow-sm">
            <div class="card-body">
                <h6>Pembelian</h6>
                <h4>{{ $totalPembelian }}</h4>
                <small class="text-success"></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats shadow-sm">
            <div class="card-body">
                <h6>Produk</h6>
                <h4>{{ $totalProduk }}</h4>
                <small>{{ $totalKategori }} kategori</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats shadow-sm">
            <div class="card-body">
                <h6>Keuntungan</h6>
                <h4>Rp {{ number_format($keuntungan, 0, ',', '.') }}</h4>
                <small class="text-success"></small>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Grafik Keuntungan & Penjualan</h5>
    <div class="d-flex">
        <input type="text" id="rangePicker" class="form-control w-auto me-2">
        <button id="submitRange" class="btn btn-primary">Tampilkan</button>
    </div>
</div>

<canvas id="chartKeuntunganPenjualan" height="100"></canvas>

@endsection

@push('scripts')
<script>
    let chart;
    let selectedStart, selectedEnd;

    function renderChart(labels, keuntungan, penjualan) {
        const ctx = document.getElementById('chartKeuntunganPenjualan').getContext('2d');
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Keuntungan (Rp)',
                        data: keuntungan,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Jumlah Penjualan',
                        data: penjualan,
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25,135,84,0.1)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function fetchChartData(start, end) {
        console.log(`Fetching data dari ${start} sampai ${end}`);

        fetch(`/dashboard/chart-data?start=${start}&end=${end}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal mengambil data dari server');
                }
                return response.json();
            })
            .then(data => {
                const totalData =
                    data.keuntungan.reduce((a, b) => a + b, 0) +
                    data.penjualan.reduce((a, b) => a + b, 0);

                if (totalData === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Data',
                        text: 'Tidak ditemukan data untuk tanggal tersebut.'
                    });
                    if (chart) chart.destroy();
                    return;
                }

                renderChart(data.labels, data.keuntungan, data.penjualan);
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: error.message
                });
            });
    }

    $(function() {
        const start = moment().subtract(6, 'days');
        const end = moment();

        $('#rangePicker').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: 'YYYY-MM-DD'
            },
            ranges: {
                'Hari Ini': [moment(), moment()],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            }
        }, function(startDate, endDate) {
            selectedStart = startDate.format('YYYY-MM-DD');
            selectedEnd = endDate.format('YYYY-MM-DD');
        });

        // Inisialisasi awal
        selectedStart = start.format('YYYY-MM-DD');
        selectedEnd = end.format('YYYY-MM-DD');

        // Fetch data pertama kali saat halaman load
        fetchChartData(selectedStart, selectedEnd);

        // Tambahkan event click pada tombol
        $('#submitRange').on('click', function() {
            fetchChartData(selectedStart, selectedEnd);
        });
    });
</script>
@endpush