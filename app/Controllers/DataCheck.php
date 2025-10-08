<?php

namespace App\Controllers;

use App\Models\Topsis\AlternatifModel;
use App\Models\Topsis\KriteriaModel;
use App\Models\Topsis\HasilModel;
use App\Models\Topsis\PenilaianModel;

class DataCheck extends BaseController
{
    public function index()
    {
        echo "<h2>🔍 Database Data Check - TOPSIS System</h2>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .info { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
            .warning { background: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0; }
            .success { background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0; }
            table { border-collapse: collapse; width: 100%; margin: 15px 0; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
        </style>";

        try {
            // Check table counts
            $alternatifCount = AlternatifModel::count();
            $kriteriaCount = KriteriaModel::count();
            $hasilCount = HasilModel::count();
            $penilaianCount = PenilaianModel::count();

            echo "<div class='info'>";
            echo "<h3>📊 Data Summary</h3>";
            echo "<table>";
            echo "<tr><th>Table</th><th>Records</th><th>Status</th></tr>";
            echo "<tr><td>Alternatif</td><td>{$alternatifCount}</td><td>" . ($alternatifCount > 0 ? '✅ Ada Data' : '❌ Kosong') . "</td></tr>";
            echo "<tr><td>Kriteria</td><td>{$kriteriaCount}</td><td>" . ($kriteriaCount > 0 ? '✅ Ada Data' : '❌ Kosong') . "</td></tr>";
            echo "<tr><td>Hasil</td><td>{$hasilCount}</td><td>" . ($hasilCount > 0 ? '✅ Ada Data' : '❌ Kosong') . "</td></tr>";
            echo "<tr><td>Penilaian</td><td>{$penilaianCount}</td><td>" . ($penilaianCount > 0 ? '✅ Ada Data' : '❌ Kosong') . "</td></tr>";
            echo "</table>";
            echo "</div>";

            // Sample data for each table
            if ($alternatifCount > 0) {
                echo "<div class='success'>";
                echo "<h3>👤 Sample Alternatif Data</h3>";
                $sampleAlternatif = AlternatifModel::limit(5)->get();
                echo "<table>";
                echo "<tr><th>Nama</th><th>NIP</th><th>Bidang Tugas</th></tr>";
                foreach ($sampleAlternatif as $alt) {
                    echo "<tr><td>{$alt->nama}</td><td>{$alt->nip}</td><td>{$alt->bidang_tugas}</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            }

            if ($kriteriaCount > 0) {
                echo "<div class='success'>";
                echo "<h3>⚖️ Sample Kriteria Data</h3>";
                $sampleKriteria = KriteriaModel::limit(5)->get();
                echo "<table>";
                echo "<tr><th>Kode</th><th>Nama</th><th>Bobot</th></tr>";
                foreach ($sampleKriteria as $kriteria) {
                    echo "<tr><td>{$kriteria->kode}</td><td>{$kriteria->nama}</td><td>{$kriteria->bobot}</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            }

            if ($hasilCount > 0) {
                echo "<div class='success'>";
                echo "<h3>📈 Sample Hasil Data</h3>";
                $sampleHasil = HasilModel::with('alternatif')->limit(5)->get();
                echo "<table>";
                echo "<tr><th>Alternatif</th><th>Nilai</th><th>Periode</th></tr>";
                foreach ($sampleHasil as $hasil) {
                    $nama = $hasil->alternatif->nama ?? 'N/A';
                    echo "<tr><td>{$nama}</td><td>{$hasil->nilai}</td><td>{$hasil->periode}</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            }

            // Dashboard recommendation
            if ($hasilCount == 0 && $alternatifCount == 0) {
                echo "<div class='warning'>";
                echo "<h3>⚠️ Dashboard Status</h3>";
                echo "<p>Database belum memiliki data. Dashboard akan menggunakan <strong>sample data</strong> untuk demonstrasi.</p>";
                echo "<p><strong>Untuk menampilkan data real:</strong></p>";
                echo "<ol>";
                echo "<li>Tambahkan data Alternatif terlebih dahulu</li>";
                echo "<li>Tambahkan data Kriteria</li>";
                echo "<li>Lakukan Penilaian</li>";
                echo "<li>Generate Hasil TOPSIS</li>";
                echo "</ol>";
                echo "</div>";
            } else {
                echo "<div class='success'>";
                echo "<h3>✅ Dashboard Status</h3>";
                echo "<p>Database memiliki data! Dashboard akan menampilkan <strong>data real</strong> dari database.</p>";
                echo "</div>";
            }

            // API endpoint info
            echo "<div class='info'>";
            echo "<h3>🔗 API Endpoints</h3>";
            echo "<ul>";
            echo "<li><a href='" . base_url('api/dashboard') . "' target='_blank'>Dashboard API</a> - Data untuk dashboard</li>";
            echo "<li><a href='" . base_url('api/alternatif') . "' target='_blank'>Alternatif API</a> - Data alternatif</li>";
            echo "<li><a href='" . base_url('api/kriteria') . "' target='_blank'>Kriteria API</a> - Data kriteria</li>";
            echo "<li><a href='" . base_url('api/hasil') . "' target='_blank'>Hasil API</a> - Data hasil TOPSIS</li>";
            echo "</ul>";
            echo "</div>";
        } catch (\Exception $e) {
            echo "<div class='warning'>";
            echo "<h3>❌ Error</h3>";
            echo "<p>Terjadi error saat mengecek database: " . $e->getMessage() . "</p>";
            echo "<p>Dashboard akan menggunakan sample data.</p>";
            echo "</div>";
        }

        echo "<div class='info'>";
        echo "<h3>🎯 Next Steps</h3>";
        echo "<p><a href='" . base_url('kelola') . "'>📊 Lihat Dashboard</a> | <a href='" . base_url() . "'>🏠 Home</a></p>";
        echo "</div>";
    }
}
