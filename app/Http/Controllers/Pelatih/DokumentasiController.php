<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ekskul = $user->ekskul;

        // Jika tidak ada ekskul, tampilkan halaman kosong
        if (!$ekskul) {
            $dokumentasi = collect([]);
            return view('pelatih.dokumentasi', compact('dokumentasi'))
                   ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }

        // Gunakan paginate() bukan get()
        $dokumentasi = Dokumentasi::where('ekskul_id', $ekskul->id)
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(12);

        return view('pelatih.dokumentasi', compact('dokumentasi'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if (!$user->ekskul) {
            return redirect()->route('pelatih.dashboard')
                             ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }

        return view('pelatih.dokumentasi_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $user = Auth::user();
        $ekskul = $user->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => now(),
            'ekskul_id' => $ekskul->id,
            'user_id' => $user->id
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . str_replace(' ', '_', $request->judul) . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/dokumentasi', $namaFoto);
            $data['foto'] = 'dokumentasi/' . $namaFoto;
        }

        Dokumentasi::create($data);

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        if ($dokumentasi->foto && Storage::exists('public/' . $dokumentasi->foto)) {
            Storage::delete('public/' . $dokumentasi->foto);
        }
        
        $dokumentasi->delete();

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }
}