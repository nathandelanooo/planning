<?php

namespace App\Http\Controllers;

use App\Models\HabitTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    private function getHabitCategories()
    {
        return [
            'Kesehatan & Kebugaran',
            'Edukasi & Produktivitas',
            'Mental & Spiritual'
        ];
    }

    public function index()
    {
        $data_habit = HabitTracker::where('id_pengguna', Auth::id())->get();
        $kategoris = $this->getHabitCategories();
        
        return view('habit', compact('data_habit', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data_habit = new HabitTracker();
        
        $data_habit->id_pengguna = Auth::id();
        $data_habit->nama_habit = $request->nama_habit;
        $data_habit->kategori_habit = $request->kategori_habit;
        $data_habit->status = $request->status ?? 'active';
        $data_habit->save();

        return redirect('/habit')->with('success', 'Habit berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $habit = HabitTracker::findOrFail($id);
        $kategoris = $this->getHabitCategories();
        return view('CRUD.edit_habit', compact('habit', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        HabitTracker::where('id_habit_tracker', $id)->update([
            'nama_habit' => $request->nama_habit,
            'kategori_habit' => $request->kategori_habit,
            'status' => $request->status
        ]);

        return redirect('/habit')->with('success', 'Habit berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $habit = HabitTracker::findOrFail($id);
        $habit->delete();
        return redirect('/habit')->with('success', 'Habit berhasil dihapus!');
    }
}
