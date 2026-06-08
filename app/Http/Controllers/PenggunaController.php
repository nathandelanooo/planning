<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;

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
        $data_pengguna = Pengguna::findOrFail($id);
        return view('pengguna',[
            'pengguna' => $data_pengguna
        ]);
    }
    public function update(Request $request, $id)
    {
        Pengguna::where('id_pengguna', $id)->update([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'id_role' => $request->id_role
        ]);

        return redirect('/dashboard')->with('success', 'Data pengguna berhasil diperbarui.');
    }
    public function destroy($id)
    {
        Pengguna::findOrFail($id)->delete();
        return redirect('/dashboard')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
