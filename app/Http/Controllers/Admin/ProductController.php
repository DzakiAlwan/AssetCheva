<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
        $products = Product::with('category')->latest()->paginate(10);
        return view('pages.products.index', ["products" => $products]);
    }

    public function create()
    {
        $this->checkAuthorization();
        $categories = Category::all();
        return view('pages.products.create', ["categories" => $categories]);
    }

    public function store(Request $request)
    {
        $this->checkAuthorization();

        $validated = $request->validate([
            "name" => "required|min:3",
            "description" => "nullable",
            "stock" => "required",
            "category_id" => "required",
            "sku" => "required",
            "tanggal" => "nullable|date",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "source" => "nullable|string|max:255",
            "status" => "nullable|in:baru,second,rusak",
        ], [
            'name.required' => 'Nama produk/barang harus diisi!',
            'name.min' => 'Minimal 3 karakter!',
            'stock.required' => 'Stok harus diisi!',
            'category_id.required' => 'Kategori harus diisi!',
            'sku.required' => 'Kode produk/barang harus diisi!',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid!',
            'image.image' => 'File gambar tidak valid!',
            'status.in' => 'Status barang harus salah satu dari: baru, second, rusak',
        ]);

        $imageName = $request->hasFile('image')
            ? time() . '.' . $request->image->extension()
            : null;

        if ($imageName) {
            $request->image->move(public_path('images'), $imageName);
        }

        Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'description' => $request->description,
            'sku' => $request->sku,
            'category_id' => $request->category_id,
            'tanggal' => $request->tanggal,
            'image' => $imageName,
            'source' => $request->source,
            'status' => $request->status,
        ]);

        return redirect('/products')->with('success', 'Berhasil menambahkan Produk');
    }

    public function show($id)
    {
        $this->checkAuthorization();
        $product = Product::with('category')->findOrFail($id);
        return view('pages.products.detail', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization();

        $validated = $request->validate([
            "name" => "required|min:3",
            "description" => "nullable",
            "stock" => "required",
            "category_id" => "required",
            "sku" => "required",
            "tanggal" => "nullable|date",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "source" => "nullable|string|max:255",
            "status" => "nullable|in:baru,second,rusak",
        ]);

        $product = Product::findOrFail($id);
        $imageName = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image) {
                unlink(public_path('images/' . $product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $product->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'description' => $request->description,
            'sku' => $request->sku,
            'category_id' => $request->category_id,
            'tanggal' => $request->tanggal,
            'image' => $imageName,
            'source' => $request->source,
            'status' => $request->status,
        ]);

        return redirect('/products')->with('success', 'Berhasil mengubah produk');
    }

    public function delete($id)
    {
        $this->checkAuthorization();
        $product = Product::findOrFail($id);

        if ($product->image) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();
        return redirect('/products')->with('success', 'Berhasil menghapus produk');
    }
}
