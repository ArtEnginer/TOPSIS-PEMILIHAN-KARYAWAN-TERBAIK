<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\Topsis\AlternatifModel;
use App\Models\Topsis\KriteriaModel;
use App\Models\Topsis\HasilModel;
use App\Models\Topsis\PenilaianModel;

class DashboardController extends BaseApi
{
    public function index()
    {
        try {
            // Get summary counts
            $summary = [
                'alternatif' => AlternatifModel::count(),
                'kriteria' => KriteriaModel::count(),
                'hasil' => HasilModel::count(),
                'penilaian' => PenilaianModel::count(),
            ];

            $data = [
                'summary' => $summary,
                'top_performers' => $this->getTopPerformers(),
                'performance_by_period' => $this->getPerformanceByPeriod(),
                'kriteria_distribution' => $this->getKriteriaDistribution(),
                'bidang_tugas_stats' => $this->getBidangTugasStats(),
                'recent_results' => $this->getRecentResults(),
                'monthly_evaluation_trend' => $this->getMonthlyEvaluationTrend(),
                'performance_stats' => $this->getPerformanceStats(),
                'evaluation_summary' => $this->getEvaluationSummary()
            ];

            // If no data, provide sample data for demo
            if ($summary['hasil'] == 0 && $summary['alternatif'] == 0) {
                $data = $this->getSampleData();
            }

            return $this->respond($data);
        } catch (\Exception $e) {
            // Return sample data if error occurs
            return $this->respond($this->getSampleData());
        }
    }

    private function getTopPerformers($limit = 10)
    {
        try {
            $hasil = HasilModel::with('alternatif')
                ->select(
                    'alternatif_id',
                    \Illuminate\Support\Facades\DB::raw('MAX(nilai) as max_nilai'),
                    \Illuminate\Support\Facades\DB::raw('MAX(periode) as latest_periode')
                )
                ->groupBy('alternatif_id')
                ->orderBy('max_nilai', 'desc')
                ->limit($limit)
                ->get();

            return $hasil->map(function ($item) {
                return [
                    'nama' => $item->alternatif->nama ?? 'N/A',
                    'nip' => $item->alternatif->nip ?? 'N/A',
                    'bidang_tugas' => $item->alternatif->bidang_tugas ?? 'N/A',
                    'nilai' => round($item->max_nilai, 4),
                    'periode' => $item->latest_periode
                ];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getPerformanceByPeriod()
    {
        try {
            $hasil = HasilModel::select(
                'periode',
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_evaluasi'),
                \Illuminate\Support\Facades\DB::raw('AVG(nilai) as avg_nilai')
            )
                ->groupBy('periode')
                ->orderBy('periode', 'desc')
                ->limit(12)
                ->get();

            return $hasil->map(function ($item) {
                return [
                    'periode' => $item->periode,
                    'total_evaluasi' => $item->total_evaluasi,
                    'avg_nilai' => round($item->avg_nilai, 4)
                ];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getKriteriaDistribution()
    {
        try {
            return KriteriaModel::select('nama', 'bobot')
                ->orderBy(\Illuminate\Support\Facades\DB::raw('CAST(bobot AS DECIMAL(10,4))'), 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'nama' => $item->nama,
                        'bobot' => (float) $item->bobot
                    ];
                });
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getBidangTugasStats()
    {
        try {
            $alternatif = AlternatifModel::select(
                'bidang_tugas',
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total')
            )
                ->whereNotNull('bidang_tugas')
                ->where('bidang_tugas', '!=', '')
                ->groupBy('bidang_tugas')
                ->orderBy('total', 'desc')
                ->get();

            return $alternatif->map(function ($item) {
                return [
                    'bidang_tugas' => $item->bidang_tugas,
                    'total' => $item->total
                ];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getRecentResults($limit = 10)
    {
        try {
            $hasil = HasilModel::with('alternatif')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return $hasil->map(function ($item) {
                return [
                    'nama' => $item->alternatif->nama ?? 'N/A',
                    'nilai' => round($item->nilai, 4),
                    'periode' => $item->periode,
                    'tanggal' => $item->created_at ? $item->created_at->format('d M Y H:i') : 'N/A'
                ];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getMonthlyEvaluationTrend()
    {
        try {
            $hasil = HasilModel::select(
                \Illuminate\Support\Facades\DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_evaluasi'),
                \Illuminate\Support\Facades\DB::raw('AVG(nilai) as avg_nilai'),
                \Illuminate\Support\Facades\DB::raw('MAX(nilai) as max_nilai'),
                \Illuminate\Support\Facades\DB::raw('MIN(nilai) as min_nilai')
            )
                ->whereNotNull('created_at')
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();

            return $hasil->map(function ($item) {
                return [
                    'month' => $item->month,
                    'total_evaluasi' => $item->total_evaluasi,
                    'avg_nilai' => round($item->avg_nilai, 4),
                    'max_nilai' => round($item->max_nilai, 4),
                    'min_nilai' => round($item->min_nilai, 4)
                ];
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getPerformanceStats()
    {
        try {
            $hasil = HasilModel::select('nilai')->get();

            if ($hasil->isEmpty()) {
                return [
                    'avg_performance' => 0,
                    'top_score' => 0,
                    'total_this_month' => 0,
                    'improvement_rate' => 0
                ];
            }

            $currentMonth = date('Y-m');
            $lastMonth = date('Y-m', strtotime('-1 month'));

            $currentMonthResults = HasilModel::where('periode', $currentMonth)->get();
            $lastMonthResults = HasilModel::where('periode', $lastMonth)->get();

            $currentAvg = $currentMonthResults->avg('nilai') ?? 0;
            $lastAvg = $lastMonthResults->avg('nilai') ?? 0;

            $improvementRate = $lastAvg > 0 ? (($currentAvg - $lastAvg) / $lastAvg) * 100 : 0;

            return [
                'avg_performance' => round($hasil->avg('nilai'), 4),
                'top_score' => round($hasil->max('nilai'), 4),
                'total_this_month' => $currentMonthResults->count(),
                'improvement_rate' => round($improvementRate, 2)
            ];
        } catch (\Exception $e) {
            return [
                'avg_performance' => 0,
                'top_score' => 0,
                'total_this_month' => 0,
                'improvement_rate' => 0
            ];
        }
    }

    private function getEvaluationSummary()
    {
        try {
            $hasil = HasilModel::all();

            if ($hasil->isEmpty()) {
                return [
                    'excellent' => 0,
                    'good' => 0,
                    'average' => 0
                ];
            }

            $excellent = $hasil->where('nilai', '>=', 0.8)->count();
            $good = $hasil->where('nilai', '>=', 0.6)->where('nilai', '<', 0.8)->count();
            $average = $hasil->where('nilai', '<', 0.6)->count();

            return [
                'excellent' => $excellent,
                'good' => $good,
                'average' => $average
            ];
        } catch (\Exception $e) {
            return [
                'excellent' => 0,
                'good' => 0,
                'average' => 0
            ];
        }
    }

    private function getSampleData()
    {
        return [
            'summary' => [
                'alternatif' => 25,
                'kriteria' => 8,
                'hasil' => 150,
                'penilaian' => 200,
            ],
            'top_performers' => [
                ['nama' => 'Ahmad Susanto', 'nip' => '1234567890', 'bidang_tugas' => 'IT Development', 'nilai' => 0.9245, 'periode' => '2024-10'],
                ['nama' => 'Siti Rahayu', 'nip' => '1234567891', 'bidang_tugas' => 'Human Resources', 'nilai' => 0.8967, 'periode' => '2024-10'],
                ['nama' => 'Budi Hartono', 'nip' => '1234567892', 'bidang_tugas' => 'Finance', 'nilai' => 0.8734, 'periode' => '2024-10'],
                ['nama' => 'Dian Pratiwi', 'nip' => '1234567893', 'bidang_tugas' => 'Marketing', 'nilai' => 0.8456, 'periode' => '2024-10'],
                ['nama' => 'Eko Prasetyo', 'nip' => '1234567894', 'bidang_tugas' => 'Operations', 'nilai' => 0.8234, 'periode' => '2024-10'],
                ['nama' => 'Fitri Handayani', 'nip' => '1234567895', 'bidang_tugas' => 'Quality Assurance', 'nilai' => 0.8012, 'periode' => '2024-10'],
                ['nama' => 'Gilang Ramadhan', 'nip' => '1234567896', 'bidang_tugas' => 'Research & Development', 'nilai' => 0.7890, 'periode' => '2024-10'],
                ['nama' => 'Hana Permata', 'nip' => '1234567897', 'bidang_tugas' => 'Customer Service', 'nilai' => 0.7678, 'periode' => '2024-10'],
                ['nama' => 'Indra Wijaya', 'nip' => '1234567898', 'bidang_tugas' => 'Production', 'nilai' => 0.7456, 'periode' => '2024-10'],
                ['nama' => 'Joko Santoso', 'nip' => '1234567899', 'bidang_tugas' => 'Logistics', 'nilai' => 0.7234, 'periode' => '2024-10']
            ],
            'performance_by_period' => [
                ['periode' => '2024-10', 'total_evaluasi' => 25, 'avg_nilai' => 0.8145],
                ['periode' => '2024-09', 'total_evaluasi' => 23, 'avg_nilai' => 0.7923],
                ['periode' => '2024-08', 'total_evaluasi' => 22, 'avg_nilai' => 0.7756],
                ['periode' => '2024-07', 'total_evaluasi' => 24, 'avg_nilai' => 0.7890],
                ['periode' => '2024-06', 'total_evaluasi' => 21, 'avg_nilai' => 0.7645],
                ['periode' => '2024-05', 'total_evaluasi' => 20, 'avg_nilai' => 0.7534]
            ],
            'kriteria_distribution' => [
                ['nama' => 'Kinerja Kerja', 'bobot' => 0.25],
                ['nama' => 'Kedisiplinan', 'bobot' => 0.20],
                ['nama' => 'Kerjasama Tim', 'bobot' => 0.15],
                ['nama' => 'Inisiatif', 'bobot' => 0.15],
                ['nama' => 'Komunikasi', 'bobot' => 0.10],
                ['nama' => 'Loyalitas', 'bobot' => 0.10],
                ['nama' => 'Kepemimpinan', 'bobot' => 0.05]
            ],
            'bidang_tugas_stats' => [
                ['bidang_tugas' => 'IT Development', 'total' => 5],
                ['bidang_tugas' => 'Human Resources', 'total' => 4],
                ['bidang_tugas' => 'Finance', 'total' => 3],
                ['bidang_tugas' => 'Marketing', 'total' => 4],
                ['bidang_tugas' => 'Operations', 'total' => 3],
                ['bidang_tugas' => 'Quality Assurance', 'total' => 2],
                ['bidang_tugas' => 'Research & Development', 'total' => 2],
                ['bidang_tugas' => 'Customer Service', 'total' => 2]
            ],
            'recent_results' => [
                ['nama' => 'Ahmad Susanto', 'nilai' => 0.9245, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:30'],
                ['nama' => 'Siti Rahayu', 'nilai' => 0.8967, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:25'],
                ['nama' => 'Budi Hartono', 'nilai' => 0.8734, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:20'],
                ['nama' => 'Dian Pratiwi', 'nilai' => 0.8456, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:15'],
                ['nama' => 'Eko Prasetyo', 'nilai' => 0.8234, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:10'],
                ['nama' => 'Fitri Handayani', 'nilai' => 0.8012, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:05'],
                ['nama' => 'Gilang Ramadhan', 'nilai' => 0.7890, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 14:00'],
                ['nama' => 'Hana Permata', 'nilai' => 0.7678, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 13:55'],
                ['nama' => 'Indra Wijaya', 'nilai' => 0.7456, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 13:50'],
                ['nama' => 'Joko Santoso', 'nilai' => 0.7234, 'periode' => '2024-10', 'tanggal' => '08 Oct 2024 13:45']
            ],
            'monthly_evaluation_trend' => [
                ['month' => '2024-10', 'total_evaluasi' => 25, 'avg_nilai' => 0.8145, 'max_nilai' => 0.9245, 'min_nilai' => 0.7234],
                ['month' => '2024-09', 'total_evaluasi' => 23, 'avg_nilai' => 0.7923, 'max_nilai' => 0.9134, 'min_nilai' => 0.7012],
                ['month' => '2024-08', 'total_evaluasi' => 22, 'avg_nilai' => 0.7756, 'max_nilai' => 0.8967, 'min_nilai' => 0.6890],
                ['month' => '2024-07', 'total_evaluasi' => 24, 'avg_nilai' => 0.7890, 'max_nilai' => 0.9012, 'min_nilai' => 0.7123],
                ['month' => '2024-06', 'total_evaluasi' => 21, 'avg_nilai' => 0.7645, 'max_nilai' => 0.8745, 'min_nilai' => 0.6756],
                ['month' => '2024-05', 'total_evaluasi' => 20, 'avg_nilai' => 0.7534, 'max_nilai' => 0.8634, 'min_nilai' => 0.6645]
            ]
        ];
    }
}
