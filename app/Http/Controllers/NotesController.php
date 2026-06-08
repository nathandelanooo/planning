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
}
