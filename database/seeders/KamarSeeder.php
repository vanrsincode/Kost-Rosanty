<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Kamar;
use App\Models\SewaKamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kamarData = [
            [
                'nomor_kamar' => 'K01',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K02',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K03',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K04',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K05',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K06',
                'tipe_kamar' => 'Tipe B',
                'harga_kamar' => 400000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K07',
                'tipe_kamar' => 'Tipe B',
                'harga_kamar' => 400000,
                'ket_kamar' => 'Kamar Lantai 1',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K08',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 2',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K09',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 2',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K10',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 2',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K11',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 2',
                'status_kamar' => 'Tersedia'
            ],
            [
                'nomor_kamar' => 'K12',
                'tipe_kamar' => 'Tipe A',
                'harga_kamar' => 500000,
                'ket_kamar' => 'Kamar Lantai 2',
                'status_kamar' => 'Tersedia'
            ]
        ];

        foreach ($kamarData as $kamarItem) {
            $kamar = Kamar::create([
                'nomor_kamar' => $kamarItem['nomor_kamar'],
                'tipe_kamar' => $kamarItem['tipe_kamar'],
                'harga_kamar' => $kamarItem['harga_kamar'],
                'ket_kamar' => $kamarItem['ket_kamar'],
                'status_kamar' => $kamarItem['status_kamar'],
            ]);

            // $kamar->fasilitas()->attach($kamarItem['fasilitas']);
        }
    }
}
