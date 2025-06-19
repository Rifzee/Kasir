<div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $supplier->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
    <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $supplier->nama_perusahaan ?? '') }}">
</div>

<div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $supplier->alamat ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="telepon" class="form-label">Telepon</label>
    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $supplier->telepon ?? '') }}" required>
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
