<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<!-- Search and Filter Form -->
<div class="search-filter-container" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
    <form method="get" action="<?= base_url('/admin/artikel') ?>">
        <div style="display: flex; gap: 10px; align-items: end;">
            <div>
                <label for="q">Cari Artikel:</label>
                <input type="text" id="q" name="q" value="<?= esc($q) ?>" placeholder="Masukkan kata kunci..." style="padding: 5px;">
            </div>
            <div>
                <label for="kategori_id">Filter Kategori:</label>
                <select id="kategori_id" name="kategori_id" style="padding: 5px;">
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
            <div>
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="<?= base_url('/admin/artikel') ?>" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-title">Judul</th>
                <th class="col-kategori">Kategori</th>
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
                        <td class="col-kategori">
                            <?= $row['nama_kategori'] ?? '<em>No Category</em>'; ?>
                        </td>
                        <td class="col-status">
                            <span class="status-badge <?= $row['status'] ? 'published' : 'draft' ?>">
                                <?= $row['status'] ? 'Published' : 'Draft'; ?>
                            </span>
                        </td>
                        <td class="col-actions">
                            <a class="btn btn-secondary" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                            <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
                            <a class="btn btn-info" href="<?= base_url('/artikel/' . $row['slug']);?>" target="_blank">Lihat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">
                        <?php if($q || $kategori_id): ?>
                            Tidak ada artikel yang sesuai dengan pencarian.
                        <?php else: ?>
                            Belum ada data artikel.
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if(isset($pager)): ?>
    <div class="pagination-container" style="margin-top: 20px; text-align: center;">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<!-- Search Results Info -->
<?php if($q || $kategori_id): ?>
    <div class="search-info" style="margin-top: 15px; padding: 10px; background: #e9ecef; border-radius: 5px;">
        <strong>Filter aktif:</strong>
        <?php if($q): ?>
            Pencarian: "<?= esc($q) ?>"
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
            <?= $q ? ' | ' : '' ?>Kategori: "<?= $selectedKategori ?>"
        <?php endif; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
