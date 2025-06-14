<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private function checkAuthorization()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        // Cek role user
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'Dosen'])) {
            if (url()->previous() !== url()->current()) {
                return redirect()->back()->with('error', 'Akses ditolak. Hanya Admin dan Dosen yang bisa mengakses halaman ini.');
            }
            abort(403, 'Akses ditolak. Hanya Admin dan Dosen yang bisa mengakses halaman ini.');
        }
    }

    public function index()
    {
        $this->checkAuthorization();

        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        $this->checkAuthorization();

        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        $this->checkAuthorization();

        $validated = $request->validate([
            "name" => "required|unique:categories,name",
        ], [
            "name.required" => "Nama Kategori harus di isi",
            "name.unique" => "Nama Kategori sudah ada!!"
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'));
        $category->save();

        return redirect('/categories')->with('success', 'Berhasil menambahkan kategori');
    }

    public function edit($id)
    {
        $this->checkAuthorization();

        $category = Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization();

        $validated = $request->validate([
            "name" => "required|unique:categories,name," . $id,
        ], [
            "name.required" => "Nama Kategori harus di isi",
            "name.unique" => "Nama Kategori sudah ada!!"
        ]);

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'));
        $category->save();

        return redirect('/categories')->with('success', 'Berhasil mengedit kategori');
    }

    public function delete($id)
    {
        $this->checkAuthorization();

        Category::where('id', $id)->delete();
        return redirect('/categories')->with('success', 'Berhasil menghapus kategori');
    }
}
