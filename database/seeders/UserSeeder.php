<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel users terlebih dahulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'kelas' => null,
            'no_hp' => '081234567890'
        ]);

        // Pelatih
        User::create([
            'name' => 'Pelatih Utama',
            'email' => 'pelatih@mail.com',
            'password' => Hash::make('password'),
            'role' => 'pelatih',
            'kelas' => null,
            'no_hp' => '081234567891'
        ]);

        // Anggota
        User::create([
            'name' => 'Anggota Utama',
            'email' => 'anggota@mail.com',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'kelas' => 'XI-A',
            'no_hp' => '081234567892'
        ]);

        $this->command->info('✅ User berhasil dibuat!');
        $this->command->info('Admin: admin@mail.com / password');
        $this->command->info('Pelatih: pelatih@mail.com / password');
        $this->command->info('Anggota: anggota@mail.com / password');
    }
}