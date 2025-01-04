<?php

namespace Database\Seeders;

use App\Models\SewaKamar;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SewaKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now()->format('Y-m-d');
        $sewa = [
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 1,
                'penghuni_id'       => 1
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 2,
                'penghuni_id'       => 2
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 3,
                'penghuni_id'       => 3
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 5,
                'penghuni_id'       => 4
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 6,
                'penghuni_id'       => 5
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 4,
                'penghuni_id'       => 6
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 9,
                'penghuni_id'       => 7
            ],
            [
                'tgl_awal_sewa'     => '2024-05-01',
                'kamar_id'          => 10,
                'penghuni_id'       => 8
            ]
        ];

        foreach ($sewa as $key => $value) {
            $createdSewa = SewaKamar::create($value);

            $tglAwalSewa = Carbon::parse($createdSewa->tgl_awal_sewa);

            $bulanTagihan = $tglAwalSewa->format('m');
            $tahunTagihan = $tglAwalSewa->format('Y');

            // $bulanTagihan = $tglAwalSewa->format('Y-m');

            $tagihan = [
                'bulan_tagihan' => $bulanTagihan,
                'tahun_tagihan' => $tahunTagihan,
                'total_bayar' => $createdSewa->kamar->harga_kamar,
                'sewa_kamar_id' => $createdSewa->id
            ];

            // Transaksi::create($tagihan);
        }
    }
}
