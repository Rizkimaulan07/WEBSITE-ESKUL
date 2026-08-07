<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = User::where('role', 'anggota')
                        ->with('ekskuls')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')->get();
        
        return view('admin.anggota.index', compact('anggotas', 'ekskuls'));
    }

    public function create()
    {
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')->get();
        return view('admin.anggota.create', compact('ekskuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:users,nis',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        
        // Generate email otomatis dari NIS
        $data['email'] = $request->nis . '@siswa.sch.id';
        
        // Default password = nis
        $data['password'] = Hash::make($request->nis);
        
        $data['role'] = 'anggota';

        // 🔥 TAMBAHKAN: Cari pelatih berdasarkan ekskul_id
        if ($request->filled('ekskul_id')) {
            $pelatih = User::where('role', 'pelatih')
                           ->where('ekskul_id', $request->ekskul_id)
                           ->first();
            
            if ($pelatih) {
                $data['pelatih_id'] = $pelatih->id;
            }
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . $request->name . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatar', $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $user = User::create($data);

        if ($request->filled('ekskul_id')) {
            $user->ekskuls()->attach($request->ekskul_id);
        }

        $pelatihNama = $pelatih->name ?? 'Belum ada pelatih';
        
        return redirect()->route('admin.anggota.index')
                         ->with('success', '🎉 Anggota berhasil ditambahkan! Email: ' . $data['email'] . ' | Password: ' . $request->nis . ' | Pelatih: ' . $pelatihNama);
    }

    public function edit($id)
    {
        $anggota = User::with('ekskuls')->findOrFail($id);
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')->get();
        return view('admin.anggota.edit', compact('anggota', 'ekskuls'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($anggota->id)],
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        // 🔥 TAMBAHKAN: Update pelatih_id jika ekskul berubah
        if ($request->filled('ekskul_id')) {
            $pelatih = User::where('role', 'pelatih')
                           ->where('ekskul_id', $request->ekskul_id)
                           ->first();
            
            if ($pelatih) {
                $data['pelatih_id'] = $pelatih->id;
            } else {
                $data['pelatih_id'] = null;
            }
        } else {
            $data['pelatih_id'] = null;
        }

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($anggota->avatar && Storage::exists('public/' . $anggota->avatar)) {
                Storage::delete('public/' . $anggota->avatar);
            }
            
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . $request->name . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatar', $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $anggota->update($data);

        if ($request->filled('ekskul_id')) {
            $anggota->ekskuls()->sync([$request->ekskul_id]);
        } else {
            $anggota->ekskuls()->detach();
        }

        return redirect()->route('admin.anggota.index')
                         ->with('success', '✅ Anggota berhasil diupdate!');
    }

    public function destroy($id)
    {
        $anggota = User::findOrFail($id);
        
        if ($anggota->avatar && Storage::exists('public/' . $anggota->avatar)) {
            Storage::delete('public/' . $anggota->avatar);
        }
        
        $anggota->delete();
        
        return redirect()->route('admin.anggota.index')
                         ->with('success', '🗑️ Anggota berhasil dihapus!');
    }

    public function show($id)
    {
        $anggota = User::with('ekskuls')->findOrFail($id);
        return view('admin.anggota.show', compact('anggota'));
    }
}