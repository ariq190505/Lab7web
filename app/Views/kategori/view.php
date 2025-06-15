<?= $this->include('template/header'); ?>

<div class="kategori-header">
    <h1><?= $title; ?></h1>
    <p class="kategori-description">
        <strong>Kategori:</strong> <?= $kategori['nama_kategori']; ?>
        <?php if ($artikel): ?>
            | <em><?= count($artikel); ?> artikel ditemukan</em>
        <?php endif; ?>
    </p>
</div>
<hr>

<?php if ($artikel && count($artikel) > 0): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
            <div class="article-meta">
                <span class="kategori-badge">📁 <?= $kategori['nama_kategori']; ?></span>
                <?php if (isset($row['created_at'])): ?>
                    <span class="date-badge">📅 <?= date('d M Y', strtotime($row['created_at'])); ?></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($row['gambar'])): ?>
                <div class="article-image">
                    <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>" style="max-width: 100%; height: auto;">
                </div>
            <?php endif; ?>
            <div class="article-excerpt">
                <p><?= substr($row['isi'], 0, 200); ?>...</p>
                <a href="<?= base_url('/artikel/' . $row['slug']); ?>" class="read-more">Baca selengkapnya →</a>
            </div>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-articles">
        <article class="entry">
            <h2>🔍 Belum ada artikel dalam kategori ini</h2>
            <p>Kategori <strong><?= $kategori['nama_kategori']; ?></strong> belum memiliki artikel yang dipublikasikan.</p>
            <div class="suggestions">
                <h3>Saran:</h3>
                <ul>
                    <li><a href="<?= base_url('/artikel'); ?>">Lihat semua artikel</a></li>
                    <li><a href="<?= base_url('/'); ?>">Kembali ke halaman utama</a></li>
                    <li>Coba kategori lain di sidebar →</li>
                </ul>
            </div>
        </article>
    </div>
<?php endif; ?>

<div class="navigation" style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
    <a href="<?= base_url('/artikel'); ?>" class="btn-back" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">← Kembali ke Semua Artikel</a>
    <a href="<?= base_url('/'); ?>" class="btn-home" style="display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">🏠 Halaman Utama</a>
</div>

<?= $this->include('template/footer'); ?>
