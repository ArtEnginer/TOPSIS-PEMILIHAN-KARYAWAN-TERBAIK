<?php

/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/auth/main') ?>
<?= $this->section('main') ?>

<div class="auth-card">

    <h1 class="title">
        Silahkan Masuk
    </h1>
    <br>
    <div class="row">
        <form class="col s12" action="#!" id="login" method="post">

            <?= csrf_field() ?>
            <input type="hidden" id="cred_type" name="" value="">
            <div class="row mb-0">
                <div class="input-field col s12">
                    <input id="cred" name="cred" type="email" class="validate" value="<?= old('cred') ?>" required>
                    <label for="cred">
                        <?= lang('Auth.email') ?>
                    </label>
                </div>
            </div>
            <div class="row mb-0">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate" required>
                    <label for="password">
                        <?= lang('Auth.password') ?>
                    </label>
                </div>
            </div>
            <!-- Remember me -->
            <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                <p class="my-4">
                    <label>
                        <input type="checkbox" name="remember" <?php if (old('remember')): ?> checked<?php endif ?> />
                        <span>
                            <?= lang('Auth.rememberMe') ?>
                        </span>
                    </label>
                </p>
            <?php endif; ?>
            <button type="submit" class="btn waves-effect waves-light btn-auth">
                Masuk
            </button>
            <!-- Register -->
            <?php if (setting('Auth.allowRegistration')): ?>
                <p class="my-4 center">Anda belum terdaftar ? <a href="<?= url_to('register') ?>" style="color: #0d6efd"><?= lang('Auth.register') ?></a></p>
            <?php endif; ?>
        </form>
    </div>
</div>

<?= $this->endSection() ?>