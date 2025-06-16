<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
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
        $borrowings = Borrowing::with(['product', 'user'])->paginate(10);
        return view('pages.borrowings.index', compact('borrowings'));
    }

    // BorrowingController.php
    public function create()
    {
        $this->checkAuthorization();

        $products = Product::all();
        $users = User::all();

        return view('pages.borrowings.create', compact('products', 'users'));
    }

    // app/Http/Controllers/BorrowingController.php
    public function store(Request $request)
    {
        $this->checkAuthorization();

        // Debug data yang diterima
        Log::debug('Request Data:', $request->all());

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        // Debug data setelah validasi
        Log::debug('Validated Data:', $validated);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        try {
            DB::beginTransaction();

            $borrowingData = [
                'user_id' => $validated['user_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'borrow_date' => $validated['borrow_date'],
                'return_date' => $validated['return_date'],
                'status' => 'Dipinjam',
            ];

            // Debug data sebelum create
            Log::debug('Creating Borrowing:', $borrowingData);

            $borrowing = new Borrowing();
            $borrowing->fill($borrowingData);
            $borrowing->save();

            $product->decrement('stock', $validated['quantity']);

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Peminjaman berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating borrowing: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $this->checkAuthorization();
        $borrowing = Borrowing::with(['user', 'product'])->findOrFail($id);
        $products = Product::all();
        $users = User::all();

        return view('pages.borrowings.edit', compact('borrowing', 'products', 'users'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization();

        $borrowing = Borrowing::findOrFail($id);

        // Jika status sudah Dikembalikan, tidak boleh edit
        if ($borrowing->status == 'Dikembalikan') {
            return back()
                ->withErrors(['error' => 'Data peminjaman yang sudah dikembalikan tidak dapat diubah'])
                ->withInput();
        }

        // Validasi hanya status yang bisa diubah dari Dipinjamkan ke Dikembalikan
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'status' => 'required|in:Dipinjamkan,Dikembalikan',
        ]);

        // Jika mencoba mengubah status selain ke Dikembalikan
        if ($validatedData['status'] != 'Dikembalikan') {
            return back()
                ->withErrors(['status' => 'Hanya boleh mengubah status menjadi Dikembalikan'])
                ->withInput();
        }

        $product = Product::findOrFail($validatedData['product_id']);
        $originalQuantity = $borrowing->quantity;
        $originalProductId = $borrowing->product_id;

        DB::beginTransaction();
        try {
            // Kembalikan stok karena status berubah menjadi Dikembalikan
            $originalProduct = Product::find($originalProductId);
            $originalProduct->increment('stock', $originalQuantity);

            // Update peminjaman
            $borrowing->update($validatedData);

            DB::commit();

            return redirect()->route('borrowings.index')
                ->with('success', 'Status peminjaman berhasil diperbarui menjadi Dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.'])
                ->withInput();
        }
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
