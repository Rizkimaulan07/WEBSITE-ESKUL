<?php

namespace App\Http\Controllers;

use App\Models\TemplateSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

class SuratController extends Controller
{
    public function create()
    {
        $templates = TemplateSurat::all();
        return view('pelatih.surat.create', compact('templates'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:template_surats,id',
            'tujuan' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'isi_surat' => 'required|string',
            'perihal' => 'nullable|string'
        ]);

        $template = TemplateSurat::find($request->template_id);
        $pelatih = Auth::user();
        
        // Load template
        $templatePath = storage_path('app/public/' . $template->file_template);
        
        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan!');
        }
        
        $phpWord = IOFactory::load($templatePath);
        
        // Generate nomor surat otomatis
        $nomorSurat = 'SK/' . date('Y') . '/' . str_pad(SuratKeluar::count() + 1, 3, '0', STR_PAD_LEFT);
        
        // Ganti placeholder
        $placeholders = [
            '{nomor_surat}' => $nomorSurat,
            '{tanggal}' => date('d F Y', strtotime($request->tanggal_surat)),
            '{tujuan}' => $request->tujuan,
            '{isi_surat}' => $request->isi_surat,
            '{perihal}' => $request->perihal ?? 'Kegiatan Ekstrakurikuler',
            '{nama_pelatih}' => $pelatih->name,
            '{nama_ekskul}' => $pelatih->ekskul ? $pelatih->ekskul->nama_ekskul : 'Ekskul',
            '{tempat}' => $pelatih->ekskul ? $pelatih->ekskul->tempat_latihan : 'Sekolah'
        ];

        foreach ($phpWord->getSections() as $section) {
            $this->replaceTextInElement($section, $placeholders);
        }

        // Simpan file
        $fileName = 'surat_' . date('Ymd_His') . '.docx';
        $savePath = storage_path('app/public/surat-keluar/' . $fileName);
        
        // Buat folder jika belum ada
        if (!is_dir(storage_path('app/public/surat-keluar'))) {
            mkdir(storage_path('app/public/surat-keluar'), 0777, true);
        }
        
        $phpWord->save($savePath);

        // Simpan ke database
        SuratKeluar::create([
            'template_id' => $request->template_id,
            'dibuat_oleh' => $pelatih->id,
            'nomor_surat' => $nomorSurat,
            'tujuan' => $request->tujuan,
            'tanggal_surat' => $request->tanggal_surat,
            'isi_surat' => $request->isi_surat,
            'file_hasil' => 'surat-keluar/' . $fileName
        ]);

        return response()->download($savePath)->deleteFileAfterSend(true);
    }

    private function replaceTextInElement($element, $placeholders)
    {
        if (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $child) {
                $this->replaceTextInElement($child, $placeholders);
            }
        } elseif (method_exists($element, 'getText')) {
            $text = $element->getText();
            foreach ($placeholders as $key => $value) {
                if (strpos($text, $key) !== false) {
                    $element->setText(str_replace($key, $value, $text));
                }
            }
        }
    }

    public function history()
    {
        $surats = SuratKeluar::with(['template', 'pembuat'])
                             ->where('dibuat_oleh', Auth::id())
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
        return view('pelatih.surat.history', compact('surats'));
    }

    public function downloadSurat(SuratKeluar $surat)
    {
        if (Storage::exists('public/' . $surat->file_hasil)) {
            return response()->download(storage_path('app/public/' . $surat->file_hasil));
        }
        return redirect()->back()->with('error', 'File surat tidak ditemukan!');
    }
}