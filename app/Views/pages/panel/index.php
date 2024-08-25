<?php

/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<h1 class="page-title">Dashboard</h1>
<div style="overflow:auto">
    <div class="container">
        <div class="row">
            <div class="col s12 m6 l3">
                <div class="count-card">
                    <div class="count-number" data-entity="alternatif">0</div>
                    <div class="count-desc">
                        <p><b>Jumlah</b></p>
                        <p>Data Alternatif</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="count-card">
                    <div class="count-number" data-entity="kriteria">0</div>
                    <div class="count-desc">
                        <p><b>Jumlah</b></p>
                        <p>Data Kriteria</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="text-card">
                    <p>
                        <!-- TOPSIS -->
                        Selamat datang di aplikasi TOPSIS. Aplikasi ini digunakan untuk melakukan perhitungan TOPSIS.

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>