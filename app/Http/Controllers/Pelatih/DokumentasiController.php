<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Ekstrakurikuler as Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            return view('pelatih.dokumentasi.index', compact('dokumentasi'))
                   ->with('error', 'Anda belum memiliki ekskul!');
        }

        $dokumentasi = Dokumentasi::where('ekskul_id', $ekskul->id)
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(12);

        return view('pelatih.dokumentasi.index', compact('dokumentasi'));
    }

    public function createPelatih()
    {
        $user = Auth::user();
        $allEkskuls = Ekskul::all();
        
        if (!$user->ekskul) {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }

        return view('pelatih.dokumentasi.create', compact('allEkskuls'));
    }

    public function storePelatih(Request $request)
    {
        // ===== DEBUG: Log semua data yang masuk =====
        Log::info('=== STORE DOKUMENTASI ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Has file fotos? ' . ($request->hasFile('fotos') ? 'YES' : 'NO'));
        
        if ($request->hasFile('fotos')) {
            $fotosCount = $request->file('fotos');
            Log::info('File count: ' . (is_array($fotosCount) ? count($fotosCount) : 1));
        }

        try {
            // ===== VALIDASI =====
            $validated = $request->validate([
                'ekskul_id' => 'required|exists:ekstrakurikulers,id',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal_kegiatan' => 'nullable|date',
                'fotos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
            ], [
                'ekskul_id.required' => 'Ekstrakurikuler wajib dipilih!',
                'judul.required' => 'Judul dokumentasi wajib diisi!',
                'fotos.*.required' => 'Minimal 1 foto harus diupload!',
                'fotos.*.image' => 'File harus berupa gambar!',
                'fotos.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp!',
                'fotos.*.max' => 'Ukuran gambar maksimal 5MB!',
            ]);

            Log::info('✅ Validasi BERHASIL');

            // ===== CEK USER & EKSKUL =====
            $user = Auth::user();
            Log::info('User ID: ' . $user->id);
            
            // Gunakan ekskul_id dari request atau dari user
            $ekskulId = $request->ekskul_id ?? $user->ekskul_id;
            $ekskul = Ekskul::find($ekskulId);
            
            if (!$ekskul) {
                Log::error('❌ Ekskul tidak ditemukan');
                return response()->json([
                    'success' => false,
                    'message' => 'Ekstrakurikuler tidak ditemukan!'
                ], 404);
            }
            Log::info('✅ Ekskul ditemukan: ' . $ekskul->id . ' - ' . $ekskul->nama_ekskul);

            // ===== PROSES UPLOAD FOTO =====
            $fotoPaths = [];
            if ($request->hasFile('fotos')) {
                $files = $request->file('fotos');
                if (!is_array($files)) {
                    $files = [$files];
                }
                foreach ($files as $index => $foto) {
                    $namaFoto = time() . '_' . uniqid() . '_' . ($index + 1) . '.' . $foto->getClientOriginalExtension();
                    $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
                    $fotoPaths[] = $path;
                    Log::info('✅ Foto ' . ($index + 1) . ' diupload: ' . $path);
                }
            }

            if (empty($fotoPaths)) {
                Log::error('❌ Tidak ada foto yang diupload');
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal 1 foto harus diupload. Silakan coba lagi.'
                ], 422);
            }

            // ===== SIMPAN DATA =====
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal_kegiatan' => $request->tanggal_kegiatan ?? now()->format('Y-m-d'),
                'ekskul_id' => $ekskul->id,
                'diunggah_oleh' => $user->id,
                'foto_path' => $fotoPaths[0],
                'foto_lainnya' => count($fotoPaths) > 1 ? json_encode(array_slice($fotoPaths, 1)) : null
            ];

            Log::info('Data yang akan disimpan:', $data);

            $dokumentasi = Dokumentasi::create($data);
            Log::info('✅ Dokumentasi BERHASIL disimpan! ID: ' . $dokumentasi->id);

            // ===== KEMBALIKAN RESPONSE JSON =====
            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil disimpan!',
                'redirect' => route('pelatih.dokumentasi'),
                'data' => $dokumentasi
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // ===== VALIDASI GAGAL =====
            Log::error('❌ Validasi GAGAL:', $e->errors());
            
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // ===== ERROR LAINNYA =====
            Log::error('❌ ERROR: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])->findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->ekskul_id != $user->ekskul_id && $user->role != 'admin') {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki akses ke dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi.show', compact('dokumentasi'));
    }

    public function edit($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id && $user->role != 'admin') {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk mengedit dokumentasi ini!');
        }
        
        return view('pelatih.dokumentasi.edit', compact('dokumentasi'));
    }

    public function update(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id && $user->role != 'admin') {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk mengedit dokumentasi ini!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan ?? $dokumentasi->tanggal_kegiatan,
        ];

        if ($request->hasFile('fotos')) {
            // Hapus foto lama
            if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
                Storage::disk('public')->delete($dokumentasi->foto_path);
            }
            if ($dokumentasi->foto_lainnya) {
                $oldFotos = json_decode($dokumentasi->foto_lainnya, true);
                foreach ($oldFotos as $oldFoto) {
                    if (Storage::disk('public')->exists($oldFoto)) {
                        Storage::disk('public')->delete($oldFoto);
                    }
                }
            }

            $fotoPaths = [];
            $files = $request->file('fotos');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $index => $foto) {
                $namaFoto = time() . '_' . uniqid() . '_' . ($index + 1) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
                $fotoPaths[] = $path;
            }
            
            $data['foto_path'] = $fotoPaths[0] ?? null;
            $data['foto_lainnya'] = count($fotoPaths) > 1 ? json_encode(array_slice($fotoPaths, 1)) : null;
        }

        $dokumentasi->update($data);

        if ($user->role == 'admin') {
            return redirect()->route('admin.dokumentasi.show', $id)
                             ->with('success', '✅ Dokumentasi berhasil diperbarui!');
        }

        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', '✅ Dokumentasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        $user = Auth::user();
        if ($dokumentasi->diunggah_oleh != $user->id && $user->role != 'admin') {
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda tidak memiliki izin untuk menghapus dokumentasi ini!');
        }
        
        // Hapus semua foto
        if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
            Storage::disk('public')->delete($dokumentasi->foto_path);
        }
        if ($dokumentasi->foto_lainnya) {
            $oldFotos = json_decode($dokumentasi->foto_lainnya, true);
            foreach ($oldFotos as $oldFoto) {
                if (Storage::disk('public')->exists($oldFoto)) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }
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
    
    public function adminIndex(Request $request)
    {
        $query = Dokumentasi::with(['ekskul', 'user']);
        
        if ($request->has('eskul') && $request->eskul != '') {
            $query->where('ekskul_id', $request->eskul);
        }
        
        $dokumentasis = $query->orderBy('created_at', 'desc')->paginate(12);
        
        $allEskuls = Ekskul::orderBy('nama_ekskul')->get();
        
        $selectedEskul = null;
        if ($request->has('eskul') && $request->eskul != '') {
            $selectedEskul = Ekskul::find($request->eskul);
        }
        
        return view('admin.dokumentasi.global', compact('dokumentasis', 'allEskuls', 'selectedEskul'));
    }

    public function indexByEskul($idEkskul)
    {
        $eskul = Ekskul::findOrFail($idEkskul);
        $dokumentasis = Dokumentasi::where('ekskul_id', $idEkskul)
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(12);
        
        return view('admin.dokumentasi.eskul.index', compact('eskul', 'dokumentasis'));
    }

    public function adminCreate($idEkskul)
    {
        $eskul = Ekskul::findOrFail($idEkskul);
        return view('admin.dokumentasi.create', compact('eskul'));
    }

    public function adminStore(Request $request, $idEkskul)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'fotos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $fotoPaths = [];
        if ($request->hasFile('fotos')) {
            $files = $request->file('fotos');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $index => $foto) {
                $namaFoto = time() . '_' . uniqid() . '_' . ($index + 1) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
                $fotoPaths[] = $path;
            }
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => now()->format('Y-m-d'),
            'ekskul_id' => $idEkskul,
            'diunggah_oleh' => Auth::id(),
            'foto_path' => $fotoPaths[0] ?? null,
            'foto_lainnya' => count($fotoPaths) > 1 ? json_encode(array_slice($fotoPaths, 1)) : null
        ];

        Dokumentasi::create($data);

        return redirect()->route('admin.dokumentasi.eskul', $idEkskul)
                         ->with('success', '✅ Dokumentasi berhasil ditambahkan!');
    }

    public function adminEdit($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        return view('admin.dokumentasi.edit', compact('dokumentasi'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan ?? $dokumentasi->tanggal_kegiatan,
        ];

        if ($request->hasFile('fotos')) {
            if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
                Storage::disk('public')->delete($dokumentasi->foto_path);
            }
            if ($dokumentasi->foto_lainnya) {
                $oldFotos = json_decode($dokumentasi->foto_lainnya, true);
                foreach ($oldFotos as $oldFoto) {
                    if (Storage::disk('public')->exists($oldFoto)) {
                        Storage::disk('public')->delete($oldFoto);
                    }
                }
            }

            $fotoPaths = [];
            $files = $request->file('fotos');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $index => $foto) {
                $namaFoto = time() . '_' . uniqid() . '_' . ($index + 1) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('dokumentasi', $namaFoto, 'public');
                $fotoPaths[] = $path;
            }
            
            $data['foto_path'] = $fotoPaths[0] ?? null;
            $data['foto_lainnya'] = count($fotoPaths) > 1 ? json_encode(array_slice($fotoPaths, 1)) : null;
        }

        $dokumentasi->update($data);

        return redirect()->route('admin.dokumentasi.show', $id)
                         ->with('success', '✅ Dokumentasi berhasil diperbarui!');
    }

    public function adminShow($id)
    {
        $dokumentasi = Dokumentasi::with(['ekskul', 'user'])->findOrFail($id);
        return view('admin.dokumentasi.show', compact('dokumentasi'));
    }

    public function adminDestroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        
        if ($dokumentasi->foto_path && Storage::disk('public')->exists($dokumentasi->foto_path)) {
            Storage::disk('public')->delete($dokumentasi->foto_path);
        }
        if ($dokumentasi->foto_lainnya) {
            $oldFotos = json_decode($dokumentasi->foto_lainnya, true);
            foreach ($oldFotos as $oldFoto) {
                if (Storage::disk('public')->exists($oldFoto)) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }
        }
        
        $dokumentasi->delete();
        
        return redirect()->route('admin.dokumentasi.index')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }
}