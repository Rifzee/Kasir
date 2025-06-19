@extends('layouts.app')
@section('title', 'Tambah Pembelian')

@section('content')
<h4 class="mb-3">Tambah Pembelian</h4>
@if($errors->any())
<div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('pembelian.store') }}" method="POST">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supplier as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->nama_perusahaan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4">
                    <label>Diskon (%)</label>
                    <input type="number" name="diskon" id="diskon-input" class="form-control" value="0">
                </div>
            </div>

            <hr>

            <h5>Produk Dibeli</h5>
            <table class="table table-bordered" id="table-produk">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th><button type="button" class="btn btn-sm btn-success" onclick="tambahBaris()">+</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="produk_id[]" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach($produk as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="qty[]" class="form-control qty-input" min="1" required></td>
                        <td><input type="number" name="harga[]" class="form-control harga-input" min="0" required></td>
                        <td><input type="text" class="form-control subtotal-input" readonly></td>
                        <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusBaris(this)">-</button></td>
                    </tr>

                </tbody>
            </table>
            <div class="mt-3 text-end">
                <label class="fw-bold me-2">Total Harga:</label>
                <span id="total-harga" class="fw-bold">Rp 0</span>
            </div>

        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
    function tambahBaris() {
        const row = document.querySelector('#table-produk tbody tr');
        const clone = row.cloneNode(true);
        clone.querySelectorAll('input').forEach(i => i.value = '');
        row.parentNode.appendChild(clone);
        refreshEventPembelian();
    }

    function hapusBaris(btn) {
        const row = btn.closest('tr');
        if (document.querySelectorAll('#table-produk tbody tr').length > 1) {
            row.remove();
        }
    }

    function refreshEventPembelian() {
        document.querySelectorAll('.qty-input, .harga-input').forEach(function(input) {
            input.oninput = function() {
                const row = this.closest('tr');
                hitungSubtotalPembelian(row);
            };
        });
    }

    function hitungSubtotalPembelian(row) {
        const qty = parseFloat(row.querySelector('.qty-input')?.value || 0);
        const harga = parseFloat(row.querySelector('.harga-input')?.value || 0);
        const subtotal = qty * harga;
        row.querySelector('.subtotal-input').value = 'Rp ' + subtotal.toLocaleString('id-ID');
        hitungTotalPembelian();
    }

    function hitungTotalPembelian() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(function(input) {
            const val = input.value.replace(/[Rp,. ]/g, '') || 0;
            total += parseInt(val);
        });

        const diskonPersen = parseFloat(document.getElementById('diskon-input')?.value || 0);
        const diskonNilai = total * (diskonPersen / 100);
        const totalSetelahDiskon = total - diskonNilai;

        document.getElementById('total-harga').innerText = 'Rp ' + totalSetelahDiskon.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function() {
        refreshEventPembelian();
        hitungTotalPembelian();
        const diskonInput = document.getElementById('diskon-input');
        if (diskonInput) {
            diskonInput.addEventListener('input', hitungTotalPembelian);
        }
    });
</script>
@endsection