<?php

/** @var \kodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<h1 class="page-title">Data penilaian</h1>
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
                        <table class="striped highlight responsive-table" id="table-penilaian" width="100%">
                            <thead>
                                <tr id="headerRow"></tr>
                            </thead>
                            <tbody id="dataBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>