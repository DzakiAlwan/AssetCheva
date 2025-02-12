<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Peminjam;

class PeminjamController extends Controller
{
    public function index()
    {
        // Ambil semua data peminjaman dengan relasi ke produk
        $peminjams = Peminjam::with('product')->paginate(1);

        return view('pages.peminjam.index', compact('peminjams'));
    }

    public function create()
    {
        $products = Product::all(); // Ambil semua produk untuk dropdown
        return view('pages.peminjam.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            "name" => "required|min:3",
            "product_id" => "required|exists:products,id",
            "jumlah" => "required|integer|min:1",
            "pengembalian" => "required|date|after_or_equal:today",
        ], [
            'name.required'        => 'Nama peminjam harus diisi!',
            'name.min'             => 'Nama minimal 3 karakter!',
            'product_id.required'  => 'Produk harus dipilih!',
            'product_id.exists'    => 'Produk yang dipilih tidak valid!',
            'jumlah.required'      => 'Jumlah harus diisi!',
            'jumlah.integer'       => 'Jumlah harus berupa angka!',
            'jumlah.min'           => 'Jumlah minimal 1!',
            'pengembalian.required' => 'Tanggal pengembalian harus diisi!',
            'pengembalian.date'    => 'Format tanggal tidak valid!',
            'pengembalian.after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum hari ini!',
        ]);

        // Simpan data ke database
        Peminjam::create([
            'name' => $request->name,
            'product_id' => $request->product_id,
            'jumlah' => $request->jumlah,
            'pengembalian' => $request->pengembalian,
        ]);

        return redirect('/peminjam')->with('success', 'Data peminjaman berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $peminjam = Peminjam::findOrFail($id);
        $products = Product::all();
        return view('pages.peminjam.edit', compact('peminjam', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "required|min:3",
            "product_id" => "required|exists:products,id",
            "jumlah" => "required|integer|min:1",
            "pengembalian" => "required|date|after_or_equal:today",
        ]);

        $peminjam = Peminjam::findOrFail($id);
        $peminjam->update([
            'name' => $request->name,
            'product_id' => $request->product_id,
            'jumlah' => $request->jumlah,
            'pengembalian' => $request->pengembalian,
        ]);

        return redirect('/peminjam')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function delete($id)
    {
        $peminjam = Peminjam::findOrFail($id);
        $peminjam->delete();

        return redirect('/peminjam')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
