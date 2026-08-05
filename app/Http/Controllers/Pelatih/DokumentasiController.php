<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ekskul = $user->ekskul;

        if (!$ekskul) {
            $dokumentasi = collect([]);
            return view('pelatih.dokumentasi', compact('dokumentasi'))
                   ->with('error', 'Anda belum memiliki ekskul!');
        }

        $dokumentasi = Dokumentasi::where('ekskul_id', $ekskul->id)
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(12);

        return view('pelatih.dokumentasi', compact('dokumentasi'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Ambil SEMUA ekskul dari database (tanpa filter status)
        $allEkskuls = Ekstrakurikuler::orderBy('nama_ekskul')->get();

        // Jika tidak ada ekskul sama sekali di database
        if ($allEkskuls->count() == 0) {
            return view('pelatih.dokumentasi_create', compact('allEkskuls'))
                   ->with('error', 'Belum ada ekstrakurikuler. Silakan tambahkan melalui admin.');
        }

        return view('pelatih.dokumentasi_create', compact('allEkskuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ekskul_id' => 'required|exists:ekstrakurikulers,id'
        ]);

        $user = Auth::user();

        // Cek apakah ekskul yang dipilih ada di database
        $ekskul = Ekstrakurikuler::find($request->ekskul_id);
        
        if (!$ekskul) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Ekstrakurikuler tidak ditemukan!');
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => now()->format('Y-m-d'),
            'ekskul_id' => $request->ekskul_id,
            'diunggah_oleh' => $user->id
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . str_replace(' ', '_', $request->judul) . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/dokumentasi', $namaFoto);
            $data['foto_path'] = 'dokumentasi/' . $namaFoto;
        }

        Dokumentasi::create($data);

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        // Validasi apakah pelatih memiliki akses menghapus dokumentasi ini
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id && $user->role != 'admin') {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk menghapus dokumentasi ini!');
        }
        
        if ($dokumentasi->foto_path && Storage::exists('public/' . $dokumentasi->foto_path)) {
            Storage::delete('public/' . $dokumentasi->foto_path);
        }
        
        $dokumentasi->delete();

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }
}