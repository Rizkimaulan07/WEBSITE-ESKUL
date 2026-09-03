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
        $ekskuls = Ekstrakurikuler::withCount(['users' => function($query) {
            $query->where('role', 'anggota');
        }])->orderBy('created_at', 'desc')->paginate(10);

        $allEkskuls = Ekstrakurikuler::orderBy('nama_ekskul')->get();

        $totalAnggota = \App\Models\User::where('role', 'anggota')->count();

        return view('admin.ekskul.index', compact('ekskuls', 'allEkskuls', 'totalAnggota'));
    }

    public function create()
    {
        return view('admin.ekskul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255|unique:ekstrakurikulers,nama_ekskul',
            'deskripsi' => 'required|string',
            'pembina' => 'required|string|max:255',
            'hari_latihan' => 'required|array|min:1',
            'hari_latihan.*' => 'string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'tempat_latihan' => 'required|string|max:255',
            'status' => 'nullable|in:aktif,nonaktif',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_ekskul);
        $data['hari_latihan'] = implode(', ', (array) $request->input('hari_latihan'));
        
        if (!isset($data['status'])) {
            $data['status'] = 'aktif';
        }
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $namaLogo = time() . '_' . Str::slug($request->nama_ekskul) . '.' . $logo->getClientOriginalExtension();
            
            // ✅ Simpan langsung ke public/logo (paling mudah diakses)
            $logo->move(public_path('logo'), $namaLogo);
            $data['logo'] = 'logo/' . $namaLogo;
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('admin.ekskul.index')
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
            'hari_latihan' => 'required|array|min:1',
            'hari_latihan.*' => 'string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'tempat_latihan' => 'required|string|max:255',
            'status' => 'nullable|in:aktif,nonaktif',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_ekskul);
        $data['hari_latihan'] = implode(', ', (array) $request->input('hari_latihan'));

        if ($request->hasFile('logo')) {
            if ($ekskul->logo && file_exists(public_path($ekskul->logo))) {
                unlink(public_path($ekskul->logo));
            }
            
            $logo = $request->file('logo');
            $namaLogo = time() . '_' . Str::slug($request->nama_ekskul) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('logo'), $namaLogo);
            $data['logo'] = 'logo/' . $namaLogo;
        }

        $ekskul->update($data);

        return redirect()->route('admin.ekskul.index')
                         ->with('success', '✅ Ekskul berhasil diupdate!');
    }

    public function destroy(Ekstrakurikuler $ekskul)
    {
        if ($ekskul->logo && file_exists(public_path($ekskul->logo))) {
            unlink(public_path($ekskul->logo));
        }
        
        $ekskul->delete();
        
        return redirect()->route('admin.ekskul.index')
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