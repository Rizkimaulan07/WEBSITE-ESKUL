<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Models\Kehadiran;
use App\Models\NilaiAnggota;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        $data['email'] = $request->filled('email') ? $request->email : ($request->nis . '@siswa.sch.id');
        $data['password'] = Hash::make($request->filled('password') ? $request->password : $request->nis);
        $data['role'] = 'anggota';

        // Cari pelatih berdasarkan ekskul_id
        $pelatih = null;
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

    public function createPelatih()
    {
        $pelatih = Auth::user();

        if (!$pelatih || $pelatih->role !== 'pelatih') {
            abort(403);
        }

        $ekskuls = collect([$pelatih->ekskul])->filter();

        return view('admin.anggota.create', compact('ekskuls'))
            ->with('isPelatihCreate', true);
    }

    public function storePelatih(Request $request)
    {
        $pelatih = Auth::user();

        if (!$pelatih || $pelatih->role !== 'pelatih') {
            abort(403);
        }

        $request->merge([
            'ekskul_id' => $pelatih->ekskul_id,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:users,nis',
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'ekskul_id' => 'required|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['email'] = $request->filled('email') ? $request->email : ($request->nis . '@siswa.sch.id');
        $data['password'] = Hash::make($request->filled('password') ? $request->password : $request->nis);
        $data['role'] = 'anggota';
        $data['pelatih_id'] = $pelatih->id;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . $request->name . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatar', $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $user = User::create($data);
        $user->ekskuls()->attach($request->ekskul_id);

        return redirect()->route('pelatih.dashboard')
            ->with('success', '🎉 Anggota berhasil ditambahkan! Email: ' . $data['email'] . ' | Password: ' . $request->nis);
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

        // Update pelatih_id jika ekskul berubah
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $anggota = User::where('role', 'anggota')->findOrFail($id);
            
            // 1. Hapus semua data kehadiran terkait (sebagai anggota)
            Kehadiran::where('anggota_id', $id)->delete();
            
            // 2. Hapus semua data kehadiran terkait (sebagai pelatih)
            Kehadiran::where('pelatih_id', $id)->delete();
            
            // 3. Hapus nilai anggota
            NilaiAnggota::where('anggota_id', $id)->delete();
            
            // 4. Hapus dokumentasi yang diunggah
            $dokumentasis = Dokumentasi::where('diunggah_oleh', $id)->get();
            foreach ($dokumentasis as $dokumentasi) {
                if ($dokumentasi->foto_path) {
                    Storage::disk('public')->delete($dokumentasi->foto_path);
                }
                $dokumentasi->delete();
            }
            
            // 5. Hapus avatar
            if ($anggota->avatar && Storage::exists('public/' . $anggota->avatar)) {
                Storage::delete('public/' . $anggota->avatar);
            }
            
            // 6. Hapus relasi many-to-many dengan ekskul
            $anggota->ekskuls()->detach();
            
            // 7. Hapus user
            $anggota->delete();
            
            DB::commit();

            return redirect()->route('admin.anggota.index')
                ->with('success', '🗑️ Anggota ' . $anggota->name . ' berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.anggota.index')
                ->with('error', 'Gagal menghapus anggota: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $anggota = User::with('ekskuls')->findOrFail($id);
        return view('admin.anggota.show', compact('anggota'));
    }
}