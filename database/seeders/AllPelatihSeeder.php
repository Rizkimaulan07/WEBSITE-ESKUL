<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AllPelatihSeeder extends Seeder
{
    public function run()
    {
        // Data pelatih per ekskul
        $pelatihData = [
            [
                'name' => 'Bu Rina',
                'email' => 'rina@mail.com',
                'password' => 'password',
                'no_hp' => '081234567890',
                'ekskul_nama' => 'Andro IT'
            ],
            [
                'name' => 'Bpk. Andi Susanto, S.Pd',
                'email' => 'andi@mail.com',
                'password' => 'password',
                'no_hp' => '081234567891',
                'ekskul_nama' => 'Paskibra'
            ],
            [
                'name' => 'Ibu. Siti Rahayu, S.Pd',
                'email' => 'siti@mail.com',
                'password' => 'password',
                'no_hp' => '081234567892',
                'ekskul_nama' => 'Pramuka'
            ],
            [
                'name' => 'Bpk. Budi Santoso, S.Pd',
                'email' => 'budi@mail.com',
                'password' => 'password',
                'no_hp' => '081234567893',
                'ekskul_nama' => 'Basket'
            ],
            [
                'name' => 'Bpk. Rudi Hartono, S.Pd',
                'email' => 'rudi@mail.com',
                'password' => 'password',
                'no_hp' => '081234567894',
                'ekskul_nama' => 'Futsal'
            ],
            [
                'name' => 'Ibu. Maria Simanjuntak, S.Sn',
                'email' => 'maria@mail.com',
                'password' => 'password',
                'no_hp' => '081234567895',
                'ekskul_nama' => 'Paduan Suara'
            ],
            [
                'name' => 'Bpk. Dr. Agus Setiawan',
                'email' => 'agus@mail.com',
                'password' => 'password',
                'no_hp' => '081234567896',
                'ekskul_nama' => 'PMR'
            ],
            [
                'name' => 'Ibu. Sarah Fitriani, S.Pd',
                'email' => 'sarah@mail.com',
                'password' => 'password',
                'no_hp' => '081234567897',
                'ekskul_nama' => 'English Club'
            ],
        ];

        foreach ($pelatihData as $data) {
            // Cari ekskul berdasarkan nama
            $ekskul = Ekstrakurikuler::where('nama_ekskul', $data['ekskul_nama'])->first();
            
            if (!$ekskul) {
                $this->command->warn("⚠️ Ekskul '{$data['ekskul_nama']}' tidak ditemukan, lewati...");
                continue;
            }

            // Cek apakah pelatih sudah ada
            $existing = User::where('email', $data['email'])->first();
            
            if (!$existing) {
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => 'pelatih',
                    'no_hp' => $data['no_hp'],
                    'ekskul_id' => $ekskul->id,
                    'is_verified' => true,
                    'verified_at' => now(),
                ]);
                $this->command->info("✅ Pelatih {$data['name']} berhasil dibuat!");
                $this->command->info("   📧 Email: {$data['email']} | 🔑 Password: {$data['password']}");
                $this->command->info("   🏫 Ekskul: {$data['ekskul_nama']}");
                $this->command->info("   ---");
            } else {
                // Update jika sudah ada
                $existing->ekskul_id = $ekskul->id;
                $existing->is_verified = true;
                $existing->verified_at = now();
                $existing->save();
                $this->command->info("✅ Pelatih {$data['name']} berhasil diupdate!");
            }
        }

        $this->command->info('🎉 Semua pelatih per ekskul berhasil dibuat!');
        $this->command->info('📋 Gunakan email dan password di atas untuk login.');
    }
}