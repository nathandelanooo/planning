<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notes;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function index(Request $request)
    {
        $notes = notes::all();
        return view('notes', compact('notes'));
    }
    public function store(Request $request)
    {
        $notes = new notes();
        
        $notes->id_pengguna = Auth::id();
        $notes->judul_notes = $request->judul_notes;
        $notes->isi_notes = $request->isi_notes;
        $notes->save();

        return redirect('/notes')->with('success', 'Note berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $note = notes::findOrFail($id);
        return view('CRUD.edit_notes', compact('note'));
    }

    public function update(Request $request, $id)
    {
        notes::where('id_notes', $id)->update([
            'judul_notes' => $request->judul_notes,
            'isi_notes' => $request->isi_notes
        ]);

        return redirect('/notes')->with('success', 'Note berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $note = notes::findOrFail($id);
        $note->delete();
        return redirect('/notes')->with('success', 'Note berhasil dihapus!');
    }
}
