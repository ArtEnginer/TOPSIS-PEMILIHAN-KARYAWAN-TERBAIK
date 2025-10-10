<?php

/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/panel/main') ?>

<?= $this->section('head') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Enhanced Dashboard CSS -->
<link rel="stylesheet" href="<?= base_url('css/dashboard-enhanced.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<style>
    /* Additional dashboard-specific styles with theme colors */
    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: -0.75rem;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0.75rem;
    }

    /* Page wrapper with theme background */
    .page-wrapper {
        background: var(--canvas-color, #e3edec);
        min-height: 100vh;
    }

    .page {
        background: var(--canvas-color, #e3edec);
    }

    @media (max-width: 768px) {
        .col-md-3 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (max-width: 480px) {
        .col-md-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Chart responsiveness */
    .chart-container canvas {
        max-height: 300px !important;
    }

    /* Table styling fixes with theme colors */
    .enhanced-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .enhanced-table th,
    .enhanced-table td {
        padding: 1rem 0.75rem;
        text-align: left;
        border-bottom: 1px solid rgba(64, 93, 91, 0.2);
        /* primary-color with opacity */
    }

    .enhanced-table tbody tr:hover {
        background: rgba(64, 93, 91, 0.1);
        /* primary-color with low opacity */
    }

    /* Animation enhancements */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .data-tables-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Notification styles with theme colors */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .notification {
        font-family: inherit;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .notification i {
        margin-right: 0.5rem;
    }

    /* Browser compatibility fixes */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .chart-container canvas {
        max-height: 100% !important;
        max-width: 100% !important;
    }

    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }

        .data-tables-section {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .notification {
            right: 10px;
            left: 10px;
            max-width: none;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="page-wrapper">
    <div class="page">
        <div class="dashboard-container">
            <div class="">

                <!-- Loading State -->
                <div id="loading" class="loading-enhanced">
                    <div class="spinner-enhanced"></div>
                </div>

                <!-- Dashboard Content -->
                <div id="dashboard-content" style="display: none;">
                    <!-- Enhanced Summary Statistics -->
                    <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-card-enhanced">
                            <div class="stat-icon-enhanced"><i class="fas fa-users"></i></div>
                            <h3 class="stat-number-enhanced" id="stat-alternatif">0</h3>
                            <p class="stat-label">Total Alternatif</p>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced">
                            <div class="stat-icon-enhanced"><i class="fas fa-list-check"></i></div>
                            <h3 class="stat-number-enhanced" id="stat-kriteria">0</h3>
                            <p class="stat-label">Kriteria Penilaian</p>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced">
                            <div class="stat-icon-enhanced"><i class="fas fa-chart-line"></i></div>
                            <h3 class="stat-number-enhanced" id="stat-hasil">0</h3>
                            <p class="stat-label">Hasil Evaluasi</p>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced">
                            <div class="stat-icon-enhanced"><i class="fas fa-clipboard-check"></i></div>
                            <h3 class="stat-number-enhanced" id="stat-penilaian">0</h3>
                            <p class="stat-label">Total Penilaian</p>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Key Metrics Row -->
                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                        <div class="col-md-3">
                            <div class="metric-card">
                                <h3 class="metric-value" id="avg-performance">0.75</h3>
                                <p class="metric-label">Rata-rata Performa</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card">
                                <h3 class="metric-value" id="top-score">0.95</h3>
                                <p class="metric-label">Skor Tertinggi</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card">
                                <h3 class="metric-value" id="evaluations-this-month">24</h3>
                                <p class="metric-label">Evaluasi Bulan Ini</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card">
                                <h3 class="metric-value" id="improvement-rate">+12%</h3>
                                <p class="metric-label">Tingkat Peningkatan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="charts-grid" data-aos="fade-up" data-aos-delay="200">
                        <!-- Top Performers Chart -->
                        <div class="chart-card-3d">
                            <h3 class="chart-title"> Top 10 Performers</h3>
                            <div class="chart-container">
                                <canvas id="topPerformersChart"></canvas>
                            </div>
                        </div>

                        <!-- Performance Trend Chart -->
                        <div class="chart-card-3d">
                            <h3 class="chart-title">Trend Evaluasi Bulanan</h3>
                            <div class="chart-container">
                                <canvas id="performanceTrendChart"></canvas>
                            </div>
                        </div>

                        <!-- Kriteria Distribution -->
                        <div class="chart-card-3d">
                            <h3 class="chart-title">Distribusi Bobot Kriteria</h3>
                            <div class="chart-container">
                                <canvas id="kriteriaChart"></canvas>
                            </div>
                        </div>

                        <!-- Bidang Tugas Stats -->
                        <div class="chart-card-3d">
                            <h3 class="chart-title">Statistik Bidang Tugas</h3>
                            <div class="chart-container">
                                <canvas id="bidangTugasChart"></canvas>
                            </div>
                        </div>

                        <!-- Performance Distribution -->
                        <div class="chart-card-3d">
                            <h3 class="chart-title">Distribusi Performa</h3>
                            <div class="chart-container">
                                <canvas id="performanceDistributionChart"></canvas>
                            </div>
                        </div>

                        <!-- Monthly Comparison -->
                        <div class="chart-card-3d">
                            <h3 class="chart-title">Perbandingan Bulanan</h3>
                            <div class="chart-container">
                                <canvas id="monthlyComparisonChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Data Tables Section -->
                    <div class="data-tables-section" data-aos="fade-up" data-aos-delay="300">
                        <!-- Recent Results Table -->
                        <div class="table-card glass-card">
                            <h3 class="table-title">📋 Hasil Evaluasi Terbaru</h3>
                            <div style="overflow-x: auto;">
                                <table class="enhanced-table data-table" id="recentResultsTable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Nilai</th>
                                            <th>Periode</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentResultsBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Performance by Period Table -->
                        <div class="table-card glass-card">
                            <h3 class="table-title">📊 Performa per Periode</h3>
                            <div style="overflow-x: auto;">
                                <table class="enhanced-table data-table" id="performanceByPeriodTable">
                                    <thead>
                                        <tr>
                                            <th>Periode</th>
                                            <th>Total Evaluasi</th>
                                            <th>Rata-rata Nilai</th>
                                            <th>Trend</th>
                                        </tr>
                                    </thead>
                                    <tbody id="performanceByPeriodBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                        <button class="dashboard-btn" onclick="loadDashboardData()">
                            <i class="fas fa-sync-alt"></i> Refresh Data
                        </button>
                        <!-- <button class="dashboard-btn" onclick="exportDashboard()" style="margin-left: 1rem;">
                            <i class="fas fa-download"></i> Export Report
                        </button> -->
                        <button class="dashboard-btn" onclick="toggleFullscreen()" style="margin-left: 1rem;">
                            <i class="fas fa-expand"></i> Fullscreen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let dashboardData = {};
    let charts = {};

    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true
        });
        loadDashboardData();
    });

    // Load dashboard data
    async function loadDashboardData() {
        try {
            document.getElementById('loading').style.display = 'flex';
            document.getElementById('dashboard-content').style.display = 'none';

            const response = await fetch(`${baseUrl}api/dashboard`);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('Dashboard API Response:', result); // Debug log

            // Handle different response formats
            let data = null;
            if (result.status === 200 && result.data) {
                data = result.data;
            } else if (result.summary) {
                // Direct data without wrapper
                data = result;
            } else {
                throw new Error('Invalid response format');
            }

            dashboardData = data;
            updateSummaryStats();
            createCharts();
            updateTables();

            document.getElementById('loading').style.display = 'none';
            document.getElementById('dashboard-content').style.display = 'block';

            showNotification('Data real berhasil dimuat!', 'success');

        } catch (error) {
            console.error('Error loading dashboard data:', error);

            // Use fallback sample data
            dashboardData = getSampleFallbackData();
            updateSummaryStats();
            createCharts();
            updateTables();

            document.getElementById('loading').style.display = 'none';
            document.getElementById('dashboard-content').style.display = 'block';

            // Show user-friendly message
            showNotification('Menggunakan data demo. Periksa koneksi database.', 'warning');
        }
    }

    // Export dashboard to PDF
    function exportDashboard() {
        showNotification('Fitur export sedang dalam pengembangan', 'info');
        // TODO: Implement PDF export functionality
    }

    // Toggle fullscreen mode
    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                showNotification('Gagal masuk mode fullscreen: ' + err.message, 'warning');
            });
        } else {
            document.exitFullscreen();
        }
    }

    // Auto refresh every 30 seconds
    setInterval(() => {
        loadDashboardData();
    }, 30000);

    // Fallback sample data
    function getSampleFallbackData() {
        return {
            summary: {
                alternatif: 25,
                kriteria: 7,
                hasil: 150,
                penilaian: 200
            },
            top_performers: [{
                    nama: 'Ahmad Susanto',
                    nip: '1234567890',
                    bidang_tugas: 'IT Development',
                    nilai: 0.9245,
                    periode: '2024-10'
                },
                {
                    nama: 'Siti Rahayu',
                    nip: '1234567891',
                    bidang_tugas: 'Human Resources',
                    nilai: 0.8967,
                    periode: '2024-10'
                },
                {
                    nama: 'Budi Hartono',
                    nip: '1234567892',
                    bidang_tugas: 'Finance',
                    nilai: 0.8734,
                    periode: '2024-10'
                },
                {
                    nama: 'Dian Pratiwi',
                    nip: '1234567893',
                    bidang_tugas: 'Marketing',
                    nilai: 0.8456,
                    periode: '2024-10'
                },
                {
                    nama: 'Eko Prasetyo',
                    nip: '1234567894',
                    bidang_tugas: 'Operations',
                    nilai: 0.8234,
                    periode: '2024-10'
                }
            ],
            performance_by_period: [{
                    periode: '2024-10',
                    total_evaluasi: 25,
                    avg_nilai: 0.8145
                },
                {
                    periode: '2024-09',
                    total_evaluasi: 23,
                    avg_nilai: 0.7923
                },
                {
                    periode: '2024-08',
                    total_evaluasi: 22,
                    avg_nilai: 0.7756
                }
            ],
            kriteria_distribution: [{
                    nama: 'Kinerja Kerja',
                    bobot: 0.25
                },
                {
                    nama: 'Kedisiplinan',
                    bobot: 0.20
                },
                {
                    nama: 'Kerjasama Tim',
                    bobot: 0.15
                },
                {
                    nama: 'Inisiatif',
                    bobot: 0.15
                },
                {
                    nama: 'Komunikasi',
                    bobot: 0.10
                }
            ],
            bidang_tugas_stats: [{
                    bidang_tugas: 'IT Development',
                    total: 5
                },
                {
                    bidang_tugas: 'Human Resources',
                    total: 4
                },
                {
                    bidang_tugas: 'Finance',
                    total: 3
                },
                {
                    bidang_tugas: 'Marketing',
                    total: 4
                }
            ],
            recent_results: [{
                    nama: 'Ahmad Susanto',
                    nilai: 0.9245,
                    periode: '2024-10',
                    tanggal: '08 Oct 2024 14:30'
                },
                {
                    nama: 'Siti Rahayu',
                    nilai: 0.8967,
                    periode: '2024-10',
                    tanggal: '08 Oct 2024 14:25'
                },
                {
                    nama: 'Budi Hartono',
                    nilai: 0.8734,
                    periode: '2024-10',
                    tanggal: '08 Oct 2024 14:20'
                }
            ],
            monthly_evaluation_trend: [{
                    month: '2024-10',
                    total_evaluasi: 25,
                    avg_nilai: 0.8145,
                    max_nilai: 0.9245,
                    min_nilai: 0.7234
                },
                {
                    month: '2024-09',
                    total_evaluasi: 23,
                    avg_nilai: 0.7923,
                    max_nilai: 0.9134,
                    min_nilai: 0.7012
                },
                {
                    month: '2024-08',
                    total_evaluasi: 22,
                    avg_nilai: 0.7756,
                    max_nilai: 0.8967,
                    min_nilai: 0.6890
                }
            ]
        };
    }

    // Show notification
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;

        // Theme-based colors
        const colors = {
            success: '#405d5b', // primary-color
            warning: '#cb6900', // secondary color from main CSS
            info: '#255b61', // dashboard-accent
            error: '#dc3545' // red for errors
        };

        notification.innerHTML = `
        <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; float: right; cursor: pointer;">✕</button>
    `;

        // Add notification styles
        const bgColor = colors[type] || colors.info;
        notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 9999;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
    `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // Update summary statistics
    function updateSummaryStats() {
        const summary = dashboardData.summary;
        document.getElementById('stat-alternatif').textContent = summary.alternatif;
        document.getElementById('stat-kriteria').textContent = summary.kriteria;
        document.getElementById('stat-hasil').textContent = summary.hasil;
        document.getElementById('stat-penilaian').textContent = summary.penilaian;
    }

    // Create all charts
    function createCharts() {
        createTopPerformersChart();
        createPerformanceTrendChart();
        createKriteriaChart();
        createBidangTugasChart();
        createPerformanceDistributionChart();
        createMonthlyComparisonChart();
        updateKeyMetrics();
    }

    // Update key metrics
    function updateKeyMetrics() {
        if (dashboardData.performance_stats) {
            const stats = dashboardData.performance_stats;
            document.getElementById('avg-performance').textContent = stats.avg_performance;
            document.getElementById('top-score').textContent = stats.top_score;
            document.getElementById('evaluations-this-month').textContent = stats.total_this_month;
            document.getElementById('improvement-rate').textContent = (stats.improvement_rate >= 0 ? '+' : '') + stats.improvement_rate + '%';
        }
    }

    // Top Performers Chart
    function createTopPerformersChart() {
        const ctx = document.getElementById('topPerformersChart').getContext('2d');
        if (charts.topPerformers) charts.topPerformers.destroy();

        let topPerformers = dashboardData.top_performers || [];

        if (topPerformers.length === 0) {
            // Create placeholder data
            topPerformers = [{
                nama: 'No Data Available',
                nilai: 0,
                nilai_akhir: 0,
                nip: '-',
                bidang_tugas: '-',
                periode: '-'
            }];
        }

        const data = topPerformers.slice(0, 10);

        charts.topPerformers = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.nama.length > 15 ? item.nama.substring(0, 15) + '...' : item.nama),
                datasets: [{
                    label: 'Nilai TOPSIS',
                    data: data.map(item => item.nilai || item.nilai_akhir || 0),
                    backgroundColor: 'rgba(64, 93, 91, 0.8)', // primary-color with opacity
                    borderColor: 'rgba(64, 93, 91, 1)', // primary-color
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            color: '#ffffff' // Warna putih untuk teks legenda
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        callbacks: {
                            afterLabel: function(context) {
                                const item = data[context.dataIndex];
                                return [
                                    `NIP: ${item.nip || '-'}`,
                                    `Bidang: ${item.bidang_tugas || '-'}`,
                                    `Periode: ${item.periode || '-'}`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label x-axis
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label y-axis
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        }
                    }
                }
            }
        });
    }
    // Performance Trend Chart
    function createPerformanceTrendChart() {
        const ctx = document.getElementById('performanceTrendChart').getContext('2d');
        if (charts.performanceTrend) charts.performanceTrend.destroy();

        let data = dashboardData.monthly_evaluation_trend || [];

        // If no trend data, use performance_by_period as fallback
        if (data.length === 0 && dashboardData.performance_by_period) {
            data = dashboardData.performance_by_period.map(item => ({
                month: item.periode,
                avg_nilai: item.avg_nilai,
                total_evaluasi: item.total_evaluasi,
                max_nilai: item.avg_nilai + 0.1,
                min_nilai: item.avg_nilai - 0.1
            }));
        }

        // If still no data, create placeholder
        if (data.length === 0) {
            data = [{
                month: new Date().toISOString().slice(0, 7),
                avg_nilai: 0,
                total_evaluasi: 0,
                max_nilai: 0,
                min_nilai: 0
            }];
        }

        // Don't reverse if it's already sorted
        const sortedData = [...data].sort((a, b) => a.month.localeCompare(b.month));

        charts.performanceTrend = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sortedData.map(item => item.month),
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: sortedData.map(item => item.avg_nilai),
                    borderColor: 'rgba(64, 93, 91, 1)', // primary-color
                    backgroundColor: 'rgba(64, 93, 91, 0.1)', // primary-color with low opacity
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Total Evaluasi',
                    data: sortedData.map(item => item.total_evaluasi),
                    borderColor: 'rgba(37, 91, 97, 1)', // dashboard-accent
                    backgroundColor: 'rgba(37, 91, 97, 0.1)', // dashboard-accent with low opacity
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff' // Warna putih untuk teks legenda
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label x-axis
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label y-axis
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label y1-axis
                        },
                        grid: {
                            drawOnChartArea: false,
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        },
                    }
                }
            }
        });
    }

    function createKriteriaChart() {
        const ctx = document.getElementById('kriteriaChart').getContext('2d');
        if (charts.kriteria) charts.kriteria.destroy();

        const data = dashboardData.kriteria_distribution;

        charts.kriteria = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.map(item => item.nama),
                datasets: [{
                    data: data.map(item => item.bobot),
                    backgroundColor: [
                        'rgba(64, 93, 91, 0.8)', // primary-color
                        'rgba(52, 72, 70, 0.8)', // darker-color
                        'rgba(37, 91, 97, 0.8)', // dashboard-accent
                        'rgba(203, 105, 0, 0.8)', // secondary from main CSS
                        'rgba(64, 93, 91, 0.6)', // primary-color lighter
                        'rgba(52, 72, 70, 0.6)', // darker-color lighter
                        'rgba(37, 91, 97, 0.6)', // dashboard-accent lighter
                        'rgba(203, 105, 0, 0.6)' // secondary lighter
                    ],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ffffff' // Warna putih untuk teks legenda
                        }
                    }
                }
            }
        });
    }

    // Bidang Tugas Chart
    function createBidangTugasChart() {
        const ctx = document.getElementById('bidangTugasChart').getContext('2d');
        if (charts.bidangTugas) charts.bidangTugas.destroy();

        const data = dashboardData.bidang_tugas_stats;

        charts.bidangTugas = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.map(item => item.bidang_tugas),
                datasets: [{
                    data: data.map(item => item.total),
                    backgroundColor: [
                        'rgba(64, 93, 91, 0.8)', // primary-color
                        'rgba(52, 72, 70, 0.8)', // darker-color
                        'rgba(37, 91, 97, 0.8)', // dashboard-accent
                        'rgba(203, 105, 0, 0.8)', // secondary from main CSS
                        'rgba(64, 93, 91, 0.6)', // primary-color lighter
                        'rgba(52, 72, 70, 0.6)', // darker-color lighter
                        'rgba(37, 91, 97, 0.6)', // dashboard-accent lighter
                        'rgba(203, 105, 0, 0.6)' // secondary lighter
                    ],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ffffff', // Warna putih untuk teks legenda
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
    // Update tables
    function updateTables() {
        updateRecentResultsTable();
        updatePerformanceByPeriodTable();
    }

    // Update Recent Results Table
    function updateRecentResultsTable() {
        const tbody = document.getElementById('recentResultsBody');
        tbody.innerHTML = '';

        const recentResults = dashboardData.recent_results || [];

        if (recentResults.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td colspan="5" class="text-center text-muted">
                    <i class="fas fa-info-circle me-2"></i>Belum ada data evaluasi terbaru
                </td>
            `;
            tbody.appendChild(row);
            return;
        }

        recentResults.forEach(item => {
            const row = document.createElement('tr');
            const performanceClass = getPerformanceClass(item.nilai);

            row.innerHTML = `
            <td><strong>${item.nama}</strong></td>
            <td><strong>${item.nilai}</strong></td>
            <td>${item.periode}</td>
            <td>${item.tanggal}</td>
            <td><span class="performance-indicator ${performanceClass}">${getPerformanceLabel(item.nilai)}</span></td>
        `;
            tbody.appendChild(row);
        });
    }

    // Update Performance by Period Table
    function updatePerformanceByPeriodTable() {
        const tbody = document.getElementById('performanceByPeriodBody');
        tbody.innerHTML = '';

        const performanceByPeriod = dashboardData.performance_by_period || [];

        if (performanceByPeriod.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td colspan="4" class="text-center text-muted">
                    <i class="fas fa-info-circle me-2"></i>Belum ada data performa per periode
                </td>
            `;
            tbody.appendChild(row);
            return;
        }

        performanceByPeriod.forEach((item, index) => {
            const row = document.createElement('tr');
            const nextItem = performanceByPeriod[index + 1];
            const trend = nextItem ? (item.avg_nilai > nextItem.avg_nilai ? '📈' : item.avg_nilai < nextItem.avg_nilai ? '📉' : '➡️') : '➡️';

            row.innerHTML = `
            <td><strong>${item.periode}</strong></td>
            <td>${item.total_evaluasi}</td>
            <td>${item.avg_nilai}</td>
            <td>${trend}</td>
        `;
            tbody.appendChild(row);
        });
    }

    // Helper functions
    function getPerformanceClass(nilai) {
        if (nilai >= 0.8) return 'performance-excellent';
        if (nilai >= 0.6) return 'performance-good';
        return 'performance-average';
    }

    function getPerformanceLabel(nilai) {
        if (nilai >= 0.8) return 'Excellent';
        if (nilai >= 0.6) return 'Good';
        return 'Average';
    }

    function createPerformanceDistributionChart() {
        const ctx = document.getElementById('performanceDistributionChart').getContext('2d');
        if (charts.performanceDistribution) charts.performanceDistribution.destroy();

        let data = [0, 0, 0]; // excellent, good, average

        if (dashboardData.evaluation_summary) {
            const summary = dashboardData.evaluation_summary;
            data = [summary.excellent || 0, summary.good || 0, summary.average || 0];
        } else if (dashboardData.recent_results && dashboardData.recent_results.length > 0) {
            // Fallback calculation from recent results
            dashboardData.recent_results.forEach(item => {
                if (item.nilai >= 0.8) data[0]++;
                else if (item.nilai >= 0.6) data[1]++;
                else data[2]++;
            });
        } else {
            // No data - show placeholder
            data = [0, 0, 1];
        }

        charts.performanceDistribution = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Excellent (≥0.8)', 'Good (0.6-0.8)', 'Average (<0.6)'],
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.8)', // Green for excellent (keep for good contrast)
                        'rgba(64, 93, 91, 0.8)', // primary-color for good  
                        'rgba(255, 152, 0, 0.8)' // Orange for average (keep for warning)
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ffffff', // Warna putih untuk teks legenda
                            padding: 20,
                            font: {
                                size: 12,
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
                                weight: 'normal'
                            },
                            usePointStyle: false,
                            boxWidth: 12,
                            boxHeight: 12
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        titleFont: {
                            size: 12
                        },
                        bodyFont: {
                            size: 11
                        },
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((context.parsed * 100) / total).toFixed(1) : 0;
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Monthly Comparison Chart
    function createMonthlyComparisonChart() {
        const ctx = document.getElementById('monthlyComparisonChart').getContext('2d');
        if (charts.monthlyComparison) charts.monthlyComparison.destroy();

        const data = dashboardData.monthly_evaluation_trend.slice(0, 6).reverse();

        charts.monthlyComparison = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(item => item.month),
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: data.map(item => item.avg_nilai),
                    borderColor: 'rgba(64, 93, 91, 1)', // primary-color
                    backgroundColor: 'rgba(64, 93, 91, 0.1)', // primary-color with low opacity
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Nilai Tertinggi',
                    data: data.map(item => item.max_nilai),
                    borderColor: 'rgba(76, 175, 80, 1)', // Keep green for high values
                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4
                }, {
                    label: 'Nilai Terendah',
                    data: data.map(item => item.min_nilai),
                    borderColor: 'rgba(203, 105, 0, 1)', // secondary color from main CSS
                    backgroundColor: 'rgba(203, 105, 0, 0.1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ffffff' // Warna putih untuk teks legenda
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label x-axis
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            color: '#ffffff' // Warna putih untuk label y-axis
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Grid line warna dengan opacity
                        }
                    }
                }
            }
        });
    }
    // Update Key Metrics
    function updateKeyMetrics() {
        const results = dashboardData.recent_results;
        const monthlyData = dashboardData.monthly_evaluation_trend;

        if (results.length > 0) {
            const avgPerformance = results.reduce((sum, item) => sum + item.nilai, 0) / results.length;
            const topScore = Math.max(...results.map(item => item.nilai));

            document.getElementById('avg-performance').textContent = avgPerformance.toFixed(2);
            document.getElementById('top-score').textContent = topScore.toFixed(2);
        }

        if (monthlyData.length > 0) {
            const thisMonth = monthlyData[0];
            const lastMonth = monthlyData[1];

            document.getElementById('evaluations-this-month').textContent = thisMonth?.total_evaluasi || 0;

            if (lastMonth) {
                const improvement = ((thisMonth.avg_nilai - lastMonth.avg_nilai) / lastMonth.avg_nilai * 100);
                document.getElementById('improvement-rate').textContent =
                    (improvement > 0 ? '+' : '') + improvement.toFixed(1) + '%';
            }
        }
    }

    // Performance Distribution Chart
    function createPerformanceDistributionChart() {
        const ctx = document.getElementById('performanceDistributionChart').getContext('2d');
        if (charts.performanceDistribution) charts.performanceDistribution.destroy();

        const results = dashboardData.recent_results;
        const excellent = results.filter(item => item.nilai >= 0.8).length;
        const good = results.filter(item => item.nilai >= 0.6 && item.nilai < 0.8).length;
        const average = results.filter(item => item.nilai < 0.6).length;

        charts.performanceDistribution = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Excellent (≥0.8)', 'Good (0.6-0.8)', 'Average (<0.6)'],
                datasets: [{
                    data: [excellent, good, average],
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(33, 150, 243, 0.8)',
                        'rgba(255, 152, 0, 0.8)'
                    ],
                    borderColor: [
                        'rgba(76, 175, 80, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(255, 152, 0, 1)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });
    }

    // Monthly Comparison Chart
    function createMonthlyComparisonChart() {
        const ctx = document.getElementById('monthlyComparisonChart').getContext('2d');
        if (charts.monthlyComparison) charts.monthlyComparison.destroy();

        const data = dashboardData.monthly_evaluation_trend.slice(0, 6).reverse();

        charts.monthlyComparison = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Total Evaluasi', 'Rata-rata Nilai', 'Nilai Maksimum', 'Nilai Minimum', 'Konsistensi', 'Trend'],
                datasets: data.map((item, index) => ({
                    label: item.month,
                    data: [
                        item.total_evaluasi / 10, // Normalize to 0-10 scale
                        item.avg_nilai * 10, // Scale 0-1 to 0-10
                        item.max_nilai * 10, // Scale 0-1 to 0-10
                        item.min_nilai * 10, // Scale 0-1 to 0-10
                        (item.max_nilai - item.min_nilai) * 10, // Consistency (inverted range)
                        index * 2 // Simple trend indicator
                    ],
                    backgroundColor: index === 0 ? 'rgba(64, 93, 91, 0.2)' : index === 1 ? 'rgba(52, 72, 70, 0.2)' : 'rgba(37, 91, 97, 0.2)',
                    borderColor: index === 0 ? 'rgba(64, 93, 91, 1)' : index === 1 ? 'rgba(52, 72, 70, 1)' : 'rgba(37, 91, 97, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: index === 0 ? 'rgba(64, 93, 91, 1)' : index === 1 ? 'rgba(52, 72, 70, 1)' : 'rgba(37, 91, 97, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: index === 0 ? 'rgba(64, 93, 91, 1)' : index === 1 ? 'rgba(52, 72, 70, 1)' : 'rgba(37, 91, 97, 1)'
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: 10
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Additional Dashboard Functions
    function exportDashboard() {
        const printWindow = window.open('', '_blank');
        const dashboardContent = document.getElementById('dashboard-content').innerHTML;

        printWindow.document.write(`
        <html>
            <head>
                <title>Dashboard TOPSIS Report</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .chart-container { page-break-inside: avoid; }
                    .table-card { page-break-inside: avoid; margin-bottom: 20px; }
                    @media print { .dashboard-btn { display: none; } }
                </style>
            </head>
            <body>
                <h1>Dashboard TOPSIS Report</h1>
                <p>Generated on: ${new Date().toLocaleString()}</p>
                ${dashboardContent}
            </body>
        </html>
    `);

        printWindow.document.close();
        printWindow.print();
    }

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }

    // Real-time updates (every 30 seconds)
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            loadDashboardData();
        }
    }, 30000);
</script>
<?= $this->endSection() ?>