<?= $this->include('template/header'); ?>

<h1><?= $title; ?></h1>
<p><strong>Kategori:</strong> <?= $kategori['nama_kategori']; ?></p>
<hr>

<?php if ($artikel): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
            <p>Kategori: <?= $kategori['nama_kategori']; ?></p>
            <?php if (!empty($row['gambar'])): ?>
                <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>">
            <?php endif; ?>
            <p><?= substr($row['isi'], 0, 200); ?></p>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <article class="entry">
        <h2>Belum ada artikel dalam kategori ini.</h2>
        <p><a href="<?= base_url('/artikel'); ?>">← Kembali ke semua artikel</a></p>
    </article>
<?php endif; ?>

<div class="navigation">
    <a href="<?= base_url('/artikel'); ?>" class="btn-back">← Kembali ke Semua Artikel</a>
</div>

<?= $this->include('template/footer'); ?>
