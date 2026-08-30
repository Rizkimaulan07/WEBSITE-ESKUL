<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Matikan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Kosongkan tabel
        DB::table('users')->truncate();
        DB::table('ekstrakurikulers')->truncate();
        DB::table('template_surats')->truncate();
        DB::table('anggota_ekskul')->truncate();
        
        // Nyalakan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ===== BUAT ADMIN =====
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@eskul.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'kelas' => null,
            'no_hp' => '081234567890'
        ]);

        // ===== BUAT EKSKUL =====
        $ekskuls = [
            [
                'nama_ekskul' => 'Paskibra',
                'deskripsi' => 'Pasukan Pengibar Bendera yang bertugas mengibarkan dan menurunkan bendera merah putih pada upacara-upacara resmi.',
                'pembina' => 'Bpk. Andi Susanto, S.Pd',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '09:00:00',
                'tempat_latihan' => 'Lapangan Upacara',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Pramuka',
                'deskripsi' => 'Kegiatan kepramukaan untuk membentuk karakter, kedisiplinan, dan jiwa kepemimpinan siswa.',
                'pembina' => 'Ibu. Siti Rahayu, S.Pd',
                'hari_latihan' => 'Jumat',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '16:00:00',
                'tempat_latihan' => 'Lapangan Belakang',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler olahraga basket untuk mengembangkan bakat dan minat siswa di bidang olahraga basket.',
                'pembina' => 'Bpk. Budi Santoso, S.Pd',
                'hari_latihan' => 'Senin',
                'jam_mulai' => '15:00:00',
                'jam_selesai' => '17:00:00',
                'tempat_latihan' => 'GOR Basket',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Futsal',
                'deskripsi' => 'Ekstrakurikuler futsal untuk melatih keterampilan dan kerjasama tim dalam permainan futsal.',
                'pembina' => 'Bpk. Rudi Hartono, S.Pd',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:30:00',
                'tempat_latihan' => 'Lapangan Futsal',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Paduan Suara',
                'deskripsi' => 'Ekstrakurikuler seni musik vokal untuk mengembangkan bakat menyanyi dan paduan suara siswa.',
                'pembina' => 'Ibu. Maria Simanjuntak, S.Sn',
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
                'pembina' => 'Ibu. Sarah Fitriani, S.Pd',
                'hari_latihan' => 'Selasa',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'tempat_latihan' => 'Ruang Bahasa',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Pencak Silat',
                'deskripsi' => 'Ekstrakurikuler bela diri tradisional Indonesia untuk membentuk fisik, mental, dan karakter siswa.',
                'pembina' => 'Bpk. Eko Prasetyo, S.Pd',
                'hari_latihan' => 'Sabtu',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '11:00:00',
                'tempat_latihan' => 'Ruang Serbaguna',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Robotik',
                'deskripsi' => 'Ekstrakurikuler robotik untuk mengembangkan kreativitas dan kemampuan teknologi siswa di bidang robotika.',
                'pembina' => 'Bpk. Andi Wijaya, S.Kom',
                'hari_latihan' => 'Jumat',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'tempat_latihan' => 'Lab Komputer',
                'status' => 'aktif'
            ],
            [
                'nama_ekskul' => 'Tari Tradisional',
                'deskripsi' => 'Ekstrakurikuler seni tari tradisional untuk melestarikan budaya dan mengembangkan bakat tari siswa.',
                'pembina' => 'Ibu. Dewi Lestari, S.Sn',
                'hari_latihan' => 'Kamis',
                'jam_mulai' => '15:00:00',
                'jam_selesai' => '17:00:00',
                'tempat_latihan' => 'Ruang Tari',
                'status' => 'aktif'
            ]
        ];

        foreach ($ekskuls as $data) {
            Ekstrakurikuler::create([
                'nama_ekskul' => $data['nama_ekskul'],
                'slug' => Str::slug($data['nama_ekskul']),
                'deskripsi' => $data['deskripsi'],
                'pembina' => $data['pembina'],
                'hari_latihan' => $data['hari_latihan'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_selesai' => $data['jam_selesai'],
                'tempat_latihan' => $data['tempat_latihan'],
                'status' => $data['status']
            ]);
        }

        // ===== BUAT ANGGOTA =====
        $kelas = ['X-A', 'X-B', 'X-C', 'XI-A', 'XI-B', 'XI-C', 'XII-A', 'XII-B', 'XII-C'];
        $ekskulIds = Ekstrakurikuler::pluck('id')->toArray();
        
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => "Anggota $i",
                'email' => "anggota$i@mail.com",
                'password' => Hash::make('password'),
                'role' => 'anggota',
                'kelas' => $kelas[array_rand($kelas)],
                'no_hp' => '0812' . rand(10000000, 99999999)
            ]);
            
            // Assign ke ekskul random
            if (rand(0, 1) && count($ekskulIds) > 0) {
                DB::table('anggota_ekskul')->insert([
                    'user_id' => $user->id,
                    'ekskul_id' => $ekskulIds[array_rand($ekskulIds)],
                    'tahun_masuk' => date('Y') - rand(0, 2),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // ===== BUAT PELATIH DEMO =====
        $paskibra = Ekstrakurikuler::where('slug', 'paskibra')->first();
        User::create([
            'name' => 'Pelatih Utama',
            'email' => 'pelatih@mail.com',
            'password' => Hash::make('password'),
            'role' => 'pelatih',
            'kelas' => null,
            'no_hp' => '081234567891',
            'ekskul_id' => $paskibra ? $paskibra->id : null,
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // ===== BUAT TEMPLATE SURAT =====
        $templates = [
            [
                'judul_template' => 'Surat Izin Kegiatan',
                'file_template' => 'surat_izin_kegiatan.docx',
                'keterangan' => 'Template untuk surat izin kegiatan ekstrakurikuler'
            ],
            [
                'judul_template' => 'Surat Keterangan Aktif',
                'file_template' => 'surat_keterangan_aktif.docx',
                'keterangan' => 'Template untuk surat keterangan aktif ekstrakurikuler'
            ],
            [
                'judul_template' => 'Surat Permohonan',
                'file_template' => 'surat_permohonan.docx',
                'keterangan' => 'Template untuk surat permohonan kegiatan'
            ],
            [
                'judul_template' => 'Surat Tugas Pembina',
                'file_template' => 'surat_tugas_pembina.docx',
                'keterangan' => 'Template untuk surat tugas pembina ekstrakurikuler'
            ],
            [
                'judul_template' => 'Surat Rekomendasi',
                'file_template' => 'surat_rekomendasi.docx',
                'keterangan' => 'Template untuk surat rekomendasi kegiatan'
            ]
        ];

        foreach ($templates as $template) {
            TemplateSurat::create([
                'judul_template' => $template['judul_template'],
                'file_template' => $template['file_template'],
                'keterangan' => $template['keterangan']
            ]);
        }
    }
}