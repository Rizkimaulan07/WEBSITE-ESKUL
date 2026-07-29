<?php

namespace App\Http\Controllers;

use App\Models\TemplateSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateSuratController extends Controller
{
    public function index()
    {
        $templates = TemplateSurat::orderBy('created_at', 'desc')->get();
        return view('admin.template-surat.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.template-surat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_template' => 'required|string|max:255',
            'file_template' => 'required|file|mimes:doc,docx|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        if ($request->hasFile('file_template')) {
            $file = $request->file('file_template');
            $namaFile = time() . '_' . str_replace(' ', '_', $request->judul_template) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/template-surat', $namaFile);
            
            TemplateSurat::create([
                'judul_template' => $request->judul_template,
                'file_template' => 'template-surat/' . $namaFile,
                'keterangan' => $request->keterangan
            ]);
        }

        return redirect()->route('template-surat.index')
                         ->with('success', '📄 Template surat berhasil ditambahkan!');
    }

    public function edit(TemplateSurat $templateSurat)
    {
        return view('admin.template-surat.edit', compact('templateSurat'));
    }

    public function update(Request $request, TemplateSurat $templateSurat)
    {
        $request->validate([
            'judul_template' => 'required|string|max:255',
            'file_template' => 'nullable|file|mimes:doc,docx|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->except('file_template');

        if ($request->hasFile('file_template')) {
            // Hapus file lama
            if (Storage::exists('public/' . $templateSurat->file_template)) {
                Storage::delete('public/' . $templateSurat->file_template);
            }
            
            $file = $request->file('file_template');
            $namaFile = time() . '_' . str_replace(' ', '_', $request->judul_template) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/template-surat', $namaFile);
            $data['file_template'] = 'template-surat/' . $namaFile;
        }

        $templateSurat->update($data);

        return redirect()->route('template-surat.index')
                         ->with('success', '✏️ Template surat berhasil diupdate!');
    }

    public function destroy(TemplateSurat $templateSurat)
    {
        if (Storage::exists('public/' . $templateSurat->file_template)) {
            Storage::delete('public/' . $templateSurat->file_template);
        }
        
        $templateSurat->delete();
        return redirect()->route('template-surat.index')
                         ->with('success', '🗑️ Template surat berhasil dihapus!');
    }

    public function download(TemplateSurat $templateSurat)
    {
        if (Storage::exists('public/' . $templateSurat->file_template)) {
            return response()->download(storage_path('app/public/' . $templateSurat->file_template));
        }
        return redirect()->back()->with('error', 'File tidak ditemukan!');
    }
}