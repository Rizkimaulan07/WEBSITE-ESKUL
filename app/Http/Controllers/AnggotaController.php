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
        // Gunakan relasi many-to-many 'ekskuls' untuk anggota
        $anggotas = User::where('role', 'anggota')
                        ->with('ekskuls') // many-to-many
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'kelas' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'anggota';

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . $request->name . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatar', $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $user = User::create($data);

        // Gunakan relasi many-to-many 'ekskuls'
        if ($request->filled('ekskul_id')) {
            $user->ekskuls()->attach($request->ekskul_id);
        }

        return redirect()->route('admin.anggota.index')
                         ->with('success', '🎉 Anggota berhasil ditambahkan!');
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($anggota->id)],
            'kelas' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $request->validate(['password' => 'required|string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
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

        // Gunakan relasi many-to-many 'ekskuls'
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