<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\File;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        // Mengambil semua dokumen tanpa pengurutan
        $documents = Document::all();

        // Mengirimkan variabel $documents ke view index.blade.php
        return view('index', compact('documents'));
    }

    public function data()
    {
        $documents = Document::all();
        $datas = Data::all();
        return view('admin.document.data', compact('documents', 'datas'));
    }

    public function create()
    {
        $data = Data::all();
        return view('admin.document.create', compact('data'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
            'files.*.title' => 'nullable|string|max:255',
            'files.*.file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000',
            'file_date' => 'required|date',
        ]);

        // Buat Document baru
        $document = Document::create([
            'title' => $request->title,
            'data_id' => $request->data_id,
            'user_id' => auth()->id(),
            'date' => $request->file_date,
        ]);

        // Simpan file yang terkait dengan dokumen
        if ($request->has('files')) {
            foreach ($request->input('files') as $index => $fileData) {
                if ($request->hasFile("files.{$index}.file")) {
                    $file = $request->file("files.{$index}.file");
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('files', $originalName);

                    // Buat entri file baru di database
                    File::create([
                        'title' => !empty($fileData['title']) ? $fileData['title'] : pathinfo($originalName, PATHINFO_FILENAME),
                        'file_path' => $path,
                        'file_date' => $request->file_date,
                        'document_id' => $document->id,
                        'user_id' => auth()->id(),
                    ]);
                }
            }
        }

        return redirect()->route('document.data')->with('success', 'Document and Files created successfully.');
    }

    public function edit($id)
    {
        $document = Document::with('file')->findOrFail($id);
        $data = Data::all(); // Dropdown data

        return view('admin.document.edit', compact('document', 'data'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
            'existing_files.*.title' => 'nullable|string|max:255',
            'files.*.title' => 'nullable|string|max:255',
            'files.*.file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000',
            'file_date' => 'required|date',
        ]);

        // Temukan dokumen berdasarkan ID
        $document = Document::findOrFail($id);

        // Update dokumen dan created_at
        $document->update([
            'title' => $request->title,
            'data_id' => $request->data_id,
            'date' => $request->file_date,
        ]);

        // Update existing files titles
        if ($request->has('existing_files')) {
            foreach ($request->input('existing_files') as $fileId => $fileData) {
                $file = File::find($fileId);
                if ($file && $file->document_id == $document->id) {
                    $file->update([
                        'title' => $fileData['title'] ?? $file->title,
                    ]);
                }
            }
        }

        // Simpan file yang terkait dengan dokumen
        if ($request->has('files')) {
            foreach ($request->input('files') as $index => $fileData) {
                if ($request->hasFile("files.{$index}.file")) {
                    $file = $request->file("files.{$index}.file");
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('files', $originalName);

                    // Buat entri file baru di database
                    File::create([
                        'title' => !empty($fileData['title']) ? $fileData['title'] : pathinfo($originalName, PATHINFO_FILENAME),
                        'file_path' => $path,
                        'file_date' => $request->file_date,
                        'document_id' => $document->id,
                        'user_id' => auth()->id(),
                    ]);
                }
            }
        }

        return redirect()->route('document.data')->with('success', 'Document and Files updated successfully.');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $document = Document::find($id);

        // Jika data tidak ditemukan, kembalikan dengan pesan error
        if (!$document) {
            return redirect()->route('document.data')->with('error', 'Data not found.');
        }

        // Hapus data
        $document->delete();

        // Redirect kembali ke halaman daftar headline dengan pesan sukses
        return redirect()->route('document.data')->with('success', 'Document deleted successfully.');
    }
    public function show($id)
    {
        // Cari dokumen berdasarkan ID
        $document = Document::with('data', 'file')->findOrFail($id);

        // Jika dokumen ditemukan, kirim ke view publik
        return view('document.show', compact('document'));
    }

    public function adminShow($id)
    {
        // Cari dokumen berdasarkan ID
        $document = Document::with('data', 'file')->findOrFail($id);

        // Jika dokumen ditemukan, kirim ke view admin
        return view('admin.document.show', compact('document'));
    }

    public function downloadDocumentReport()
    {
        // Menggunakan DomPDF
        $pdf = app('dompdf.wrapper');

        // Hitung statistik dokumen
        $totalDocuments = Document::count();
        $totalData = Data::count(); 
        $totalFiles = File::count();

        // Ambil semua dokumen dengan relasi untuk tabel
        $documents = Document::with(['data', 'user', 'file'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Generate PDF dengan view yang akan kita buat
        $pdf->loadView('admin.document.report', compact(
            'totalDocuments', 
            'totalData', 
            'totalFiles',
            'documents'
        ));

        // Set paper size dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Download PDF dengan nama file yang sesuai
        return $pdf->download('Laporan_Dokumen_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
