<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat 1 ekskul
        $ekskul = Ekstrakurikuler::create([
            'nama_ekskul' => 'Paskibra SMA 1',
            'deskripsi' => 'Ekstrakurikuler Paskibra untuk melatih kedisiplinan dan kepemimpinan',
            'pembina' => 'Bpk. Andi',
            'hari_latihan' => 'Sabtu',
            'jam_mulai' => '07:00',
            'jam_selesai' => '09:00',
            'tempat_latihan' => 'Lapangan Upacara',
            'slug' => 'paskibra-sma-1'
        ]);

        // Admin
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '08123456789'
        ]);

        // Pelatih
        $pelatih = User::create([
            'name' => 'Pelatih Paskibra',
            'email' => 'pelatih@mail.com',
            'password' => Hash::make('password'),
            'role' => 'pelatih',
            'ekskul_id' => $ekskul->id,
            'no_hp' => '08123456780'
        ]);

        // Anggota (5 orang)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Anggota ' . $i,
                'email' => 'anggota' . $i . '@mail.com',
                'password' => Hash::make('password'),
                'role' => 'anggota',
                'kelas' => 'XI - ' . chr(64 + $i),
                'no_hp' => '081234567' . (70 + $i)
            ]);

            // Tambahkan ke pivot table
            $user->ekskuls()->attach($ekskul->id, [
                'jabatan' => 'anggota',
                'tahun_masuk' => 2024
            ]);
        }
    }
}