<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <p>
        <label for="judul">Judul Artikel:</label>
        <input type="text" id="judul" name="judul" placeholder="Masukkan judul artikel" required>
    </p>
    <p>
        <label for="isi">Isi Artikel:</label>
        <textarea id="isi" name="isi" cols="50" rows="10" placeholder="Masukkan isi artikel"></textarea>
    </p>
    <p>
        <input type="submit" value="Simpan Artikel" class="btn btn-primary btn-large">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>
