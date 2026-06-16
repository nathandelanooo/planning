<?php

namespace App\Http\Controllers;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    private function getPengeluaranCategories()
    {
        return [
            'Kebutuhan Pokok',
            'Transportasi & Tagihan',
            'Hiburan & Rekreasi'
        ];
    }

    public function index()
    {
        $data_pengeluaran = Pengeluaran::where('id_pengguna', Auth::id())->get();
        $kategoris = $this->getPengeluaranCategories();
        
        return view('pengeluaran', compact('data_pengeluaran', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data_pengeluaran = new Pengeluaran();
        
        $data_pengeluaran->id_pengguna = Auth::id();
        $data_pengeluaran->tanggal = $request->tanggal;
        $data_pengeluaran->kategori_pengeluaran = $request->kategori_pengeluaran;
        $data_pengeluaran->keterangan = $request->keterangan;
        $data_pengeluaran->nominal = $request->nominal;
        $data_pengeluaran->save();

        return redirect('/pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $kategoris = $this->getPengeluaranCategories();
        return view('CRUD.edit_pengeluaran', compact('pengeluaran', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        Pengeluaran::where('id_pengeluaran', $id)->update([
            'tanggal' => $request->tanggal,
            'kategori_pengeluaran' => $request->kategori_pengeluaran,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal
        ]);

        return redirect('/pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();
        return redirect('/pengeluaran')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
