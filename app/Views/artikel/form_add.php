<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <p>
        <label for="judul">Judul Artikel:</label>
        <input type="text" id="judul" name="judul" placeholder="Masukkan judul artikel" required value="<?= old('judul'); ?>">
    </p>
    <p>
        <label for="isi">Isi Artikel:</label>
        <textarea id="isi" name="isi" cols="50" rows="10" placeholder="Masukkan isi artikel"><?= old('isi'); ?></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori:</label>
        <select id="id_kategori" name="id_kategori" required>
            <?php if(isset($kategori_list)): ?>
                <?php foreach($kategori_list as $id => $nama): ?>
                    <option value="<?= $id ?>" <?= old('id_kategori') == $id ? 'selected' : ''; ?>><?= $nama ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Tidak ada kategori</option>
            <?php endif; ?>
        </select>
    </p>
    <p>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="0" <?= old('status') == '0' ? 'selected' : ''; ?>>Draft</option>
            <option value="1" <?= old('status') == '1' ? 'selected' : ''; ?>>Published</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Simpan Artikel" class="btn btn-primary btn-large">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->endSection() ?>
