<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Topsis\AlternatifModel;
use App\Models\Topsis\KriteriaModel;
use App\Models\Topsis\HasilModel;
use App\Models\Topsis\PenilaianModel;
use Illuminate\Support\Str;

class SeedSampleData extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:seed-sample';
    protected $description = 'Seed sample data untuk testing dashboard TOPSIS';

    public function run(array $params)
    {
        CLI::write('🌱 Seeding sample data untuk dashboard TOPSIS...', 'green');

        try {
            // Check if data already exists
            if (AlternatifModel::count() > 0) {
                CLI::write('⚠️  Data sudah ada di database. Gunakan --force untuk menimpa.', 'yellow');
                if (!in_array('--force', $params)) {
                    return;
                }
                CLI::write('🗑️  Menghapus data existing...', 'yellow');
                HasilModel::truncate();
                PenilaianModel::truncate();
                AlternatifModel::truncate();
                KriteriaModel::truncate();
            }

            // Seed Alternatif
            CLI::write('👤 Seeding Alternatif data...', 'blue');
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

            $altIds = [];
            foreach ($alternatifs as $alt) {
                $alt['id'] = Str::uuid();
                $altIds[] = $alt['id'];
                AlternatifModel::create($alt);
            }

            // Seed Kriteria
            CLI::write('⚖️  Seeding Kriteria data...', 'blue');
            $kriterias = [
                ['kode' => 'K001', 'nama' => 'Kinerja Kerja', 'bobot' => '0.25'],
                ['kode' => 'K002', 'nama' => 'Kedisiplinan', 'bobot' => '0.20'],
                ['kode' => 'K003', 'nama' => 'Kerjasama Tim', 'bobot' => '0.15'],
                ['kode' => 'K004', 'nama' => 'Inisiatif', 'bobot' => '0.15'],
                ['kode' => 'K005', 'nama' => 'Komunikasi', 'bobot' => '0.10'],
                ['kode' => 'K006', 'nama' => 'Loyalitas', 'bobot' => '0.10'],
                ['kode' => 'K007', 'nama' => 'Kepemimpinan', 'bobot' => '0.05'],
            ];

            foreach ($kriterias as $kriteria) {
                $kriteria['id'] = Str::uuid();
                KriteriaModel::create($kriteria);
            }

            // Seed Hasil
            CLI::write('📈 Seeding Hasil data...', 'blue');
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

            foreach ($altIds as $index => $altId) {
                if (isset($hasilData[$index])) {
                    // Current month
                    HasilModel::create([
                        'id' => Str::uuid(),
                        'alternatif_id' => $altId,
                        'nilai' => $hasilData[$index],
                        'periode' => date('Y-m'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Historical data for last 5 months
                    for ($i = 1; $i <= 5; $i++) {
                        $month = date('Y-m', strtotime("-{$i} months"));
                        $nilai = $hasilData[$index] + (rand(-15, 10) / 100);
                        $nilai = max(0, min(1, $nilai)); // Keep between 0 and 1

                        HasilModel::create([
                            'id' => Str::uuid(),
                            'alternatif_id' => $altId,
                            'nilai' => round($nilai, 4),
                            'periode' => $month,
                            'created_at' => now()->subMonths($i),
                            'updated_at' => now()->subMonths($i)
                        ]);
                    }
                }
            }

            CLI::write('✅ Sample data berhasil di-seed!', 'green');
            CLI::write('📊 Data Summary:', 'blue');
            CLI::write('   - Alternatif: ' . AlternatifModel::count() . ' records', 'light_gray');
            CLI::write('   - Kriteria: ' . KriteriaModel::count() . ' records', 'light_gray');
            CLI::write('   - Hasil: ' . HasilModel::count() . ' records', 'light_gray');
            CLI::write('');
            CLI::write('🚀 Dashboard siap digunakan! Akses: ' . base_url('kelola'), 'green');
        } catch (\Exception $e) {
            CLI::write('❌ Error: ' . $e->getMessage(), 'red');
        }
    }
}
