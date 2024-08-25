<?php

/** @var \kodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<h1 class="page-title">Impementasi Topsis</h1>
<div class="page-wrapper">
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="table-wrapper">
                        <!-- input periode month -->
                        <div class="input-field col s12 m6">
                            <input type="month" id="periode" class="validate" value="<?= date('Y-m') ?>">
                            <label for="periode">Periode</label>
                        </div>
                        <div id="result"></div>
                        <div id="normalisasi"></div>
                        <div id="matrixY"></div>
                        <div id="solusiIdeal"></div>
                        <div id="jarakSolusi"></div>
                        <div id="kedekatanSolusi"></div>
                        <div id="rank"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>