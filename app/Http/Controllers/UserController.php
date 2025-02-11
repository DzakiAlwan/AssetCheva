<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class UserController extends Controller
{
    public function userView()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('pages.user.index', [
            "products" => $products,
        ]);
    }
    public function search(Request $request) {
        if ($request->has('search')) {
            $product = Product::where('name', 'LIKE', '%' . $request->search . '%')->get();
        } else {
            $product = Product::all();
        }

        return view('pages.user.index',  compact('products'));
    }


}
