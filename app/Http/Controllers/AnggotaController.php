<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'anggota')->with('ekskuls')->get();
        $ekskuls = Ekstrakurikuler::all();
        return view('admin.anggota.index', compact('anggota', 'ekskuls'));
    }

    public function create()
    {
        $ekskuls = Ekstrakurikuler::all();
        return view('admin.anggota.create', compact('ekskuls'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'kelas' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'required|exists:ekstrakurikulers,id',
            'jabatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'kelas' => $request->kelas,
            'no_hp' => $request->no_hp
        ]);

        // Tambahkan ke ekskul
        $user->ekskuls()->attach($request->ekskul_id, [
            'jabatan' => $request->jabatan ?? 'anggota',
            'tahun_masuk' => date('Y')
        ]);

        return redirect()->route('anggota.index')
                         ->with('success', '👤 Anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $anggota = User::where('role', 'anggota')->with('ekskuls')->findOrFail($id);
        $ekskuls = Ekstrakurikuler::all();
        return view('admin.anggota.edit', compact('anggota', 'ekskuls'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $anggota->id,
            'kelas' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'required|exists:ekstrakurikulers,id',
            'jabatan' => 'nullable|string',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $request->except(['password', 'ekskul_id', 'jabatan']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $anggota->update($data);

        // Update ekskul
        $anggota->ekskuls()->sync([
            $request->ekskul_id => [
                'jabatan' => $request->jabatan ?? 'anggota',
                'tahun_masuk' => date('Y')
            ]
        ]);

        return redirect()->route('anggota.index')
                         ->with('success', '✏️ Anggota berhasil diupdate!');
    }

    public function destroy($id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota.index')
                         ->with('success', '🗑️ Anggota berhasil dihapus!');
    }
}