<div class="mb-3">
    <label for="nama" class="form-label">Nama Jenis</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $kategori->nama ?? '') }}" required>
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('kategori-produk.index') }}" class="btn btn-secondary">Kembali</a>
