<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            ['title' => 'IKU, Renja, Renstra dan PK Perubahan Dinas Kepemudaan, Olahraga dan Pariwisata OKU Timur', 'data_id' => 2],
            ['title' => 'Pengumuman Lelang Kendaraan Dinas Kabupaten OKU Timur 2021', 'data_id' => 2],
            ['title' => 'Standar Operasional Prosedur PPID Kabupaten Ogan Komering Ulu Timur', 'data_id' => 2],
            ['title' => 'Pengumuman Penerimaan Pengadaan CPNS Pemerintah Kabupaten Ogan Komering Ulu Timur Formasi Tahun 2024', 'data_id' => 2],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
