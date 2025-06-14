<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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

        $productCount = Product::count();
        $categoryCount = Category::count();

        return view('pages.dashboard.admin', compact('productCount', 'categoryCount'));
    }
    public function addUser()
    {
        $users = User::query()
            ->when(request('search'), function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%')
                        ->orWhere('nip', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request('role'), function ($query) {
                $query->where('role', request('role'));
            })
            ->paginate(10);

        return view('pages.addUser.indexUser', compact('users'));
    }
    public function create()
    {
        $this->checkAuthorization();
        return view('pages.addUser.createUser');
    }

    public function store(Request $request)
    {
        $this->checkAuthorization();

        $validated = $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
            "role" => "required|in:Admin,Dosen,Mahasiswa",
            "nip" => "nullable|string|max:20|unique:users,nip",
            "phone" => "nullable|string|max:15",
            "address" => "nullable|string",
        ], [
            'name.required' => 'Nama lengkap harus diisi!',
            'name.min' => 'Minimal 3 karakter!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'role.required' => 'Role harus dipilih!',
            'role.in' => 'Role tidak valid!',
            'nip.unique' => 'NIP/NIM sudah terdaftar!',
        ]);

        // Validasi khusus NIP untuk Dosen/Mahasiswa
        if (in_array($request->role, ['Dosen', 'Mahasiswa']) && empty($request->nip)) {
            return back()->withErrors(['nip' => 'NIP/NIM wajib diisi untuk role ini'])->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'nip' => $request->nip,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return redirect('/addUser')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage())->withInput();
        }
    }
    // Menampilkan form edit
    public function edit($id)
    {
        $this->checkAuthorization();
        $user = User::findOrFail($id);
        return view('pages.addUser.editUser', compact('user'));
    }

    // Menyimpan perubahan
    public function update(Request $request, $id)
    {
        $this->checkAuthorization();

        $user = User::findOrFail($id);

        $rules = [
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email," . $user->id,
            "password" => "nullable|min:8|confirmed",
            "role" => "required|in:Admin,Dosen,Mahasiswa",
            "nip" => "nullable|string|max:20|unique:users,nip," . $user->id,
        ];

        $validated = $request->validate($rules, [
            'name.required' => 'Nama lengkap harus diisi!',
            'name.min' => 'Minimal 3 karakter!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'role.required' => 'Role harus dipilih!',
            'role.in' => 'Role tidak valid!',
            'nip.unique' => 'NIP/NIM sudah terdaftar!',
        ]);

        // Validasi khusus NIP untuk Dosen/Mahasiswa
        if (in_array($request->role, ['Dosen', 'Mahasiswa']) && empty($request->nip)) {
            return back()->withErrors(['nip' => 'NIP/NIM wajib diisi untuk role ini'])->withInput();
        }

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->nip = $validated['nip'];

            // Update password hanya jika diisi
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('users.add', $user->id)->with('success', 'Data pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy($id)
    {
        $this->checkAuthorization();

        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.add')->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('users.add')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}
