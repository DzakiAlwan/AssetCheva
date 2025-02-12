<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Peminjam;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error-unauthorized', 'Silahkan login terlebih dahulu');
        }


        $productCount = Product::count();
        $categoryCount = Category::count();
        $peminjamCount = Peminjam::count();

        return view('pages.dashboard.admin', compact('productCount', 'categoryCount', 'peminjamCount'));
    }
}
