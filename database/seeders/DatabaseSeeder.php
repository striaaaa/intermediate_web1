<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Member;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'satriasahrul2@gmail.com'],
            [
                'name' => 'Satria Sahrul (Sekretaris)',
                'password' => bcrypt('12345678'),
            ]
        );

        foreach (['Layanan Advokasi', 'Simpan Pinjam', 'Pelatihan Wirausaha', 'Bantuan Hukum'] as $name) {
            Category::firstOrCreate(['nama' => $name]);
        }

        $members = [
            [
                'member_number' => 'CALON-2026-001',
                'full_name' => 'Budi Santoso',
                'nik' => '3212012304900001',
                'email' => 'budi.santoso@gmail.com',
                'phone' => '081234567891',
                'address' => 'Desa Juntinyuat RT 03/RW 01, Kec. Juntinyuat, Indramayu',
                'occupation' => 'Purna PMI Taiwan',
                'birth_date' => '1990-04-23',
                'birth_place' => 'Indramayu',
                'gender' => 'Laki-laki',
                'status' => 'PENDING_VERIFICATION',
                'registration_date' => now()->subDays(2),
                'simpanan_pokok_status' => 'UNPAID',
            ],
            [
                'member_number' => 'CALON-2026-002',
                'full_name' => 'Siti Rahmawati',
                'nik' => '3212015508920002',
                'email' => 'siti.rahma@gmail.com',
                'phone' => '081298765432',
                'address' => 'Desa Karangampel Kidul RT 02/RW 04, Indramayu',
                'occupation' => 'Purna PMI Hongkong',
                'birth_date' => '1992-08-15',
                'birth_place' => 'Indramayu',
                'gender' => 'Perempuan',
                'status' => 'PENDING_VERIFICATION',
                'registration_date' => now()->subDay(),
                'simpanan_pokok_status' => 'UNPAID',
            ],
            [
                'member_number' => 'CALON-2026-003',
                'full_name' => 'Ahmad Fauzi',
                'nik' => '3212011101880003',
                'email' => 'ahmad.fauzi@gmail.com',
                'phone' => '085712349988',
                'address' => 'Desa Krangkeng RT 05/RW 02, Kec. Krangkeng, Indramayu',
                'occupation' => 'Keluarga PMI Malaysia',
                'birth_date' => '1988-01-11',
                'birth_place' => 'Indramayu',
                'gender' => 'Laki-laki',
                'status' => 'PAYMENT_PENDING',
                'registration_date' => now()->subDays(5),
                'verified_at' => now()->subDays(3),
                'verified_by' => 'Satria Sahrul (Sekretaris)',
                'simpanan_pokok_status' => 'PARTIAL_500K',
                'simpanan_pokok_paid_amount' => 500000,
            ],
            [
                'member_number' => 'AGT-2026-004',
                'full_name' => 'Dewi Lestari',
                'nik' => '3212014407950004',
                'email' => 'dewi.lestari@gmail.com',
                'phone' => '087811223344',
                'address' => 'Jl. Melati II No. 14, Karangampel, Indramayu',
                'occupation' => 'Wirausaha Olahan Mangga (Purna PMI)',
                'birth_date' => '1995-07-04',
                'birth_place' => 'Indramayu',
                'gender' => 'Perempuan',
                'status' => 'ACTIVE',
                'registration_date' => now()->subMonths(3),
                'verified_at' => now()->subMonths(3),
                'verified_by' => 'Satria Sahrul (Sekretaris)',
                'simpanan_pokok_paid' => true,
                'simpanan_pokok_paid_amount' => 1000000,
                'simpanan_pokok_status' => 'PAID_FULL',
            ],
            [
                'member_number' => 'AGT-2026-005',
                'full_name' => 'Kasturi',
                'nik' => '3212011509930005',
                'email' => 'kasturi.migrant@gmail.com',
                'phone' => '082199887766',
                'address' => 'Desa Dadap RT 01/RW 01, Kec. Juntinyuat, Indramayu',
                'occupation' => 'Nelayan & Keluarga PMI',
                'birth_date' => '1993-09-15',
                'birth_place' => 'Indramayu',
                'gender' => 'Laki-laki',
                'status' => 'ACTIVE',
                'registration_date' => now()->subMonths(2),
                'verified_at' => now()->subMonths(2),
                'verified_by' => 'Satria Sahrul (Sekretaris)',
                'simpanan_pokok_paid' => true,
                'simpanan_pokok_paid_amount' => 1000000,
                'simpanan_pokok_status' => 'PAID_FULL',
            ],
        ];

        foreach ($members as $m) {
            Member::updateOrCreate(['nik' => $m['nik']], $m);
        }

        $branches = [
            [
                'nama' => 'Kantor Operasional Koperasi Indramayu',
                'jenis' => 'kantor',
                'alamat' => 'Perumahan Wijaya Kusuma, Jl. Melati II Blok C1 No. 44, Karangampel, Kab. Indramayu, Jawa Barat 45283',
                'telepon' => '+62 813-2385-0043',
                'latitude' => -6.4633000,
                'longitude' => 108.4528000,
            ],
            [
                'nama' => 'Sekretariat Nasional Migrant CARE Jakarta',
                'jenis' => 'kantor',
                'alamat' => 'Jl. Mampang Prapatan XVI No. 7, RT.3/RW.3, Duren Tiga, Kec. Pancoran, Kota Jakarta Selatan, DKI Jakarta 12760',
                'telepon' => '(021) 7997878',
                'latitude' => -6.2514000,
                'longitude' => 106.8315000,
            ],
            [
                'nama' => 'Posko Layanan & Advokasi DESBUMI Juntinyuat',
                'jenis' => 'posko',
                'alamat' => 'Balai Pertemuan Komunitas Desa Peduli Buruh Migran, Desa Juntinyuat, Kec. Juntinyuat, Kab. Indramayu',
                'telepon' => '+62 852-1122-3344',
                'latitude' => -6.3980000,
                'longitude' => 108.4350000,
            ],
            [
                'nama' => 'Posko Perlindungan Komunitas PMI Krangkeng',
                'jenis' => 'posko',
                'alamat' => 'Jl. Raya Krangkeng (Lintas Pantura), Kec. Krangkeng, Kab. Indramayu, Jawa Barat',
                'telepon' => '+62 819-3344-5566',
                'latitude' => -6.5120000,
                'longitude' => 108.5020000,
            ],
            [
                'nama' => 'Rumah Aman & Konseling PMI Rawajati Jakarta',
                'jenis' => 'rumah_aman',
                'alamat' => 'Komplek Rawajati Timur, Kalibata, Pancoran, Kota Jakarta Selatan, DKI Jakarta',
                'telepon' => '(021) 7918234',
                'latitude' => -6.2580000,
                'longitude' => 106.8550000,
            ],
        ];

        foreach ($branches as $b) {
            Branch::updateOrCreate(['nama' => $b['nama']], $b);
        }
    }
}
