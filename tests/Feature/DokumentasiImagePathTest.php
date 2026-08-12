<?php

namespace Tests\Feature;

use App\Models\Dokumentasi;
use Tests\TestCase;

class DokumentasiImagePathTest extends TestCase
{
    public function test_normalize_foto_path_handles_public_and_storage_prefixes(): void
    {
        $this->assertSame('dokumentasi/test.jpg', Dokumentasi::normalizeFotoPath('dokumentasi/test.jpg'));
        $this->assertSame('dokumentasi/test.jpg', Dokumentasi::normalizeFotoPath('/dokumentasi/test.jpg'));
        $this->assertSame('dokumentasi/test.jpg', Dokumentasi::normalizeFotoPath('public/dokumentasi/test.jpg'));
        $this->assertSame('dokumentasi/test.jpg', Dokumentasi::normalizeFotoPath('storage/dokumentasi/test.jpg'));
    }
}
