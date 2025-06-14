<?= $this->include('template/admin_header'); ?>

<div class="admin-actions">
    <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-primary">Tambah Artikel Baru</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if($artikel): ?>
            <?php foreach($artikel as $row): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td>
                        <b><?= $row['judul']; ?></b>
                        <p><small><?= substr($row['isi'], 0, 50); ?>...</small></p>
                    </td>
                    <td>
                        <span class="status-badge <?= $row['status'] ? 'status-published' : 'status-draft'; ?>">
                            <?= $row['status'] ? 'Published' : 'Draft'; ?>
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-sm" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
                        <a class="btn btn-info btn-sm" href="<?= base_url('/artikel/' . $row['slug']);?>" target="_blank">Lihat</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Belum ada data artikel.</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </tfoot>
</table>

<?= $this->include('template/admin_footer'); ?>
