<?php

namespace Database\Seeders;

use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = 2;
        $password = 'KostRosanty00';
        $users = [
            ['name' => 'Milenia Muji', 'email' => 'milenia@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Azza Nabilatun Nimah', 'email' => 'azza@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Dita Intan Widyawati', 'email' => 'dita@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Annisa Putri Pratama', 'email' => 'annisa@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Fitri Anggun Lestari', 'email' => 'fitri@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Riana Dwi Cahyani', 'email' => 'riana@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Nadia Ayu Kartika', 'email' => 'nadia@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password],
            ['name' => 'Salsabila Nur Safitri', 'email' => 'salsabila@gmail.com', 'password' => bcrypt($password), 'role' => $role, 'text' => $password]
        ];

        $penghunis = [
            ['nik_penghuni' => '3521094101000005', 'tempat_lahir' => 'Ngawi', 'tanggal_lahir' => '2000-01-01', 'telepon_penghuni' => '081234567891', 'alamat_penghuni' => 'Jl. Tawangsakti 003/001, Kec. Kartoharjo' . "\n" . 'Kota Madiun Jawa Timur'],
            ['nik_penghuni' => '3316044402040001', 'tempat_lahir' => 'Blora', 'tanggal_lahir' => '2004-02-04', 'telepon_penghuni' => '081234567892', 'alamat_penghuni' => 'Ds. Klagen 003/001, Kec. Kedungtuban' . "\n" . 'Kabupaten Blora Jawa Tengah'],
            ['nik_penghuni' => '3521095504020001', 'tempat_lahir' => 'Ngawi', 'tanggal_lahir' => '2002-04-15', 'telepon_penghuni' => '081234567893', 'alamat_penghuni' => 'Jl. Trunojoyo Gang Mayang I, Kec. Ngawi' . "\n" . 'Kabupaten Ngawi Jawa Timur'],
            ['nik_penghuni' => '3521156703010002', 'tempat_lahir' => 'Madiun', 'tanggal_lahir' => '2001-03-07', 'telepon_penghuni' => '081234567894', 'alamat_penghuni' => 'Jl. Cendana No. 10, Kec. Kartoharjo' . "\n" . 'Kota Madiun, Jawa Timur'],
            ['nik_penghuni' => '3521186702050003', 'tempat_lahir' => 'Magetan', 'tanggal_lahir' => '2002-05-16', 'telepon_penghuni' => '081234567895', 'alamat_penghuni' => 'Jl. Bromo No. 20, Kec. Magetan' . "\n" . 'Kabupaten Magetan, Jawa Timur'],
            ['nik_penghuni' => '3521176904070004', 'tempat_lahir' => 'Ponorogo', 'tanggal_lahir' => '2000-07-12', 'telepon_penghuni' => '081234567896', 'alamat_penghuni' => 'Jl. Mawar Indah No. 5, Kec. Ponorogo' . "\n" . 'Kabupaten Ponorogo, Jawa Timur'],
            ['nik_penghuni' => '3521126808120005', 'tempat_lahir' => 'Bojonegoro', 'tanggal_lahir' => '2003-08-21', 'telepon_penghuni' => '081234567897', 'alamat_penghuni' => 'Jl. Anggrek No. 15, Kec. Kota Bojonegoro' . "\n" . 'Kabupaten Bojonegoro, Jawa Timur'],
            ['nik_penghuni' => '3521107001010006', 'tempat_lahir' => 'Tuban', 'tanggal_lahir' => '2001-01-10', 'telepon_penghuni' => '081234567898', 'alamat_penghuni' => 'Jl. Merpati No. 8, Kec. Tuban' . "\n" . 'Kabupaten Tuban, Jawa Timur']
        ];

        foreach ($users as $key => $userData) {
            $user = User::create($userData);

            $penghunis[$key]['nama_penghuni'] = $userData['name'];

            $penghunis[$key]['user_id'] = $user->id;

            Penghuni::create($penghunis[$key]);
        }
    }
}
