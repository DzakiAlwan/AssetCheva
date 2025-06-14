<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserController extends Controller
{


    public function userView()
    {
        if (Auth::user()->role !== 'Mahasiswa') {
            abort(403, 'Akses ditolak. Hanya mahasiswa yang bisa mengakses halaman ini.');
        }

        $products = Product::with('category')->latest()->paginate(10);
        return view('pages.user.index', [
            "products" => $products,
        ]);
    }

    public function search(Request $request)
    {
        if (Auth::user()->role !== 'Mahasiswa') {
            abort(403, 'Akses ditolak. Hanya mahasiswa yang bisa mengakses halaman ini.');
        }

        if ($request->has('search')) {
            $products = Product::with('category')->where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);
        } else {
            $products = Product::with('category')->latest()->paginate(10);
        }

        return view('pages.user.index', compact('products'));
    }
}
