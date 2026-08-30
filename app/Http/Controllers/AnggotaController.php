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
use Illuminate\Support\Facades\Storage; // ✅ TAMBAHAN PENTING INI
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
            'ekskul_ids' => 'nullable|array',
            'ekskul_ids.*' => 'exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        unset($data['ekskul_ids']);

        $data['email'] = $request->filled('email') ? $request->email : ($request->nis . '@siswa.sch.id');
        $data['password'] = Hash::make($request->filled('password') ? $request->password : $request->nis);
        $data['role'] = 'anggota';

        // Kumpulkan id ekskul (multi: ekskul_ids[], legacy: ekskul_id)
        $ekskulIds = array_values(array_filter((array) $request->input('ekskul_ids', []), fn($id) => $id !== null && $id !== ''));
        if ($request->filled('ekskul_id') && !in_array($request->ekskul_id, $ekskulIds)) {
            $ekskulIds[] = $request->ekskul_id;
        }
        $data['ekskul_id'] = $ekskulIds[0] ?? null;

        // Cari pelatih berdasarkan ekskul utama (pertama)
        $pelatih = null;
        if (!empty($ekskulIds)) {
            $pelatih = User::where('role', 'pelatih')
                           ->where('ekskul_id', $ekskulIds[0])
                           ->first();

            if ($pelatih) {
                $data['pelatih_id'] = $pelatih->id;
            }
        }

        // ===== SIMPAN FOTO LANGSUNG KE PUBLIC =====
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatar'), $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $user = User::create($data);

        if (!empty($ekskulIds)) {
            $user->ekskuls()->attach(array_unique($ekskulIds));
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

        // ===== SIMPAN FOTO LANGSUNG KE PUBLIC =====
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatar'), $namaAvatar);
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
            'ekskul_ids' => 'nullable|array',
            'ekskul_ids.*' => 'exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        unset($data['ekskul_ids']);

        // Kumpulkan id ekskul (multi: ekskul_ids[], legacy: ekskul_id)
        $ekskulIds = array_values(array_filter((array) $request->input('ekskul_ids', []), fn($id) => $id !== null && $id !== ''));
        if ($request->filled('ekskul_id') && !in_array($request->ekskul_id, $ekskulIds)) {
            $ekskulIds[] = $request->ekskul_id;
        }
        $data['ekskul_id'] = $ekskulIds[0] ?? null;

        // Update pelatih_id jika ekskul berubah (berdasarkan ekskul utama)
        if (!empty($ekskulIds)) {
            $pelatih = User::where('role', 'pelatih')
                           ->where('ekskul_id', $ekskulIds[0])
                           ->first();

            $data['pelatih_id'] = $pelatih->id ?? null;
        } else {
            $data['pelatih_id'] = null;
        }

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // ===== UPDATE FOTO LANGSUNG KE PUBLIC =====
        if ($request->hasFile('avatar')) {
            if ($anggota->avatar && file_exists(public_path($anggota->avatar))) {
                unlink(public_path($anggota->avatar));
            }
            
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatar'), $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $anggota->update($data);

        $anggota->ekskuls()->sync($ekskulIds);

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
            
            Kehadiran::where('anggota_id', $id)->delete();
            Kehadiran::where('pelatih_id', $id)->delete();
            NilaiAnggota::where('anggota_id', $id)->delete();
            
            $dokumentasis = Dokumentasi::where('diunggah_oleh', $id)->get();
            foreach ($dokumentasis as $dokumentasi) {
                if ($dokumentasi->foto_path) {
                    Storage::disk('public')->delete($dokumentasi->foto_path);
                }
                $dokumentasi->delete();
            }
            
            // Hapus avatar
            if ($anggota->avatar && file_exists(public_path($anggota->avatar))) {
                unlink(public_path($anggota->avatar));
            }
            
            $anggota->ekskuls()->detach();
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