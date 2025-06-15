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
        <input type="text" id="judul" name="judul" value="<?= old('judul', $data['judul']); ?>" placeholder="Masukkan judul artikel" required>
    </p>
    <p>
        <label for="isi">Isi Artikel:</label>
        <textarea id="isi" name="isi" cols="50" rows="10" placeholder="Masukkan isi artikel"><?= old('isi', $data['isi']); ?></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori:</label>
        <select id="id_kategori" name="id_kategori" required>
            <option value="">Pilih Kategori</option>
            <?php if(isset($kategori) && !empty($kategori)): ?>
                <?php foreach($kategori as $kat): ?>
                    <option value="<?= $kat['id_kategori'] ?>"
                        <?= old('id_kategori', $data['id_kategori'] ?? '') == $kat['id_kategori'] ? 'selected' : ''; ?>>
                        <?= $kat['nama_kategori'] ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Tidak ada kategori tersedia</option>
            <?php endif; ?>
        </select>
    </p>
    <p>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="0" <?= old('status', $data['status']) == '0' ? 'selected' : ''; ?>>Draft</option>
            <option value="1" <?= old('status', $data['status']) == '1' ? 'selected' : ''; ?>>Published</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Update Artikel" class="btn btn-primary btn-large">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>
