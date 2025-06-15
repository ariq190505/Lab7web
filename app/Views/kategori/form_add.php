<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <p>
        <label for="nama_kategori">Nama Kategori:</label>
        <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Masukkan nama kategori" required value="<?= old('nama_kategori'); ?>">
        <small>Slug akan dibuat otomatis dari nama kategori</small>
    </p>
    <p>
        <input type="submit" value="Simpan Kategori" class="btn btn-primary btn-large">
        <a href="<?= base_url('/admin/kategori'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->endSection() ?>
