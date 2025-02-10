<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);

        return view(
            'pages.categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
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


        return redirect('/categories')->with('success', 'Behasil menambahkan kategori');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "required|unique:categories,name",
        ], [
            "name.required" => "Nama Kategori harus di isi",
            "name.unique" => "Nama Kategori sudah ada!!"
        ]);

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'));
        $category->save();


        return redirect('/categories')->with('success', 'Behasil mengedit kategori');
    }


    public function delete($id)
    {
        Category::where('id', $id)->delete();

        return redirect('/categories')->with('success', 'Behasil menghapus kategori');
    }
}
