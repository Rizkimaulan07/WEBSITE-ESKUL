<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AllEkskulSeeder extends Seeder
{
    public function run()
    {
        $ekskuls = [
            [
                'nama_ekskul' => 'Andro IT',
                'slug' => 'andro-it',
                'deskripsi' => 'Ekstrakurikuler yang bergerak di bidang Teknologi Informasi dan pengembangan aplikasi.',
                'pembina' => 'Bu Rina',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:00',
                'tempat_latihan' => 'Lab RPL',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Paskibra',
                'slug' => 'paskibra',
                'deskripsi' => 'Pasukan Pengibar Bendera yang bertugas mengibarkan dan menurunkan bendera merah putih pada upacara-upacara resmi.',
                'pembina' => 'Bpk. Andi Susanto, S.Pd',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '07:00',
                'jam_selesai' => '09:00',
                'tempat_latihan' => 'Lapangan Upacara',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Pramuka',
                'slug' => 'pramuka',
                'deskripsi' => 'Kegiatan kepramukaan yang membentuk karakter, kedisiplinan, dan jiwa kepemimpinan.',
                'pembina' => 'Ibu. Siti Rahayu, S.Pd',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '14:00',
                'jam_selesai' => '16:00',
                'tempat_latihan' => 'Lapangan Belakang',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Basket',
                'slug' => 'basket',
                'deskripsi' => 'Olahraga bola basket untuk mengembangkan bakat dan kebugaran fisik.',
                'pembina' => 'Bpk. Budi Santoso, S.Pd',
                'hari_latihan' => 'Senin',
                'jam_mulai' => '15:00',
                'jam_selesai' => '17:00',
                'tempat_latihan' => 'GOR Basket',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Futsal',
                'slug' => 'futsal',
                'deskripsi' => 'Olahraga futsal untuk mengembangkan kemampuan dan kerjasama tim.',
                'pembina' => 'Bpk. Rudi Hartono, S.Pd',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '15:30',
                'jam_selesai' => '17:30',
                'tempat_latihan' => 'Lapangan Futsal',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Paduan Suara',
                'slug' => 'paduan-suara',
                'deskripsi' => 'Ekstrakurikuler seni musik dan vokal untuk mengembangkan bakat bernyanyi.',
                'pembina' => 'Ibu. Maria Simanjuntak, S.Sn',
                'hari_latihan' => 'Rabu',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
                'tempat_latihan' => 'Ruang Musik',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'PMR',
                'slug' => 'pmr',
                'deskripsi' => 'Palang Merah Remaja yang bergerak di bidang kesehatan dan kemanusiaan.',
                'pembina' => 'Bpk. Dr. Agus Setiawan',
                'hari_latihan' => 'Kamis',
                'jam_mulai' => '14:00',
                'jam_selesai' => '16:00',
                'tempat_latihan' => 'Ruang PMR',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'English Club',
                'slug' => 'english-club',
                'deskripsi' => 'Klub bahasa Inggris untuk meningkatkan kemampuan berbahasa Inggris.',
                'pembina' => 'Ibu. Sarah Fitriani, S.Pd',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
                'tempat_latihan' => 'Ruang Bahasa',
                'status' => 'aktif'
            ],
        ];

        foreach ($ekskuls as $data) {
            $existing = Ekstrakurikuler::where('nama_ekskul', $data['nama_ekskul'])->first();
            
            if (!$existing) {
                Ekstrakurikuler::create($data);
                $this->command->info("✅ Ekskul '{$data['nama_ekskul']}' berhasil dibuat!");
            } else {
                $this->command->info("ℹ️ Ekskul '{$data['nama_ekskul']}' sudah ada.");
            }
        }

        $this->command->info('🎉 Semua ekstrakurikuler berhasil dibuat!');
    }
}