<?php

/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layouts/landing/main') ?>
<?= $this->section('main') ?>


<div class="page" id="hero">
    <div class="herotext-wrapper">
        <h1>
            TOPSIS ALGORITHM
        </h1>
        <div class="desc">
            <br>
            <p>
                Topsis Algoritm is a web application that can help you to make a decision based on
                the best alternative. This application is based on the Topsis method which is a method that
                can help you to make a decision based on the best alternative. This application is based on
                the Topsis method which is a method that can help you to make a decision based on the best
                alternative.
            </p>
        </div>
        <a href="#" class="next-page"></a>
    </div>
    <div class="hero-wrapper">
        <img src="<?= base_url('img/hero.png') ?>" class="hero" alt="hero">
    </div>
</div>


<a href="<?= base_url('kelola') ?>" class="btn-login"><i class="material-icons">tune</i> Kelola</a>
<?= $this->endSection() ?>