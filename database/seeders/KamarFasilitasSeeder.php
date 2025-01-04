<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarFasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     ['kamar_id' => 1, 'fasilitas_id' => 1], 
        //     ['kamar_id' => 1, 'fasilitas_id' => 2],
        //     ['kamar_id' => 1, 'fasilitas_id' => 3],
        //     ['kamar_id' => 1, 'fasilitas_id' => 4],
        //     ['kamar_id' => 1, 'fasilitas_id' => 5],
        //     ['kamar_id' => 1, 'fasilitas_id' => 6],
        //     ['kamar_id' => 1, 'fasilitas_id' => 7],
        //     ['kamar_id' => 1, 'fasilitas_id' => 8],

        //     ['kamar_id' => 2, 'fasilitas_id' => 1], 
        //     ['kamar_id' => 2, 'fasilitas_id' => 2],
        //     ['kamar_id' => 2, 'fasilitas_id' => 3],
        //     ['kamar_id' => 2, 'fasilitas_id' => 4],
        //     ['kamar_id' => 2, 'fasilitas_id' => 5],
        //     ['kamar_id' => 2, 'fasilitas_id' => 6],
        //     ['kamar_id' => 2, 'fasilitas_id' => 7],
        //     ['kamar_id' => 2, 'fasilitas_id' => 8],
        // ];

        $data = [];

        $fasilitas_kamar = [
            1 => [1, 2, 3, 4, 5, 6, 7, 8, 9], 
            2 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            3 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            4 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            5 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            6 => [1, 2, 3, 4, 5, 6, 7, 8, 10],
            7 => [1, 2, 3, 4, 5, 6, 7, 8, 10],
            8 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            9 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            10 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            11 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
        ];

        foreach ($fasilitas_kamar as $kamar_id => $fasilitas_ids) {
            foreach ($fasilitas_ids as $fasilitas_id) {
                $data[] = [
                    'kamar_id' => $kamar_id,
                    'fasilitas_id' => $fasilitas_id,
                ];
            }
        }

        DB::table('kamar_fasilitas')->insert($data);
    }
}
