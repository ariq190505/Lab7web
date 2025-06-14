<h3>Artikel Terkini<?= $kategori ? ' - ' . ucfirst($kategori) : '' ?></h3>
<?php if($artikel): ?>
    <ul>
        <?php foreach ($artikel as $row): ?>
            <li>
                <a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?= $row['judul'] ?></a>
                <?php if($row['kategori']): ?>
                    <small style="color: #999; display: block;"><?= $row['kategori'] ?></small>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Belum ada artikel<?= $kategori ? ' untuk kategori ' . $kategori : '' ?>.</p>
<?php endif; ?>
