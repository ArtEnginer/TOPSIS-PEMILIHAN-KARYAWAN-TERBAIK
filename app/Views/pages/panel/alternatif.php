<?php

/** @var \kodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/panel/main') ?>
<?= $this->section('main') ?>
<h1 class="page-title">Data alternatif</h1>
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
                        <table class="striped highlight responsive-table" id="table-alternatif" width="100%">
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
    <h1>Tambah Alternatif</h1>
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
        <!-- NIP -->
        <div class="input-field col m6 s12">
            <input name="nip" id="nip" type="text" class="validate" required>
            <label for="nip">NIP</label>
        </div>
        <!-- bidang tugas-->
        <div class="input-field col m6 s12">
            <input name="bidang_tugas" id="bidang_tugas" type="text" class="validate" required>
            <label for="bidang_tugas">Bidang Tugas</label>
        </div>
        <!-- tempat lahit -->
        <div class="input-field col m6 s12">
            <input name="tempat_lahir" id="tempat_lahir" type="text" class="validate" required>
            <label for="tempat_lahir">Tempat Lahir</label>
        </div>
        <!-- tanggal lahir -->
        <div class="input-field col m6 s12">
            <input name="tanggal_lahir" id="tanggal_lahir" type="date" class="validate" required>
            <label for="tanggal_lahir">Tanggal Lahir</label>
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
        <!-- NIP -->
        <div class="input-field col m6 s12">
            <input name="nip" id="edit-nip" type="text" class="validate" required>
            <label for="edit-nip">NIP</label>
        </div>
        <!-- bidang tugas-->
        <div class="input-field col m6 s12">
            <input name="bidang_tugas" id="edit-bidang_tugas" type="text" class="validate" required>
            <label for="edit-bidang_tugas">Bidang Tugas</label>
        </div>
        <!-- tempat lahit -->
        <div class="input-field col m6 s12">
            <input name="tempat_lahir" id="edit-tempat_lahir" type="text" class="validate" required>
            <label for="edit-tempat_lahir">Tempat Lahir</label>
        </div>

        <div class="row">
            <div class="input-field col s12 center">
                <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons left">save</i>Simpan</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>