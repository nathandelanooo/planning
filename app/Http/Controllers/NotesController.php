<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotesController extends Controller
{
    public function index(Request $request)
    {
        $notes = notes::where('id_pengguna', Auth::id())->get();
        return view('notes', compact('notes'));
    }
    public function store(Request $request)
    {
    // 1. Validasi input dulu biar aman
    $request->validate([
        'judul_notes' => 'required|string|max:100',
        'isi_notes'   => 'required|string|max:5000',
        'voice_memo'  => 'nullable|file|mimes:mp3,wav|max:5120', // Maksimal 5MB
    ]);

    // 2. Bikin objek baru pakai gaya lu
    $notes = new notes();
    
    $notes->id_pengguna = Auth::id();
    $notes->judul_notes = $request->judul_notes;
    $notes->isi_notes   = $request->isi_notes;

    // 3. Logika upload audio (jika ada file yang diunggah)
    if ($request->hasFile('voice_memo')) {
        // Laravel otomatis nge-save file ke folder storage/app/public/notes_audio
        // dan mengembalikan teks path jalurnya langsung
        $notes->voice_memo = $request->file('voice_memo')->store('notes_audio', 'public');
    }

    // 4. Save ke database
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
        
        // Hapus file audio jika ada
        if ($note->voice_memo && Storage::disk('public')->exists($note->voice_memo)) {
            Storage::disk('public')->delete($note->voice_memo);
        }
        
        $note->delete();
        return redirect('/notes')->with('success', 'Note berhasil dihapus!');
    }
}
