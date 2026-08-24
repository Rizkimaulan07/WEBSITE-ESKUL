<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelatihController extends Controller
{
    public function index()
    {
        $pelatihs = User::where('role', 'pelatih')
                        ->with('ekskul')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')->get();
        
        return view('admin.pelatih.index', compact('pelatihs', 'ekskuls'));
    }

    public function create()
    {
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')->get();
        return view('admin.pelatih.create', compact('ekskuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'no_hp' => 'nullable|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'pelatih';
        $data['email_verified_at'] = now();

        // ===== SIMPAN FOTO PELATIH =====
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatar'), $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        User::create($data);

        return redirect()->route('admin.pelatih.index')
                         ->with('success', '🎉 Pelatih berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelatih = User::where('role', 'pelatih')->findOrFail($id);
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')->get();
        return view('admin.pelatih.edit', compact('pelatih', 'ekskuls'));
    }

    public function update(Request $request, $id)
    {
        $pelatih = User::where('role', 'pelatih')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pelatih->id)],
            'password' => 'nullable|string|min:6',
            'no_hp' => 'nullable|string|max:15',
            'ekskul_id' => 'nullable|exists:ekstrakurikulers,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // ===== UPDATE FOTO PELATIH =====
        if ($request->hasFile('avatar')) {
            if ($pelatih->avatar && file_exists(public_path($pelatih->avatar))) {
                unlink(public_path($pelatih->avatar));
            }
            
            $avatar = $request->file('avatar');
            $namaAvatar = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatar'), $namaAvatar);
            $data['avatar'] = 'avatar/' . $namaAvatar;
        }

        $pelatih->update($data);

        return redirect()->route('admin.pelatih.index')
                         ->with('success', '✅ Pelatih berhasil diperbarui!');
    }

    public function show($id)
    {
        $pelatih = User::where('role', 'pelatih')->with('ekskul')->findOrFail($id);
        return view('admin.pelatih.show', compact('pelatih'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pelatih = User::where('role', 'pelatih')->findOrFail($id);
            
            // Hapus foto jika ada
            if ($pelatih->avatar && file_exists(public_path($pelatih->avatar))) {
                unlink(public_path($pelatih->avatar));
            }
            
            $pelatih->delete();

            DB::commit();
            return redirect()->route('admin.pelatih.index')
                             ->with('success', '🗑️ Pelatih berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pelatih.index')
                             ->with('error', 'Gagal menghapus pelatih: ' . $e->getMessage());
        }
    }
}