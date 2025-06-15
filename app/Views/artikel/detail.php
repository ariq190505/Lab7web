<?= $this->include('template/header'); ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <?php if (isset($artikel['nama_kategori'])): ?>
        <p><strong>Kategori:</strong> <?= $artikel['nama_kategori']; ?></p>
    <?php endif; ?>
    <?php if (!empty($artikel['gambar'])): ?>
        <img src="<?= base_url('/gambar/' . $artikel['gambar']);?>" alt="<?= $artikel['judul']; ?>">
    <?php endif; ?>
    <p><?= $artikel['isi']; ?></p>
</article>

<div class="navigation">
    <a href="<?= base_url('/artikel'); ?>" class="btn-back">← Kembali ke Daftar Artikel</a>
</div>

<?= $this->include('template/footer'); ?>
