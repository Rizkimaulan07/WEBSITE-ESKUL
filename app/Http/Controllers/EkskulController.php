<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EkskulController extends Controller
{
    public function index()
    {
        // Gunakan withCount dengan relasi yang benar
        $ekskuls = Ekstrakurikuler::withCount(['users' => function($query) {
            $query->where('role', 'anggota');
        }])->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.ekskul.index', compact('ekskuls'));
    }

    public function create()
    {
        return view('admin.ekskul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255|unique:ekstrakurikulers',
            'deskripsi' => 'required|string',
            'pembina' => 'required|string|max:255',
            'hari_latihan' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'tempat_latihan' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_ekskul);
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $namaLogo = time() . '_' . Str::slug($request->nama_ekskul) . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logo-ekskul', $namaLogo);
            $data['logo'] = 'logo-ekskul/' . $namaLogo;
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('ekskul.index')
                         ->with('success', '🎉 Ekskul berhasil ditambahkan!');
    }

    public function edit(Ekstrakurikuler $ekskul)
    {
        return view('admin.ekskul.edit', compact('ekskul'));
    }

    public function update(Request $request, Ekstrakurikuler $ekskul)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255|unique:ekstrakurikulers,nama_ekskul,' . $ekskul->id,
            'deskripsi' => 'required|string',
            'pembina' => 'required|string|max:255',
            'hari_latihan' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'tempat_latihan' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_ekskul);

        if ($request->hasFile('logo')) {
            if ($ekskul->logo && Storage::exists('public/' . $ekskul->logo)) {
                Storage::delete('public/' . $ekskul->logo);
            }
            
            $logo = $request->file('logo');
            $namaLogo = time() . '_' . Str::slug($request->nama_ekskul) . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logo-ekskul', $namaLogo);
            $data['logo'] = 'logo-ekskul/' . $namaLogo;
        }

        $ekskul->update($data);

        return redirect()->route('ekskul.index')
                         ->with('success', '✅ Ekskul berhasil diupdate!');
    }

    public function destroy(Ekstrakurikuler $ekskul)
    {
        if ($ekskul->logo && Storage::exists('public/' . $ekskul->logo)) {
            Storage::delete('public/' . $ekskul->logo);
        }
        
        $ekskul->delete();
        return redirect()->route('ekskul.index')
                         ->with('success', '🗑️ Ekskul berhasil dihapus!');
    }

    public function show(Ekstrakurikuler $ekskul)
    {
        $ekskul->load(['users' => function($query) {
            $query->where('role', 'anggota');
        }]);
        return view('admin.ekskul.show', compact('ekskul'));
    }
}