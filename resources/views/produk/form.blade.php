<div class="mb-3">
    <label for="nama" class="form-label">Nama Produk</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="kategori_produk_id" class="form-label">Kategori</label>
    <select name="kategori_produk_id" class="form-select" required>
        <option value="">-- Pilih --</option>
        @foreach($kategori as $k)
            <option value="{{ $k->id }}" {{ old('kategori_produk_id', $produk->kategori_produk_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="satuan_id" class="form-label">Satuan</label>
    <select name="satuan_id" class="form-select" required>
        <option value="">-- Pilih --</option>
        @foreach($satuan as $s)
            <option value="{{ $s->id }}" {{ old('satuan_id', $produk->satuan_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="harga_beli" class="form-label">Harga Beli</label>
    <input type="number" name="harga_beli" class="form-control" value="{{ old('harga_beli', $produk->harga_beli ?? 0) }}" required>
</div>

<div class="mb-3">
    <label for="harga_jual" class="form-label">Harga Jual</label>
    <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual', $produk->harga_jual ?? 0) }}" required>
</div>

<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok ?? 0) }}" required>
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
