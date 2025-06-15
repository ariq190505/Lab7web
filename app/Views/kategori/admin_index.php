<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="admin-actions">
    <a href="<?= base_url('/admin/kategori/add'); ?>" class="btn btn-primary">Tambah Kategori</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Slug</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if($kategori): ?>
            <?php foreach($kategori as $row): ?>
                <tr>
                    <td><?= $row['id_kategori']; ?></td>
                    <td><?= $row['nama_kategori']; ?></td>
                    <td><?= $row['slug_kategori']; ?></td>
                    <td>
                        <a class="btn btn-secondary" href="<?= base_url('/admin/kategori/edit/' . $row['id_kategori']);?>">Ubah</a>
                        <a class="btn btn-danger" onclick="return confirm('Yakin menghapus kategori ini?');" href="<?= base_url('/admin/kategori/delete/' . $row['id_kategori']);?>">Hapus</a>
                        <a class="btn btn-info" href="<?= base_url('/kategori/' . $row['slug_kategori']);?>" target="_blank">Lihat</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Belum ada kategori.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
