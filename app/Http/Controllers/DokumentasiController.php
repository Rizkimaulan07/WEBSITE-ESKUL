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

    // DEBUG - Tampilkan semua data untuk sementara
    $dokumentasi = Dokumentasi::orderBy('created_at', 'desc')
                              ->paginate(12);

    \Log::info('=== INDEX DOKUMENTASI ===');
    \Log::info('Total data: ' . Dokumentasi::count());

    return view('pelatih.dokumentasi', compact('dokumentasi'));
}

    public function create()
    {
        $user = Auth::user();
        
        if ($user->ekskul_id) {
            return view('pelatih.dokumentasi_create');
        }

        $allEkskuls = Ekstrakurikuler::orderBy('nama_ekskul')->get();

        if ($allEkskuls->count() == 0) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Belum ada ekstrakurikuler. Silakan hubungi admin.');
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

    // DEBUG
    \Log::info('=== UPLOAD DOKUMENTASI ===');
    \Log::info('User ID: ' . $user->id);
    \Log::info('Ekskul ID: ' . $request->ekskul_id);

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . str_replace(' ', '_', $request->judul) . '.' . $file->getClientOriginalExtension();
        
        if (!is_dir(public_path('foto'))) {
            mkdir(public_path('foto'), 0777, true);
        }
        
        $file->move(public_path('foto'), $filename);
        $path = 'foto/' . $filename;
        
        \Log::info('File saved: ' . $path);
        \Log::info('File exists: ' . (file_exists(public_path($path)) ? 'YES' : 'NO'));
    }

    $data = [
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'foto_path' => $path,
        'tanggal_kegiatan' => $request->tanggal_kegiatan ?? now(),
        'ekskul_id' => $request->ekskul_id,
        'diunggah_oleh' => $user->id
    ];

    \Log::info('Data to save:', $data);

    $dokumentasi = Dokumentasi::create($data);

    \Log::info('Dokumentasi created ID: ' . $dokumentasi->id);
    \Log::info('Total dokumentasi: ' . Dokumentasi::count());

    return redirect()->route('pelatih.dokumentasi')
                     ->with('success', '✅ Dokumentasi berhasil ditambahkan!');
}
    public function show($id)
    {
        $dokumentasi = Dokumentasi::with('ekskul')->findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->ekskul_id != $user->ekskul_id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki akses ke dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi_show', compact('dokumentasi'));
    }

    public function edit($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk mengedit dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi_edit', compact('dokumentasi'));
    }

    public function update(Request $request, $id)
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
            if ($dokumentasi->foto_path && file_exists(public_path($dokumentasi->foto_path))) {
                unlink(public_path($dokumentasi->foto_path));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . str_replace(' ', '_', $request->judul) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto'), $filename);
            $data['foto_path'] = 'foto/' . $filename;
        }

        $dokumentasi->update($data);

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk menghapus dokumentasi ini!');
        }
        
        if ($dokumentasi->foto_path && file_exists(public_path($dokumentasi->foto_path))) {
            unlink(public_path($dokumentasi->foto_path));
        }
        
        $dokumentasi->delete();

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }

    /**
     * FIX: Perbaiki path gambar yang salah
     * Jalankan method ini sekali untuk memperbaiki semua data
     */
    public function fixPaths()
    {
        $dokumentasis = Dokumentasi::all();
        $updated = 0;
        $copied = 0;
        
        // Buat folder jika belum ada
        if (!file_exists(public_path('foto'))) {
            mkdir(public_path('foto'), 0777, true);
        }
        
        foreach ($dokumentasis as $dok) {
            $oldPath = $dok->foto_path;
            
            if (!$oldPath) {
                continue;
            }
            
            // Jika path sudah menggunakan 'foto/', lanjutkan
            if (strpos($oldPath, 'foto/') === 0) {
                continue;
            }
            
            // Ambil nama file
            $filename = basename($oldPath);
            $newPath = 'foto/' . $filename;
            
            // Cek apakah file ada di public/foto
            if (file_exists(public_path($newPath))) {
                // File sudah ada di public/foto
                $dok->foto_path = $newPath;
                $dok->save();
                $updated++;
                continue;
            }
            
            // Cek apakah file ada di storage (old path)
            $storagePath = str_replace('dokumentasi/', '', $oldPath);
            $storageFullPath = storage_path('app/public/dokumentasi/' . $storagePath);
            
            if (file_exists($storageFullPath)) {
                // Copy file dari storage ke public/foto
                copy($storageFullPath, public_path($newPath));
                $dok->foto_path = $newPath;
                $dok->save();
                $updated++;
                $copied++;
                continue;
            }
            
            // Cek apakah file ada di storage dengan path lengkap
            $storageFullPath2 = storage_path('app/public/' . $oldPath);
            if (file_exists($storageFullPath2)) {
                copy($storageFullPath2, public_path($newPath));
                $dok->foto_path = $newPath;
                $dok->save();
                $updated++;
                $copied++;
                continue;
            }
        }
        
        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', "✅ Berhasil memperbaiki {$updated} dokumentasi ({$copied} file disalin dari storage)");
    }
}