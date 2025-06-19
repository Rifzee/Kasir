<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan</h2>
    <p>Periode: {{ $from }} s.d. {{ $to }}</p>
    <table>
        <tr>
            <th>Total Penjualan</th>
            <td>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pembelian</th>
            <td>Rp {{ number_format($totalPembelian, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Keuntungan Bersih</th>
            <td>Rp {{ number_format($laba, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>
