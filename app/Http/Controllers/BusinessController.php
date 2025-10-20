<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\GoogleMapsParser;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBusinessRequest;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $businesses = Business::where('status', 1)->latest()->get();
        return view('umkm.data', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('umkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreBusinessRequest $request) // <-- gunakan Form Request (langkah 2)
    {
        $data = $request->validated();

        // ==== Upload foto (single) simpan sebagai string path ====
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $originalName = $foto->getClientOriginalName();
            $safeName = uniqid().'-'.$originalName;
            $path = $foto->storeAs('umkm', $safeName, 'public');
            $fotoPath = $path; // simpan sebagai string
        }
        $data['foto'] = $fotoPath;

        // ==== Koordinat: prioritas input manual ====
        $lat = $data['latitude']  ?? null;
        $lng = $data['longitude'] ?? null;

        // ==== Jika koordinat kosong & ada URL: coba ekstrak ====
        $url = $data['input_url'] ?? null;
        if ((is_null($lat) || is_null($lng)) && $url) {
            // Gunakan service untuk ekstrak koordinat (mendukung link pendek dan panjang)
            if (class_exists(GoogleMapsParser::class)) {
                if ($coords = GoogleMapsParser::extractLatLng($url)) {
                    $lat = $coords['lat'];
                    $lng = $coords['lng'];
                }
            }
        }

        $data['latitude']  = $lat;
        $data['longitude'] = $lng;

        // Tambahan metadata
        $data['status']  = 0;              // default pending (sesuai logika awalmu)
        $data['user_id'] = auth()->id();   // simpan pemilik data

        // Simpan
        $business = Business::create($data);

        return redirect()
            ->route('umkm.show', $business->id) // arahkan ke show supaya bisa lihat map
            ->with('success', 'UMKM berhasil didaftarkan dan menunggu persetujuan.');
    }


    /**
     * Display the specified resource.
     */
     public function show(string $id)
    {
        $business = Business::findOrFail($id);

        // Susun embed URL:
        // Prioritas: koordinat → alamat → input_url → nama
        $embed = null;

        if (!is_null($business->latitude) && !is_null($business->longitude)) {
            if (class_exists(GoogleMapsParser::class)) {
                $embed = GoogleMapsParser::embedUrlFromLatLng($business->latitude, $business->longitude);
            } else {
                // fallback sederhana tanpa service
                $lat = $business->latitude;
                $lng = $business->longitude;
                $embed = "https://www.google.com/maps?q={$lat},{$lng}&z=16&hl=id&output=embed";
            }
        } else {
            $query = $business->alamat ?: $business->input_url ?: $business->nama;
            if (class_exists(GoogleMapsParser::class)) {
                $embed = GoogleMapsParser::embedUrlFromQuery($query);
            } else {
                // fallback
                $embed = "https://www.google.com/maps?q=" . urlencode($query) . "&z=16&hl=id&output=embed";
            }
        }

        return view('umkm.show', compact('business', 'embed'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $business = Business::findOrFail($id);
        
        // Delete image from storage
        if ($business->foto) {
            Storage::disk('public')->delete($business->foto);
        }
        
        $business->delete();
        
        return redirect()->route('umkm.index')->with('success', 'UMKM berhasil dihapus.');
    }

    /**
     * Approve business
     */
    public function approve(string $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 1]);
        
        return redirect()->back()->with('success', 'UMKM berhasil disetujui.');
    }

    /**
     * Reject business
     */
    public function reject(string $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 0]);
        
        return redirect()->back()->with('success', 'UMKM ditolak.');
    }

    /**
     * Expand short Google Maps URL for AJAX preview
     */
    public function expandUrl(Request $request)
    {
        $url = $request->input('url');
        
        if (!$url) {
            return response()->json(['success' => false, 'message' => 'URL tidak ditemukan']);
        }

        try {
            // Check if it's a short URL
            if (GoogleMapsParser::isShortUrl($url)) {
                $expandedUrl = GoogleMapsParser::expandShortUrl($url);
                
                if ($expandedUrl) {
                    return response()->json([
                        'success' => true,
                        'expandedUrl' => $expandedUrl,
                        'originalUrl' => $url
                    ]);
                }
            }
            
            // If not short URL or expansion failed, return original
            return response()->json([
                'success' => false,
                'message' => 'Bukan link pendek atau gagal expand',
                'originalUrl' => $url
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'originalUrl' => $url
            ]);
        }
    }

}
