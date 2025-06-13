<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Product;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        // Ambil semua data peminjaman dan relasikan dengan produk
        $borrowings = Borrowing::with('product')->paginate(10);
        return view('pages.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        // Ambil semua produk yang tersedia
        $products = Product::all();
        return view('pages.borrowings.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id', // Validasi untuk memastikan produk ada
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        // Ambil produk yang dipilih
        $product = Product::find($request->product_id);

        // Cek apakah stok barang mencukupi
        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Jumlah barang yang dipinjam melebihi stok yang tersedia.']);
        }

        // Simpan peminjaman barang
        $borrowing = new Borrowing();
        $borrowing->borrower_name = $request->borrower_name;
        $borrowing->product_id = $request->product_id;
        $borrowing->quantity = $request->quantity;
        $borrowing->borrow_date = $request->borrow_date;
        $borrowing->return_date = $request->return_date;
        $borrowing->save();

        // Kurangi stok barang
        $product->stock -= $request->quantity;
        $product->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('pages.borrowings.index')->with('success', 'Peminjaman barang berhasil disimpan.');
    }

    public function edit($id)
    {
        // Ambil data peminjaman berdasarkan ID
        $borrowing = Borrowing::findOrFail($id);
        // Ambil semua produk yang tersedia
        $products = Product::all();

        return view('pages.borrowings.edit', compact('borrowing', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        // Ambil data peminjaman dan produk yang dipilih
        $borrowing = Borrowing::findOrFail($id);
        $product = Product::find($request->product_id);

        // Cek apakah stok barang mencukupi
        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Jumlah barang yang dipinjam melebihi stok yang tersedia.']);
        }

        // Update peminjaman barang
        $borrowing->borrower_name = $request->borrower_name;
        $borrowing->product_id = $request->product_id;
        $borrowing->quantity = $request->quantity;
        $borrowing->borrow_date = $request->borrow_date;
        $borrowing->return_date = $request->return_date;
        $borrowing->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('pages.borrowings.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus data peminjaman berdasarkan ID
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return redirect()->route('pages.borrowings.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
