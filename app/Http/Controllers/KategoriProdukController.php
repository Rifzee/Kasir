<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProduk;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::all();
        return view('kategori-produk.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori-produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_produks,nama',
        ]);

        KategoriProduk::create(['nama' => $request->nama]);

        return redirect()->route('kategori-produk.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('kategori-produk.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_produks,nama,' . $id,
        ]);

        $kategori = KategoriProduk::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect()->route('kategori-produk.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori-produk.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
