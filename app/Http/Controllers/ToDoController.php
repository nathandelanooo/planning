<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{
    // 1. Menampilkan Halaman & Data Milik User Terkait
    public function index(Request $request)
    {
        $dataToDo = ToDo::all();
        $status = $request->query('status', 'all');
        
        if ($status === 'all') {
            $todos = ToDo::where('id_pengguna', Auth::id())->get();
        } else {
            $todos = ToDo::where('id_pengguna', Auth::id())
                ->where('status', $status)
                ->get();
        }
        
        return view('todo', compact('todos', 'status'));
    }

    // 2. Memproses Simpan Data Baru
    public function store(Request $request)
    {
        $todo = new ToDo();
        
        // KUNCI UTAMA: Otomatis ikat dengan user yang sedang aktif di backend
        $todo->id_pengguna = Auth::id(); 
        
        $todo->judul_list = $request->judul_list;
        $todo->isi_list = $request->isi_list;
        $todo->tanggal_mulai = $request->tanggal_mulai;
        $todo->waktu_mulai = $request->waktu_mulai;
        $todo->tanggal_selesai = $request->tanggal_selesai;
        $todo->waktu_selesai = $request->waktu_selesai;
        $todo->status = $request->status;

        $todo->save();

        return redirect('/todo')->with('success', 'To-Do baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $todo = ToDo::findOrFail($id);
        return view('CRUD.edit_todo', 
        [
            'todo' => $todo
        ]);
    }

    public function update(Request $request, $id)
    {
        ToDo::where('id_to_do_list', $id)->update([
            'judul_list' => $request->judul_list,
            'isi_list' => $request->isi_list,
            'tanggal_mulai' => $request->tanggal_mulai,
            'waktu_mulai' => $request->waktu_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => $request->status
        ]);

        return redirect('/todo')->with('success', 'To-Do berhasil diperbarui!');
    }

    public function destroy($id)
    {
        ToDo::where('id_to_do_list', $id)->delete();
        return redirect('/todo')->with('success', 'To-Do berhasil dihapus!');
    }
}