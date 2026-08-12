<?php

namespace Tests\Feature;

use App\Models\Dokumentasi;
use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardDocumentationFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_can_filter_documentation_by_ekskul_and_title(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $basket = Ekstrakurikuler::create([
            'nama_ekskul' => 'Basket',
            'deskripsi' => 'Ekskul basket',
            'pembina' => 'Pak Budi',
            'hari_latihan' => 'Selasa',
            'jam_mulai' => '15:00:00',
            'jam_selesai' => '17:00:00',
            'tempat_latihan' => 'Lapangan',
            'slug' => 'basket',
        ]);

        $musik = Ekstrakurikuler::create([
            'nama_ekskul' => 'Musik',
            'deskripsi' => 'Ekskul musik',
            'pembina' => 'Bu Sari',
            'hari_latihan' => 'Rabu',
            'jam_mulai' => '15:00:00',
            'jam_selesai' => '17:00:00',
            'tempat_latihan' => 'Studio',
            'slug' => 'musik',
        ]);

        /** @var Dokumentasi $dokumentasi1 */
        $dokumentasi1 = Dokumentasi::create([
            'judul' => 'Latihan Basket Minggu Ini',
            'deskripsi' => 'Latihan rutin basket',
            'tanggal_kegiatan' => now()->toDateString(),
            'ekskul_id' => $basket->id,
            'diunggah_oleh' => $admin->id,
            'foto_path' => 'dokumentasi/basket.jpg',
        ]);

        /** @var Dokumentasi $dokumentasi2 */
        $dokumentasi2 = Dokumentasi::create([
            'judul' => 'Workshop Musik Malam Ini',
            'deskripsi' => 'Workshop musik',
            'tanggal_kegiatan' => now()->toDateString(),
            'ekskul_id' => $musik->id,
            'diunggah_oleh' => $admin->id,
            'foto_path' => 'dokumentasi/musik.jpg',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get('/admin/dashboard?ekskul_id=' . $basket->id . '&search=Basket');

        $response->assertOk();
        $response->assertSee('Latihan Basket Minggu Ini');
        $response->assertDontSee('Workshop Musik Malam Ini');
    }

    public function test_admin_can_view_pelatih_attendance_only(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $ekskul = Ekstrakurikuler::create([
            'nama_ekskul' => 'Basket',
            'deskripsi' => 'Ekskul basket',
            'pembina' => 'Pak Budi',
            'hari_latihan' => 'Selasa',
            'jam_mulai' => '15:00:00',
            'jam_selesai' => '17:00:00',
            'tempat_latihan' => 'Lapangan',
            'slug' => 'basket',
        ]);
        
        /** @var User $pelatih */
        $pelatih = User::factory()->create([
            'role' => 'pelatih',
            'ekskul_id' => $ekskul->id,
            'name' => 'Pelatih Basket',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get('/admin/kehadiran-pelatih');

        $response->assertOk();
    }

    public function test_admin_member_create_form_can_show_manual_email_and_password_fields(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->get('/admin/anggota/create');

        $response->assertOk();
        $response->assertSee('Email');
        $response->assertSee('Password');
    }
}