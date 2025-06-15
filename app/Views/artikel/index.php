<?= $this->include('template/header'); ?>

<div class="artikel-header">
    <h1><?= $title; ?></h1>

    <!-- Search and Filter Form -->
    <div class="search-filter-form">
        <form method="get" action="<?= base_url('/artikel') ?>">
            <div class="search-row">
                <div class="search-input">
                    <input type="text" name="q" value="<?= esc($q) ?>" placeholder="Cari artikel..." class="form-control">
                </div>
                <div class="category-select">
                    <select name="kategori_id" class="form-control">
                        <option value="">Semua Kategori</option>
                        <?php if(isset($kategori) && !empty($kategori)): ?>
                            <?php foreach($kategori as $kat): ?>
                                <option value="<?= $kat['id_kategori'] ?>" <?= $kategori_id == $kat['id_kategori'] ? 'selected' : '' ?>>
                                    <?= $kat['nama_kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="search-buttons">
                    <button type="submit" class="btn btn-primary">🔍 Cari</button>
                    <a href="<?= base_url('/artikel') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Search Results Info -->
    <?php if($q || $kategori_id): ?>
        <div class="search-info">
            <strong>Filter aktif:</strong>
            <?php if($q): ?>
                Pencarian: "<em><?= esc($q) ?></em>"
            <?php endif; ?>
            <?php if($kategori_id): ?>
                <?php
                $selectedKategori = '';
                if(isset($kategori)) {
                    foreach($kategori as $kat) {
                        if($kat['id_kategori'] == $kategori_id) {
                            $selectedKategori = $kat['nama_kategori'];
                            break;
                        }
                    }
                }
                ?>
                <?= $q ? ' | ' : '' ?>Kategori: "<em><?= $selectedKategori ?></em>"
            <?php endif; ?>
            | <strong><?= count($artikel) ?></strong> artikel ditemukan
        </div>
    <?php endif; ?>
</div>

<hr>

<?php if ($artikel && count($artikel) > 0): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
            <div class="article-meta">
                <span class="kategori-badge">📁 <?= $row['nama_kategori'] ?? 'Tidak ada kategori' ?></span>
                <?php if (isset($row['created_at'])): ?>
                    <span class="date-badge">📅 <?= date('d M Y', strtotime($row['created_at'])); ?></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($row['gambar'])): ?>
                <div class="article-image">
                    <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>" style="max-width: 300px; height: auto;">
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
            <?php if($q || $kategori_id): ?>
                <h2>🔍 Tidak ada artikel yang sesuai</h2>
                <p>Tidak ditemukan artikel yang sesuai dengan pencarian Anda.</p>
                <div class="suggestions">
                    <h3>Saran:</h3>
                    <ul>
                        <li>Coba kata kunci yang berbeda</li>
                        <li>Pilih kategori yang berbeda</li>
                        <li><a href="<?= base_url('/artikel') ?>">Lihat semua artikel</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <h2>Belum ada artikel.</h2>
                <p>Belum ada artikel yang dipublikasikan.</p>
            <?php endif; ?>
        </article>
    </div>
<?php endif; ?>

<?= $this->include('template/footer'); ?>
