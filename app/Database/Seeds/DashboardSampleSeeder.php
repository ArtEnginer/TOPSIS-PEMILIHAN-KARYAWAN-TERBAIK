<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Topsis\AlternatifModel;
use App\Models\Topsis\KriteriaModel;
use App\Models\Topsis\HasilModel;
use App\Models\Topsis\PenilaianModel;
use Illuminate\Support\Str;

class DashboardSampleSeeder extends Seeder
{
    public function run()
    {
        // Sample Alternatif Data
        $alternatifs = [
            ['kode' => 'ALT001', 'nama' => 'Ahmad Susanto', 'nip' => '1234567890', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '1990-01-15', 'bidang_tugas' => 'IT Development'],
            ['kode' => 'ALT002', 'nama' => 'Siti Rahayu', 'nip' => '1234567891', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '1988-03-22', 'bidang_tugas' => 'Human Resources'],
            ['kode' => 'ALT003', 'nama' => 'Budi Hartono', 'nip' => '1234567892', 'tempat_lahir' => 'Surabaya', 'tanggal_lahir' => '1985-07-10', 'bidang_tugas' => 'Finance'],
            ['kode' => 'ALT004', 'nama' => 'Dian Pratiwi', 'nip' => '1234567893', 'tempat_lahir' => 'Yogyakarta', 'tanggal_lahir' => '1992-05-18', 'bidang_tugas' => 'Marketing'],
            ['kode' => 'ALT005', 'nama' => 'Eko Prasetyo', 'nip' => '1234567894', 'tempat_lahir' => 'Semarang', 'tanggal_lahir' => '1987-11-25', 'bidang_tugas' => 'Operations'],
            ['kode' => 'ALT006', 'nama' => 'Fitri Handayani', 'nip' => '1234567895', 'tempat_lahir' => 'Malang', 'tanggal_lahir' => '1991-09-14', 'bidang_tugas' => 'Quality Assurance'],
            ['kode' => 'ALT007', 'nama' => 'Gilang Ramadhan', 'nip' => '1234567896', 'tempat_lahir' => 'Solo', 'tanggal_lahir' => '1989-12-03', 'bidang_tugas' => 'Research & Development'],
            ['kode' => 'ALT008', 'nama' => 'Hana Permata', 'nip' => '1234567897', 'tempat_lahir' => 'Medan', 'tanggal_lahir' => '1993-04-27', 'bidang_tugas' => 'Customer Service'],
            ['kode' => 'ALT009', 'nama' => 'Indra Wijaya', 'nip' => '1234567898', 'tempat_lahir' => 'Denpasar', 'tanggal_lahir' => '1986-08-16', 'bidang_tugas' => 'Production'],
            ['kode' => 'ALT010', 'nama' => 'Joko Santoso', 'nip' => '1234567899', 'tempat_lahir' => 'Palembang', 'tanggal_lahir' => '1984-06-09', 'bidang_tugas' => 'Logistics'],
        ];

        foreach ($alternatifs as $alt) {
            $alt['id'] = Str::uuid();
            AlternatifModel::create($alt);
        }

        // Sample Kriteria Data
        $kriterias = [
            ['kode' => 'K001', 'nama' => 'Kinerja Kerja', 'bobot' => 0.25],
            ['kode' => 'K002', 'nama' => 'Kedisiplinan', 'bobot' => 0.20],
            ['kode' => 'K003', 'nama' => 'Kerjasama Tim', 'bobot' => 0.15],
            ['kode' => 'K004', 'nama' => 'Inisiatif', 'bobot' => 0.15],
            ['kode' => 'K005', 'nama' => 'Komunikasi', 'bobot' => 0.10],
            ['kode' => 'K006', 'nama' => 'Loyalitas', 'bobot' => 0.10],
            ['kode' => 'K007', 'nama' => 'Kepemimpinan', 'bobot' => 0.05],
        ];

        foreach ($kriterias as $kriteria) {
            $kriteria['id'] = Str::uuid();
            KriteriaModel::create($kriteria);
        }

        // Sample Hasil Data
        $alternatifIds = AlternatifModel::pluck('id')->toArray();
        $hasilData = [
            0.9245,
            0.8967,
            0.8734,
            0.8456,
            0.8234,
            0.8012,
            0.7890,
            0.7678,
            0.7456,
            0.7234
        ];

        foreach ($alternatifIds as $index => $altId) {
            if (isset($hasilData[$index])) {
                HasilModel::create([
                    'id' => Str::uuid(),
                    'alternatif_id' => $altId,
                    'nilai' => $hasilData[$index],
                    'periode' => '2024-10',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Add historical data
                for ($i = 1; $i <= 5; $i++) {
                    $month = 10 - $i;
                    $periode = '2024-' . str_pad($month, 2, '0', STR_PAD_LEFT);
                    $nilai = $hasilData[$index] + (rand(-15, 10) / 100);
                    $nilai = max(0, min(1, $nilai)); // Keep between 0 and 1

                    HasilModel::create([
                        'id' => Str::uuid(),
                        'alternatif_id' => $altId,
                        'nilai' => round($nilai, 4),
                        'periode' => $periode,
                        'created_at' => now()->subMonths($i),
                        'updated_at' => now()->subMonths($i)
                    ]);
                }
            }
        }

        echo "Sample data for dashboard has been seeded successfully!\n";
    }
}
