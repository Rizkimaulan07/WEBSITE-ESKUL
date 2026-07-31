<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumentasiController extends Controller
{
    public function index()
    {
        $pelatih = Auth::user();
        $dokumentasis = Dokumentasi::where('ekskul_id', $pelatih->ekskul_id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
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
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'judul.required' => 'Judul dokumentasi wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg'
        ]);

        $dokumentasi = new Dokumentasi();
        $dokumentasi->judul = $request->judul;
        $dokumentasi->deskripsi = $request->deskripsi;
        $dokumentasi->tanggal = $request->tanggal ?? now();
        $dokumentasi->ekskul_id = Auth::user()->ekskul_id;
        $dokumentasi->user_id = Auth::id();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumentasi', $filename, 'public');
            $dokumentasi->foto = $path;
        }

        $dokumentasi->save();

        // PERBAIKAN: Gunakan route pelatih.dokumentasi (tanpa .index)
        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        if ($dokumentasi->ekskul_id != Auth::user()->ekskul_id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus dokumentasi ini');
        }

        if ($dokumentasi->foto && Storage::disk('public')->exists($dokumentasi->foto)) {
            Storage::disk('public')->delete($dokumentasi->foto);
        }

        $dokumentasi->delete();

        // PERBAIKAN: Gunakan route pelatih.dokumentasi (tanpa .index)
        return redirect()->route('pelatih.dokumentasi')
                         ->with('success', 'Dokumentasi berhasil dihapus!');
    }
}