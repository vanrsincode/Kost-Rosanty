<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitas = [
            ['nama_fasilitas' => 'Kasur'],
            ['nama_fasilitas' => 'Lemari'],
            ['nama_fasilitas' => 'Meja'],
            ['nama_fasilitas' => 'Kursi'],
            ['nama_fasilitas' => 'Wifi'],
            ['nama_fasilitas' => 'Dapur'],
            ['nama_fasilitas' => 'Ruang Tamu'],
            ['nama_fasilitas' => 'Parkiran Montor dan Mobil'],
            ['nama_fasilitas' => 'Kamar Mandi Dalam'],
            ['nama_fasilitas' => 'Kamar Mandi Luar'],
        ];

        foreach ($fasilitas as $key => $value) {
            Fasilitas::create($value);
        }
    }
}
