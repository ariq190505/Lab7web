<?= $this->include('template/header'); ?>

<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>

<div class="artikel-list">
    <article class="entry">
        <h2>Belajar CodeIgniter 4</h2>
        <img src="https://via.placeholder.com/200x150" alt="CodeIgniter">
        <p>CodeIgniter 4 adalah versi terbaru dari framework PHP yang populer. Dalam artikel ini, kita akan membahas fitur-fitur baru dan cara menggunakannya untuk pengembangan aplikasi web modern.</p>
        <p><strong>Tanggal:</strong> 14 Juni 2025</p>
    </article>
    
    <hr class="divider">
    
    <article class="entry">
        <h2>Membuat Layout dengan CSS</h2>
        <img src="https://via.placeholder.com/200x150" alt="CSS Layout" class="right-img">
        <p>Layout yang baik adalah kunci dari website yang menarik. Dalam artikel ini, kita akan belajar cara membuat layout responsif menggunakan CSS dan mengintegrasikannya dengan CodeIgniter.</p>
        <p><strong>Tanggal:</strong> 13 Juni 2025</p>
    </article>
    
    <hr class="divider">
    
    <article class="entry">
        <h2>Database dan Model di CodeIgniter</h2>
        <img src="https://via.placeholder.com/200x150" alt="Database">
        <p>Pengelolaan database adalah bagian penting dalam pengembangan aplikasi web. Mari pelajari cara menggunakan Model dan Query Builder di CodeIgniter 4.</p>
        <p><strong>Tanggal:</strong> 12 Juni 2025</p>
    </article>
</div>

<?= $this->include('template/footer'); ?>
