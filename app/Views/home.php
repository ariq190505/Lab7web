<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div id="hero">
    <h1>Selamat Datang di Lab7Web</h1>
    <p>Website ini dibuat menggunakan framework CodeIgniter 4 sebagai bagian dari praktikum pemrograman web.</p>
</div>

<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>

<div class="row">
    <div class="box">
        <img src="https://via.placeholder.com/150x150" alt="CodeIgniter" class="image-circle">
        <h3>CodeIgniter 4</h3>
        <p>Framework PHP yang ringan dan mudah digunakan untuk pengembangan aplikasi web modern.</p>
    </div>
    <div class="box">
        <img src="https://via.placeholder.com/150x150" alt="MVC" class="image-circle">
        <h3>MVC Pattern</h3>
        <p>Menggunakan pola Model-View-Controller untuk struktur kode yang terorganisir dan mudah dipelihara.</p>
    </div>
    <div class="box">
        <img src="https://via.placeholder.com/150x150" alt="Responsive" class="image-circle">
        <h3>Responsive Design</h3>
        <p>Layout yang responsif dan dapat menyesuaikan dengan berbagai ukuran layar perangkat.</p>
    </div>
</div>

<hr class="divider">

<div class="entry">
    <h2>Tentang Praktikum Ini</h2>
    <img src="https://via.placeholder.com/200x150" alt="Praktikum">
    <p>Praktikum ini mencakup pembelajaran tentang routing, controller, view, dan layout dalam CodeIgniter 4. Anda akan belajar cara membuat aplikasi web yang terstruktur dengan baik menggunakan framework yang populer ini.</p>
    <p>Fitur-fitur yang dipelajari meliputi pembuatan routes, controller dengan berbagai method, view dengan template, dan styling CSS untuk tampilan yang menarik.</p>
</div>

<?= $this->endSection() ?>
