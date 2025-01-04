<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],
            [
                'bulan_tagihan' => 11, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-11-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 1
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],
            [
                'bulan_tagihan' => 11, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-11-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 2
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],
            [
                'bulan_tagihan' => 11, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-11-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 3
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 4
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 4
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 4
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 4
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 4
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 4
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 400000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 5
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 400000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 5
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 400000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 5
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 400000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 5
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 400000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 5
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 400000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 5
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 6
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 6
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 6
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 6
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 6
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 6
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 7
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 7
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 7
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 7
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 7
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 7
            ],


            [
                'bulan_tagihan' => 5, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-05-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 8
            ],
            [
                'bulan_tagihan' => 6, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-06-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 8
            ],
            [
                'bulan_tagihan' => 7, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-07-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 8
            ],
            [
                'bulan_tagihan' => 8, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-08-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 8
            ],
            [
                'bulan_tagihan' => 9, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-09-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 8
            ],
            [
                'bulan_tagihan' => 10, 'tahun_tagihan' => 2024, 'tgl_pembayaran' => '2024-10-01', 
                'total_bayar' => 500000, 'metode_pembayaran' => 'Tunai', 'status_transaksi' => 'Lunas',
                'penghuni_id' => 8
            ],
        ];

        foreach ($data as $key => $value) {
            Transaksi::create($value);
        }
    }
}
