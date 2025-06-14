<?= $this->include('template/header'); ?>

<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>

<div class="faq-section">
    <div class="faq-item">
        <h3>Apa itu CodeIgniter?</h3>
        <p>CodeIgniter adalah framework PHP yang ringan dan mudah digunakan untuk pengembangan aplikasi web.</p>
    </div>
    
    <div class="faq-item">
        <h3>Bagaimana cara menginstall CodeIgniter?</h3>
        <p>Anda dapat menginstall CodeIgniter melalui Composer dengan perintah: composer create-project codeigniter4/appstarter</p>
    </div>
    
    <div class="faq-item">
        <h3>Apa keunggulan CodeIgniter 4?</h3>
        <p>CodeIgniter 4 memiliki performa yang lebih baik, mendukung PHP 7.4+, dan memiliki fitur-fitur modern seperti namespace dan autoloading.</p>
    </div>
    
    <div class="faq-item">
        <h3>Bagaimana cara membuat controller baru?</h3>
        <p>Anda dapat membuat controller baru dengan perintah: php spark make:controller NamaController</p>
    </div>
</div>

<?= $this->include('template/footer'); ?>
