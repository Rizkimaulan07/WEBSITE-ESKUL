<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Ekstrakurikuler as Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    // =================================================================
    // ===== PELATIH METHODS =====
    // =================================================================
    
    public function indexPelatih()
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

    public function createPelatih()
    {
        $user = Auth::user();
        
        if (!$user->ekskul) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }

        return view('pelatih.dokumentasi_create');
    }

    public function storePelatih(Request $request)
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

            $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
            $data['foto_path'] = $path;
        }

        Dokumentasi::create($data);

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil ditambahkan!');
    }

    public function show(int $id)
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])->findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->ekskul_id != $user->ekskul_id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki akses ke dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi_show', compact('dokumentasi'));
    }

    public function edit(int $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk mengedit dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi_edit', compact('dokumentasi'));
    }

    public function update(Request $request, int $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk mengedit dokumentasi ini!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan ?? $dokumentasi->tanggal_kegiatan,
        ];

        if ($request->hasFile('foto')) {
            if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
                Storage::disk('public')->delete($dokumentasi->foto_path);
            }

            $foto = $request->file('foto');
            $namaFoto = time() . '_' . preg_replace('/\s+/', '_', trim($request->judul)) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
            $data['foto_path'] = $path;
        }

        $dokumentasi->update($data);

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id && $user->role != 'admin') {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk menghapus dokumentasi ini!');
        }
        
        if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
            Storage::disk('public')->delete($dokumentasi->foto_path);
        }
        
        $dokumentasi->delete();

        if ($user->role == 'admin') {
            return redirect()->route('admin.dokumentasi.index')
                             ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
        }

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }

    // =================================================================
    // ===== ADMIN METHODS =====
    // =================================================================
    
    // Halaman Global Admin (Method INI yang dicari route)
    public function adminIndex()
    {
        $dokumentasis = Dokumentasi::with(['ekskul', 'user'])
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(12);
        
        return view('admin.dokumentasi.global', compact('dokumentasis'));
    }

    // Halaman Dokumentasi Per Eskul
    public function indexByEskul(int $idEkskul)
    {
        $ekskul = Ekskul::findOrFail($idEkskul);
        $dokumentasis = Dokumentasi::where('ekskul_id', $idEkskul)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
        return view('admin.dokumentasi.eskul.index', compact('ekskul', 'dokumentasis'));
    }

    public function adminCreate(int $idEkskul)
    {
        $ekskul = Ekskul::findOrFail($idEkskul);
        return view('admin.dokumentasi.create', compact('ekskul'));
    }

    public function adminStore(Request $request, int $idEkskul)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => now()->format('Y-m-d'),
            'ekskul_id' => $idEkskul,
            'diunggah_oleh' => Auth::id()
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . preg_replace('/\s+/', '_', trim($request->judul)) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
            $data['foto_path'] = $path;
        }

        Dokumentasi::create($data);

        return redirect()->route('admin.dokumentasi.eskul', $idEkskul)
                         ->with('success', '✅ Dokumentasi berhasil ditambahkan oleh Admin!');
    }

    public function adminEdit(int $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        return view('admin.dokumentasi.edit', compact('dokumentasi'));
    }

    public function adminUpdate(Request $request, int $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan ?? $dokumentasi->tanggal_kegiatan,
        ];

        if ($request->hasFile('foto')) {
            if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
                Storage::disk('public')->delete($dokumentasi->foto_path);
            }
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . preg_replace('/\s+/', '_', trim($request->judul)) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
            $data['foto_path'] = $path;
        }

        $dokumentasi->update($data);

        return redirect()->route('admin.dokumentasi.show', $id)
                         ->with('success', '✅ Dokumentasi berhasil diperbarui oleh Admin!');
    }

    public function adminShow(int $id)
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])->findOrFail($id);
        return view('admin.dokumentasi.show', compact('dokumentasi'));
    }

    public function adminDestroy(int $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
            Storage::disk('public')->delete($dokumentasi->foto_path);
        }
        
        $dokumentasi->delete();
        
        return redirect()->route('admin.dokumentasi.index')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }
}