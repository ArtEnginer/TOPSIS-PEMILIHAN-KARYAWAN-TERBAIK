<?php

/** @var \kodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<h1 class="page-title">Data kriteria</h1>
<div class="page-wrapper">
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-6 text-end">
                    <a class="btn-header-slider green btn-popup" data-title="Tambah" data-action="add" data-target="add" type="button">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="table-wrapper">
                        <table class="striped highlight responsive-table" id="table-kriteria" width="100%">
                            <thead>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('popup') ?>
<div class="popup side" data-page="add">
    <h1>Tambah kriteria</h1>
    <br>
    <form action="" id="form-add" class="row">
        <div class="input-field col m6 s12">
            <input name="kode" id="kode" type="text" class="validate" required>
            <label for="kode">Kode</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="nama" id="nama" type="text" class="validate" required>
            <label for="nama">Nama</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="bobot" id="bobot" type="number" class="validate" required>
            <label for="bobot">Bobot</label>
        </div>
        <div class="row">
            <div class="input-field col s12 center">
                <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons left">save</i>Simpan</button>
            </div>
        </div>
    </form>
</div>
<div class="popup side" data-page="edit">
    <h1>Edit Data </h1>
    <br>
    <form action="" id="form-edit" class="row">
        <input type="hidden" name="id" id="edit-id">
        <div class="input-field col m6 s12">
            <input name="kode" id="edit-kode" type="text" class="validate" required>
            <label for="edit-kode">Kode</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="nama" id="edit-nama" type="text" class="validate" required>
            <label for="edit-nama">Nama</label>
        </div>
        <!--bobot -->
        <div class="input-field col m6 s12">
            <input name="bobot" id="edit-bobot" type="number" class="validate" required>
            <label for="edit-bobot">Bobot</label>
        </div>
        <div class="row">
            <div class="input-field col s12 center">
                <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons left">save</i>Simpan</button>
            </div>
        </div>
    </form>
</div>


<div class="popup side" data-page="subkriteria">
    <h1>Sub Kriteria</h1>
    <br>
    <div class="row">
        <div class="col-6 text-end">
            <a class="btn-header-slider green btn-popup" data-title="Tambah Subkriteria" data-action="add-subkriteria" data-target="add-subkriteria" type="button">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="table-wrapper">
                <table class="striped highlight responsive-table" id="table-subkriteria" width="100%">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="popup side" data-page="add-subkriteria">
    <h1>Tambah Sub Kriteria</h1>
    <br>
    <form action="" id="form-add-subkriteria" class="row">
        <input type="hidden" name="kriteria_id" id="kriteria_id">
        <div class="input-field col m6 s12">
            <input name="kode" id="kode_sub" type="text" class="validate" required>
            <label for="kode_sub">Kode</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="nama" id="nama_sub" type="text" class="validate" required>
            <label for="nama_sub">Nama</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="value" id="value_sub" type="number" class="validate" required>
            <label for="value_sub">value</label>
        </div>
        <div class="row">
            <div class="input-field col s12 center">
                <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons left">save</i>Simpan</button>
            </div>
        </div>
    </form>
</div>

<div class="popup side" data-page="edit-subkriteria">
    <h1>Edit Sub Kriteria</h1>
    <br>
    <form action="" id="form-edit-subkriteria" class="row">
        <input type="hidden" name="id" id="edit-id-sub">
        <div class="input-field col m6 s12">
            <input name="kode" id="edit-kode-sub" type="text" class="validate" required>
            <label for="edit-kode-sub">Kode</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="nama" id="edit-nama-sub" type="text" class="validate" required>
            <label for="edit-nama-sub">Nama</label>
        </div>
        <div class="input-field col m6 s12">
            <input name="value" id="edit-value-sub" type="number" class="validate" required>
            <label for="edit-value-sub">value</label>
        </div>
        <div class="row">
            <div class="input-field col s12 center">
                <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons left">save</i>Simpan</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>