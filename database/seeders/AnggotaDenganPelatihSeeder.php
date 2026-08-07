<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnggotaDenganPelatihSeeder extends Seeder
{
    public function run()
    {
        // Data anggota dengan pelatih_id
        $anggotaData = [
            [
                'name' => 'Rizki Maulana',
                'email' => 'rizki@mail.com',
                'password' => 'password',
                'role' => 'anggota',
                'kelas' => 'X-B',
                'no_hp' => '081234567895',
                'ekskul_id' => 1, // Andro IT
                'pelatih_id' => 2, // Bu Rina
            ],
            [
                'name' => 'Anggota Utama',
                'email' => 'anggota@mail.com',
                'password' => 'password',
                'role' => 'anggota',
                'kelas' => 'XI-A',
                'no_hp' => '081234567896',
                'ekskul_id' => 1, // Andro IT
                'pelatih_id' => 2, // Bu Rina
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi_anggota@mail.com',
                'password' => 'password',
                'role' => 'anggota',
                'kelas' => 'XII-A',
                'no_hp' => '081234567897',
                'ekskul_id' => 2, // Paskibra
                'pelatih_id' => 3, // Bpk. Andi
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti_anggota@mail.com',
                'password' => 'password',
                'role' => 'anggota',
                'kelas' => 'XI-B',
                'no_hp' => '081234567898',
                'ekskul_id' => 3, // Pramuka
                'pelatih_id' => 4, // Ibu. Siti
            ],
        ];

        foreach ($anggotaData as $data) {
            $existing = User::where('email', $data['email'])->first();
            
            if (!$existing) {
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                    'kelas' => $data['kelas'],
                    'no_hp' => $data['no_hp'],
                    'ekskul_id' => $data['ekskul_id'],
                    'pelatih_id' => $data['pelatih_id'],
                ]);
                $this->command->info("✅ Anggota {$data['name']} berhasil dibuat!");
            } else {
                $existing->pelatih_id = $data['pelatih_id'];
                $existing->ekskul_id = $data['ekskul_id'];
                $existing->save();
                $this->command->info("✅ Anggota {$data['name']} berhasil diupdate!");
            }
        }

        $this->command->info('🎉 Semua anggota dengan pelatih berhasil dibuat!');
    }
}