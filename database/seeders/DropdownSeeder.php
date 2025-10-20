<?php

namespace Database\Seeders;

use App\Models\Dropdown;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dropdowns = [
            [
                'title' => 'Dinas Pendidikan dan Kebudayaan',
                'icon_dropdown' => 'fas fa-school',
                'link' => 'https://disdikbud.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Sosial',
                'icon_dropdown' => 'fas fa-users',
                'link' => 'https://dinsos.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Tenaga Kerja  dan Transmigrasi',
                'icon_dropdown' => 'fas fa-briefcase',
                'link' => 'https://sikuning.okutimurkab.co.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'icon_dropdown' => 'fas fa-id-card',
                'link' => 'http://dukcapil.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Koperasi, Usaha Kecil dan Menengah',
                'icon_dropdown' => 'fas fa-store',
                'link' => 'https://dinkopukmokut.com/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
                'icon_dropdown' => 'fas fa-building',
                'link' => 'https://dpmptsp.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Badan Perencanaan Pembangunan Daerah dan Litbang',
                'icon_dropdown' => 'fas fa-chart-line',
                'link' => 'https://bappedalitbang.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia',
                'icon_dropdown' => 'fas fa-user-tie',
                'link' => 'https://bkpsdm.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Desa Cinta Statistik Terintegrasi',
                'icon_dropdown' => 'fas fa-chart-bar',
                'link' => 'https://sidomulyo-belitang.my.id/',
                'icon_id' => '7'
            ],
            [
                'title' => 'Badan Pusat Statistik Kabupaten Ogan Komering Ulu Timur',
                'icon_dropdown' => 'fas fa-chart-pie',  
                'link' => 'https://okutimurkab.bps.go.id/id',
                'icon_id' => '8'
            ],
        ];

        foreach ($dropdowns as $dropdown) {
            Dropdown::create($dropdown);
        }
    }
}
