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
        
        if (!$user->ekskul) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda belum memiliki ekskul!');
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
            'tanggal_kegiatan' => now()->format('Y-m-d'),
            'ekskul_id' => $ekskul->id,
            'diunggah_oleh' => $user->id
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . preg_replace('/\s+/', '_', trim($request->judul)) . '.' . $foto->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('dokumentasi', $foto, $namaFoto);
            $data['foto_path'] = Dokumentasi::normalizeFotoPath('dokumentasi/' . $namaFoto);
        }

        Dokumentasi::create($data);

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])->findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->ekskul_id != $user->ekskul_id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki akses ke dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi_show', compact('dokumentasi'));
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
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

    // ===== ADMIN METHODS =====
    
    public function adminIndex()
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(20);
        
        return view('admin.dokumentasi.index', compact('dokumentasi'));
    }

    public function adminShow($id)
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])->findOrFail($id);
        return view('admin.dokumentasi.show', compact('dokumentasi'));
    }

    public function adminDestroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        if ($dokumentasi->foto_path && Storage::exists('public/' . $dokumentasi->foto_path)) {
            Storage::delete('public/' . $dokumentasi->foto_path);
        }
        
        $dokumentasi->delete();
        
        return redirect()->route('admin.dokumentasi.index')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }
}