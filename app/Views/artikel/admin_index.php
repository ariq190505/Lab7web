<?= $this->include('template/admin_header'); ?>

<div class="admin-actions">
    <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-primary">
        <i class="icon-plus"></i> Tambah Artikel Baru
    </a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-title">Judul Artikel</th>
                <th class="col-status">Status</th>
                <th class="col-actions">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if($artikel): ?>
                <?php foreach($artikel as $row): ?>
                    <tr>
                        <td class="col-id"><?= $row['id']; ?></td>
                        <td class="col-title">
                            <div class="article-title"><?= $row['judul']; ?></div>
                            <p class="article-excerpt"><?= substr($row['isi'], 0, 80); ?>...</p>
                            <small style="color: #999;">Slug: <?= $row['slug']; ?></small>
                        </td>
                        <td class="col-status">
                            <span class="status-badge <?= $row['status'] ? 'status-published' : 'status-draft'; ?>">
                                <?= $row['status'] ? 'Published' : 'Draft'; ?>
                            </span>
                        </td>
                        <td class="col-actions">
                            <div class="table-actions">
                                <a class="btn btn-info btn-sm" href="<?= base_url('/artikel/' . $row['slug']);?>" target="_blank" title="Lihat Artikel">
                                    Lihat
                                </a>
                                <a class="btn btn-warning btn-sm" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>" title="Edit Artikel">
                                    Edit
                                </a>
                                <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus artikel: <?= addslashes($row['judul']); ?>?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>" title="Hapus Artikel">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center" style="padding: 40px;">
                        <div style="color: #6c757d;">
                            <h4>Belum ada artikel</h4>
                            <p>Mulai dengan menambahkan artikel pertama Anda.</p>
                            <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-primary">Tambah Artikel</a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($artikel): ?>
<div class="table-info">
    <small class="text-muted">
        Total: <?= count($artikel); ?> artikel |
        Published: <?= count(array_filter($artikel, function($item) { return $item['status'] == 1; })); ?> |
        Draft: <?= count(array_filter($artikel, function($item) { return $item['status'] == 0; })); ?>
    </small>
</div>
<?php endif; ?>

<?= $this->include('template/admin_footer'); ?>
