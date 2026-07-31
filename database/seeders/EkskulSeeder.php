<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EkskulSeeder extends Seeder
{
    public function run()
    {
        // Matikan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Kosongkan tabel
        DB::table('ekstrakurikulers')->truncate();
        
        // Nyalakan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $ekskuls = [
            [
                'nama_ekskul' => 'Paskibra SMA 1',
                'deskripsi' => 'Ekstrakurikuler Pasukan Pengibar Bendera yang bertugas mengibarkan dan menurunkan bendera merah putih pada upacara-upacara resmi.',
                'pembina' => 'Bpk. Andi Susanto',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '09:00:00',
                'tempat_latihan' => 'Lapangan Upacara',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Pramuka',
                'deskripsi' => 'Kegiatan kepramukaan untuk membentuk karakter, kedisiplinan, dan jiwa kepemimpinan siswa.',
                'pembina' => 'Ibu. Siti Rahayu',
                'hari_latihan' => 'Jumat',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'tempat_latihan' => 'Lapangan Belakang',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler olahraga basket untuk mengembangkan bakat dan minat siswa di bidang olahraga basket.',
                'pembina' => 'Bpk. Budi Santoso',
                'hari_latihan' => 'Senin',
                'jam_mulai' => '15:00:00',
                'jam_selesai' => '17:00:00',
                'tempat_latihan' => 'GOR Basket',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Futsal',
                'deskripsi' => 'Ekstrakurikuler futsal untuk melatih keterampilan dan kerjasama tim dalam permainan futsal.',
                'pembina' => 'Bpk. Rudi Hartono',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:30:00',
                'tempat_latihan' => 'Lapangan Futsal',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Paduan Suara',
                'deskripsi' => 'Ekstrakurikuler seni musik vokal untuk mengembangkan bakat menyanyi dan paduan suara siswa.',
                'pembina' => 'Ibu. Maria Simanjuntak',
                'hari_latihan' => 'Rabu',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'tempat_latihan' => 'Ruang Musik',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'PMR',
                'deskripsi' => 'Palang Merah Remaja yang bergerak di bidang kesehatan, pertolongan pertama, dan kegiatan sosial.',
                'pembina' => 'Bpk. Dr. Agus Setiawan',
                'hari_latihan' => 'Kamis',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'tempat_latihan' => 'Ruang PMR',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'English Club',
                'deskripsi' => 'Klub bahasa Inggris untuk meningkatkan kemampuan berbahasa Inggris siswa melalui berbagai kegiatan menarik.',
                'pembina' => 'Ibu. Sarah Fitriani',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'tempat_latihan' => 'Ruang Bahasa',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Pencak Silat',
                'deskripsi' => 'Ekstrakurikuler bela diri tradisional Indonesia untuk membentuk fisik, mental, dan karakter siswa.',
                'pembina' => 'Bpk. Eko Prasetyo',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '11:00:00',
                'tempat_latihan' => 'Ruang Serbaguna',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Robotik',
                'deskripsi' => 'Ekstrakurikuler robotik untuk mengembangkan kreativitas dan kemampuan teknologi siswa di bidang robotika.',
                'pembina' => 'Bpk. Andi Wijaya',
                'hari_latihan' => 'Jumat',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'tempat_latihan' => 'Lab Komputer',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Tari Tradisional',
                'deskripsi' => 'Ekstrakurikuler seni tari tradisional untuk melestarikan budaya dan mengembangkan bakat tari siswa.',
                'pembina' => 'Ibu. Dewi Lestari',
                'hari_latihan' => 'Kamis',
                'jam_mulai' => '15:00:00',
                'jam_selesai' => '17:00:00',
                'tempat_latihan' => 'Ruang Tari',
                'status' => 'aktif'
            ]
        ];

        foreach ($ekskuls as $data) {
            $slug = Str::slug($data['nama_ekskul']);
            
            // Cek apakah sudah ada
            if (!Ekstrakurikuler::where('slug', $slug)->exists()) {
                Ekstrakurikuler::create([
                    'nama_ekskul' => $data['nama_ekskul'],
                    'slug' => $slug,
                    'deskripsi' => $data['deskripsi'],
                    'pembina' => $data['pembina'],
                    'hari_latihan' => $data['hari_latihan'],
                    'jam_mulai' => $data['jam_mulai'],
                    'jam_selesai' => $data['jam_selesai'],
                    'tempat_latihan' => $data['tempat_latihan'],
                    'status' => $data['status']
                ]);
            }
        }
    }
}