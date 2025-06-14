<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    private function checkAuthorization()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'Dosen'])) {
            abort(403, 'Akses ditolak. Hanya Admin dan Dosen yang diizinkan');
        }
    }

    public function index()
    {
        $this->checkAuthorization();
        $borrowings = Borrowing::with('product')->paginate(10);
        return view('pages.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $this->checkAuthorization();
        $products = Product::all();
        return view('pages.borrowings.create', compact('products'));
    }

    public function store(Request $request)
    {
        $this->checkAuthorization();

        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $product = Product::find($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi']);
        }

        $borrowing = Borrowing::create($request->all());
        $product->decrement('stock', $request->quantity);

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dibuat');
    }

    public function edit($id)
    {
        $this->checkAuthorization();
        $borrowing = Borrowing::findOrFail($id);
        $products = Product::all();
        return view('pages.borrowings.edit', compact('borrowing', 'products'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization();

        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $product = Product::find($request->product_id);

        // Kembalikan stok sebelumnya sebelum update
        $oldQuantity = $borrowing->quantity;
        $product->increment('stock', $oldQuantity);

        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi']);
        }

        $borrowing->update($request->all());
        $product->decrement('stock', $request->quantity);

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->checkAuthorization();
        $borrowing = Borrowing::findOrFail($id);

        // Kembalikan stok saat menghapus
        $product = $borrowing->product;
        $product->increment('stock', $borrowing->quantity);

        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}
