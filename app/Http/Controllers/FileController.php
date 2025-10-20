<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('index', compact('files'));
    }
    public function data(Request $request)
    {
        $query = File::query();
        $documents = Document::all();

        // Filter by document
        if ($request->filled('document_id')) {
            $query->where('document_id', $request->document_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting hanya berdasarkan id
        if ($request->input('sort') === 'id_asc') {
            $query->orderBy('id', 'asc');
        } elseif ($request->input('sort') === 'id_desc') {
            $query->orderBy('id', 'desc');
        } else {
            // Default: urut dari id terlama (asc)
            $query->orderBy('id', 'asc');
        }

        $files = $query->get();
        return view('admin.file.data', compact('files', 'documents'));
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        $filePath = $file->file_path;

        // Handle string case (JSON encoded with escape characters)
        if (is_string($filePath)) {
            // Remove extra quotes and handle JSON string
            $filePath = trim($filePath, '"');
            $filePath = str_replace('\/', '/', $filePath);
        }

        // Handle array case (get first element)
        if (is_array($filePath)) {
            $filePath = $filePath[0] ?? null;
            if ($filePath) {
                $filePath = str_replace('\/', '/', $filePath);
            }
        }

        // If it's a URL, redirect to it
        if (is_string($filePath) && (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://'))) {
            return redirect($filePath);
        }

        // If no valid file path
        if (!$filePath) {
            abort(404, 'File path not found');
        }

        $pathToFile = storage_path('app/' . $filePath);

        if (!file_exists($pathToFile)) {
            abort(404, 'File not found in storage');
        }

        return response()->download($pathToFile);
    }

    public function edit($id)
    {
    $file = File::findOrFail($id);
    $documents = Document::all(); // Untuk dropdown pilihan dokumen
    return view('admin.file.edit', compact('file', 'documents'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000',
            'file_date' => 'required|date',
            'document_id' => 'nullable|exists:documents,id',
        ]);

        $file = File::findOrFail($id);

        // Jika ada file baru yang diunggah, ganti file yang lama
        if ($request->hasFile('file_path')) {
            // Hapus file lama dari storage
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }

            // Simpan file baru
            $newFile = $request->file('file_path');
            $originalName = $newFile->getClientOriginalName();
            $path = $newFile->storeAs('files', $originalName);
            $file->file_path = $path;
        }

        // Perbarui data file di database
    $file->title = $request->title;
    $file->file_date = $request->file_date;
    $file->document_id = $request->document_id;
    $file->save();

        // Redirect ke halaman yang diinginkan
        return redirect()->route('file.data')->with('success', 'File updated successfully.');
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Hapus file dari storage
        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        // Hapus entri dari database
        $file->delete();

        return redirect()->route('file.data')->with('success', 'File deleted successfully.');
    }
    
    public function destroyAjax($id)
    {
        try {
            $file = File::findOrFail($id);
            
            // Delete the physical file from storage
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }
            
            // Delete the database record
            $file->delete();
            
            return response()->json(['success' => true, 'message' => 'File deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting file']);
        }
    }
    
    public function show($id)
    {
        $file = File::find($id);
        return view('admin.file.show', compact('file'));
    }

    public function serve($id)
    {
        $file = File::findOrFail($id);
        $filePath = $file->file_path;

        // Handle string case (JSON encoded with escape characters)
        if (is_string($filePath)) {
            // Remove extra quotes and handle JSON string
            $filePath = trim($filePath, '"');
            $filePath = str_replace('\/', '/', $filePath);
        }

        // Handle array case (get first element)
        if (is_array($filePath)) {
            $filePath = $filePath[0] ?? null;
            if ($filePath) {
                $filePath = str_replace('\/', '/', $filePath);
            }
        }

        // If it's a URL, redirect to it
        if (is_string($filePath) && (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://'))) {
            return redirect($filePath);
        }

        // If no valid file path
        if (!$filePath) {
            abort(404, 'File path not found');
        }

        // Build storage path
        $pathToFile = storage_path('app/' . $filePath);

        if (!file_exists($pathToFile)) {
            abort(404, 'File not found in storage');
        }

        // Get file extension for proper content type
        $extension = strtolower(pathinfo($pathToFile, PATHINFO_EXTENSION));
        
        // Set proper content type headers
        $headers = [];
        switch ($extension) {
            case 'pdf':
                $headers['Content-Type'] = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $headers['Content-Type'] = 'image/jpeg';
                break;
            case 'png':
                $headers['Content-Type'] = 'image/png';
                break;
            case 'gif':
                $headers['Content-Type'] = 'image/gif';
                break;
            case 'webp':
                $headers['Content-Type'] = 'image/webp';
                break;
            case 'xls':
                $headers['Content-Type'] = 'application/vnd.ms-excel';
                break;
            case 'xlsx':
                $headers['Content-Type'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break;
            default:
                $headers['Content-Type'] = 'application/octet-stream';
        }

        return response()->file($pathToFile, $headers);
    }
}
