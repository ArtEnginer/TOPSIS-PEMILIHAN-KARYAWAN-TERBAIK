<?php
/** @var \CodeIgniter\View\View $this */
?>

<?=$this->extend(config('Auth')->views['layout'])?>

<?=$this->section('title')?>
<?=lang('Auth.login')?>
<?=$this->endSection()?>

<?=$this->section('main')?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="my-5 flex justify-center">
            <img src="<?=base_url('img/logo/original.png')?>" alt="logo" width="140">
        </div>
        <div class="row">
            <form class="col s12" action="<?=base_url('registration')?>" id="registration" method="post">
                <?=csrf_field()?>
                <div class="row mb-0">
                    <div class="input-field col s12">
                        <input id="name" name="name" type="text" class="validate" value="<?=auth()->user()->name ?? null?>" required>
                        <label for="name">Nama Institusi</label>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="input-field col s12">
                        <input id="label" name="label" type="text" class="validate" value="<?=old('label')?>" required>
                        <label for="label">Label (Sebutan / Singkatan)</label>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea" required></textarea>
                        <label for="address">Alamat</label>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="input-field col s12">
                        <select name="type">
                            <option value="" disabled selected>Pilih tipe</option>
                            <option value="pt">Perguruan Tinggi</option>
                            <option value="smk">Sekolah Menengah Kejuruan</option>
                            <option value="sma">Sekolah Menengah Atas</option>
                            <option value="lpk">Lembaga Pelatihan Kerja</option>
                        </select>
                        <label>Tipe Institusi</label>
                    </div>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-auth">
                    Daftarkan Lembaga
                </button>
            </form>
        </div>
    </div>
</div>

<?=$this->endSection()?>