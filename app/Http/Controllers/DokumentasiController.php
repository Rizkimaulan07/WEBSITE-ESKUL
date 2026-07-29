<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DokumentasiController extends Controller
{
    public function index()
    {
        $pelatih = Auth::user();
        $dokumentasis = Dokumentasi::where('ekskul_id', $pelatih->ekskul_id)
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(12);
        return view('pelatih.dokumentasi.index', compact('dokumentasis'));
    }

    public function create()
    {
        return view('pelatih.dokumentasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_kegiatan' => 'required|date'
        ]);

        $pelatih = Auth::user();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . str_replace(' ', '_', $request->judul) . '.' . $foto->getClientOriginalExtension();
            
            // Compress image
            $image = Image::make($foto)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 80);
            
            Storage::put('public/dokumentasi/' . $namaFoto, $image);
            
            Dokumentasi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'foto_path' => 'dokumentasi/' . $namaFoto,
                'tanggal_kegiatan' => $request->tanggal_kegiatan,
                'ekskul_id' => $pelatih->ekskul_id,
                'diunggah_oleh' => $pelatih->id
            ]);
        }

        return redirect()->route('dokumentasi.index')
                         ->with('success', '📸 Dokumentasi berhasil diupload!');
    }

    public function show(Dokumentasi $dokumentasi)
    {
        return view('pelatih.dokumentasi.show', compact('dokumentasi'));
    }

    public function edit(Dokumentasi $dokumentasi)
    {
        return view('pelatih.dokumentasi.edit', compact('dokumentasi'));
    }

    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_kegiatan' => 'required|date'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if (Storage::exists('public/' . $dokumentasi->foto_path)) {
                Storage::delete('public/' . $dokumentasi->foto_path);
            }
            
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . str_replace(' ', '_', $request->judul) . '.' . $foto->getClientOriginalExtension();
            
            $image = Image::make($foto)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 80);
            
            Storage::put('public/dokumentasi/' . $namaFoto, $image);
            $data['foto_path'] = 'dokumentasi/' . $namaFoto;
        }

        $dokumentasi->update($data);

        return redirect()->route('dokumentasi.index')
                         ->with('success', '✏️ Dokumentasi berhasil diupdate!');
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        if (Storage::exists('public/' . $dokumentasi->foto_path)) {
            Storage::delete('public/' . $dokumentasi->foto_path);
        }
        
        $dokumentasi->delete();
        return redirect()->route('dokumentasi.index')
                         ->with('success', '🗑️ Dokumentasi berhasil dihapus!');
    }

    public function publik()
    {
        $dokumentasis = Dokumentasi::with(['ekskul', 'pengunggah'])
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(12);
        return view('publik.galeri', compact('dokumentasis'));
    }
}