<?= $this->include('template/admin_header'); ?>

<div class="admin-actions">
    <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-primary">Tambah Artikel</a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-title">Judul</th>
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
                            <strong><?= $row['judul']; ?></strong><br>
                            <small style="color: #666;"><?= substr($row['isi'], 0, 60); ?>...</small>
                        </td>
                        <td class="col-status">
                            <?= $row['status'] ? '1' : '0'; ?>
                        </td>
                        <td class="col-actions">
                            <a class="btn btn-secondary" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                            <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Belum ada data.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->include('template/admin_footer'); ?>
