<?= $this->include('template/header'); ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']);?>" alt="<?= $artikel['judul']; ?>">
    <p><?= $artikel['isi']; ?></p>
</article>

<div class="navigation">
    <a href="<?= base_url('/artikel'); ?>" class="btn-back">← Kembali ke Daftar Artikel</a>
</div>

<?= $this->include('template/footer'); ?>
