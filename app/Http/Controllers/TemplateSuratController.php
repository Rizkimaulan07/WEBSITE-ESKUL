<?php

namespace App\Http\Controllers;

use App\Models\TemplateSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateSuratController extends Controller
{
    public function index()
    {
        $templates = TemplateSurat::orderBy('created_at', 'desc')->paginate(10);
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
            'file_template' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('file_template')) {
            $file = $request->file('file_template');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/template-surat', $namaFile);
            $data['file_template'] = 'template-surat/' . $namaFile;
        }

        TemplateSurat::create($data);

        return redirect()->route('admin.template-surat.index')
                         ->with('success', '✅ Template surat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $templateSurat = TemplateSurat::findOrFail($id);
        return view('admin.template-surat.edit', compact('templateSurat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_template' => 'required|string|max:255',
            'file_template' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $templateSurat = TemplateSurat::findOrFail($id);
        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('file_template')) {
            if ($templateSurat->file_template && Storage::exists('public/' . $templateSurat->file_template)) {
                Storage::delete('public/' . $templateSurat->file_template);
            }
            
            $file = $request->file('file_template');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/template-surat', $namaFile);
            $data['file_template'] = 'template-surat/' . $namaFile;
        }

        $templateSurat->update($data);

        return redirect()->route('admin.template-surat.index')
                         ->with('success', '✅ Template surat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $templateSurat = TemplateSurat::findOrFail($id);
        
        if ($templateSurat->file_template && Storage::exists('public/' . $templateSurat->file_template)) {
            Storage::delete('public/' . $templateSurat->file_template);
        }
        
        $templateSurat->delete();

        return redirect()->route('admin.template-surat.index')
                         ->with('success', '🗑️ Template surat berhasil dihapus!');
    }

    public function download($id)
    {
        $templateSurat = TemplateSurat::findOrFail($id);
        
        if (!$templateSurat->file_template || !Storage::exists('public/' . $templateSurat->file_template)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::download('public/' . $templateSurat->file_template);
    }
}