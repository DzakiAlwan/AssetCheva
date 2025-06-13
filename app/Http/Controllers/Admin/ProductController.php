<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('pages.products.index', [
            "products" => $products,
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('pages.products.create', [
            "categories" => $categories,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            "name" => "required|min:3",
            "description" => "nullable",
            "stock" => "required",
            "category_id" => "required",
            "sku" => "required",
            "tanggal" => "nullable|date",  // Validasi tanggal
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048", // Validasi gambar
            "source" => "nullable|string|max:255",
            "status" => "nullable|in:baru,second,rusak",
        ], [
            'name.required'        => 'Nama produk/barang harus diisi!',
            'name.min'             => 'Minimal 3 karakter!',
            'stock.required'       => 'Stok harus diisi!',
            'category_id.required' => 'Kategori harus diisi!',
            'sku.required'         => 'Kode produk/barang harus diisi!',
            'tanggal.date'         => 'Tanggal harus berupa tanggal yang valid!',
            'image.image'          => 'File gambar tidak valid!',
            'status.in'            => 'Status barang harus salah satu dari: baru, second, rusak',
        ]);

        // Gambar
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        // Menyimpan data produk ke dalam database
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

    $product = Product::with('category')->findOrFail($id);
    return view('pages.products.detail', compact('product'));
    
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            "name" => "required|min:3",
            "description" => "nullable",
            "stock" => "required",
            "category_id" => "required",
            "sku" => "required",
            "tanggal" => "nullable|date",  // Validasi tanggal
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048", // Validasi gambar
            "source" => "nullable|string|max:255",
            "status" => "nullable|in:baru,second,rusak",
        ], [
            'name.required'        => 'Nama produk/barang harus diisi!',
            'name.min'             => 'Minimal 3 karakter!',
            'stock.required'       => 'Stok harus diisi!',
            'category_id.required' => 'Kategori harus diisi!',
            'sku.required'         => 'Kode produk/barang harus diisi!',
            'tanggal.date'         => 'Tanggal harus berupa tanggal yang valid!',
            'image.image'          => 'File gambar tidak valid!',
            'status.in'            => 'Status barang harus salah satu dari: baru, second, rusak',
        ]);

        // Menangani gambar jika ada
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            // Jika ada gambar baru, hapus gambar lama
            if ($product->image) {
                unlink(public_path('images/' . $product->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = $product->image;  // Tetap menggunakan gambar lama jika tidak ada yang di-upload
        }

        // Update produk di database
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
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect('/products')->with('success', 'Berhasil menghapus produk');
    }
}
