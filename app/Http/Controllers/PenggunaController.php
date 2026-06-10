<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword; 
        $data_pengguna = Pengguna::when($search, function ($query, $search) {
            return $query->where('username', 'like', "%{$search}%");
        })->join('roles', 'pengguna.id_role', '=', 'roles.id_role')
        ->select('pengguna.*', 'roles.nama_role')
        ->get();

        return view('dashboard', compact('data_pengguna'));

    }
    public function edit($id)
    {
        // Cegah admin mengedit user sendiri
        if (Auth::id() == $id) {
            return redirect('/dashboard')->with('error', 'Anda tidak bisa mengedit akun sendiri.');
        }

        $data_pengguna = Pengguna::findOrFail($id);
        return view('pengguna',[
            'pengguna' => $data_pengguna
        ]);
    }
    public function update(Request $request, $id)
    {
        // Cegah admin mengedit user sendiri
        if (Auth::id() == $id) {
            return redirect('/dashboard')->with('error', 'Anda tidak bisa mengedit akun sendiri.');
        }

        $data = [
            'username' => $request->username,
            'id_role' => $request->id_role
        ];

        // Hanya update password jika ada input password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        Pengguna::where('id_pengguna', $id)->update($data);

        return redirect('/dashboard')->with('success', 'Data pengguna berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Cegah admin menghapus user sendiri
        if (Auth::id() == $id) {
            return redirect('/dashboard')->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        Pengguna::findOrFail($id)->delete();
        return redirect('/dashboard')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
