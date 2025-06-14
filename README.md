# Lab7Web - Praktikum CodeIgniter 4

Repository ini berisi hasil praktikum pemrograman web menggunakan framework CodeIgniter 4, yang mencakup pembuatan routing, controller, view, dan layout web.

## Daftar Isi
1. [Persiapan](#persiapan)
2. [Langkah 1: Membuat Routes](#langkah-1-membuat-routes)
3. [Langkah 2: Membuat Controller](#langkah-2-membuat-controller)
4. [Langkah 3: Auto Routing](#langkah-3-auto-routing)
5. [Langkah 4: Membuat View](#langkah-4-membuat-view)
6. [Langkah 5: Membuat Layout dengan CSS](#langkah-5-membuat-layout-dengan-css)
7. [Langkah 6: Melengkapi Menu Navigasi](#langkah-6-melengkapi-menu-navigasi)

## Persiapan

Sebelum memulai praktikum, pastikan:
- XAMPP sudah terinstall dan berjalan
- CodeIgniter 4 sudah terinstall di direktori `htdocs`
- PHP Spark server dapat dijalankan

### Menjalankan Server Development
```bash
php spark serve
```

Server akan berjalan di `http://localhost:8080`

## Langkah 1: Membuat Routes

### 1.1 Melihat Routes Default
Pertama, kita cek routes yang sudah ada dengan perintah:
```bash
php spark routes
```

### 1.2 Menambahkan Routes Baru
Edit file `app/Config/Routes.php` dan tambahkan routes berikut:

```php
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/artikel', 'Page::artikel');
```

### 1.3 Verifikasi Routes
Jalankan kembali perintah untuk melihat routes yang sudah ditambahkan:
```bash
php spark routes
```

**Screenshot:** Routes yang berhasil ditambahkan
![Routes](screenshots/routes.png)

## Langkah 2: Membuat Controller

### 2.1 Membuat Controller Page
Buat file `app/Controllers/Page.php` dengan isi:

```php
<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        echo "Ini halaman About";
    }

    public function contact()
    {
        echo "Ini halaman Contact";
    }

    public function faqs()
    {
        echo "Ini halaman FAQ";
    }
}
```

### 2.2 Testing Controller
Akses halaman-halaman berikut untuk memastikan controller berfungsi:
- `http://localhost:8080/about`
- `http://localhost:8080/contact`
- `http://localhost:8080/faqs`

**Screenshot:** Halaman About berhasil diakses
![About Page](screenshots/about-simple.png)

## Langkah 3: Auto Routing

### 3.1 Mengaktifkan Auto Routing
Edit file `app/Config/Routes.php` dan tambahkan:
```php
$routes->setAutoRoute(true);
```

Edit file `app/Config/Routing.php` dan ubah:
```php
public bool $autoRoute = true;
```

### 3.2 Menambahkan Method TOS
Tambahkan method baru di Controller Page:
```php
public function tos()
{
    echo "ini halaman Term of Services";
}
```

### 3.3 Testing Auto Routing
Akses halaman `http://localhost:8080/page/tos` untuk menguji auto routing.

**Screenshot:** Auto routing berfungsi
![Auto Routing](screenshots/auto-routing.png)

## Langkah 4: Membuat View

### 4.1 Membuat View About
Buat file `app/Views/about.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
</head>
<body>
    <h1><?= $title; ?></h1>
    <hr>
    <p><?= $content; ?></p>
</body>
</html>
```

### 4.2 Mengubah Method About di Controller
Update method about() di Controller Page:
```php
public function about()
{
    return view('about', [
        'title' => 'Halaman About',
        'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
    ]);
}
```

**Screenshot:** Halaman About dengan View
![About View](screenshots/about-view.png)

## Langkah 5: Membuat Layout dengan CSS

### 5.1 Membuat File CSS
Buat file `public/style.css` dengan styling untuk layout web.

### 5.2 Membuat Template Header
Buat file `app/Views/template/header.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Layout Sederhana</h1>
        </header>
        <nav>
            <a href="<?= base_url('/');?>" class="active">Home</a>
            <a href="<?= base_url('/artikel');?>">Artikel</a>
            <a href="<?= base_url('/about');?>">About</a>
            <a href="<?= base_url('/contact');?>">Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
```

### 5.3 Membuat Template Footer
Buat file `app/Views/template/footer.php` dengan sidebar dan footer.

### 5.4 Update View About
Update file `app/Views/about.php` untuk menggunakan template:
```php
<?= $this->include('template/header'); ?>

<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>

<?= $this->include('template/footer'); ?>
```

**Screenshot:** Halaman About dengan Layout CSS
![About Layout](screenshots/about-layout.png)

## Langkah 6: Melengkapi Menu Navigasi

### 6.1 Membuat View untuk Contact
Buat file `app/Views/contact.php` dengan form kontak.

### 6.2 Membuat View untuk FAQs
Buat file `app/Views/faqs.php` dengan daftar pertanyaan dan jawaban.

### 6.3 Membuat View untuk Artikel
Buat file `app/Views/artikel.php` dengan daftar artikel.

### 6.4 Update Controller Page
Update semua method di Controller Page untuk menggunakan view:

```php
public function contact()
{
    return view('contact', [
        'title' => 'Halaman Kontak',
        'content' => 'Ini adalah halaman kontak untuk menghubungi kami.'
    ]);
}

public function faqs()
{
    return view('faqs', [
        'title' => 'Frequently Asked Questions',
        'content' => 'Berikut adalah pertanyaan-pertanyaan yang sering diajukan.'
    ]);
}

public function artikel()
{
    return view('artikel', [
        'title' => 'Daftar Artikel',
        'content' => 'Berikut adalah kumpulan artikel-artikel terbaru.'
    ]);
}
```

**Screenshot:** Semua halaman dengan layout konsisten
![All Pages](screenshots/all-pages.png)

## Struktur File Akhir

```
peraktikumweb/
├── app/
│   ├── Config/
│   │   ├── Routes.php
│   │   └── Routing.php
│   ├── Controllers/
│   │   ├── Home.php
│   │   └── Page.php
│   └── Views/
│       ├── template/
│       │   ├── header.php
│       │   └── footer.php
│       ├── about.php
│       ├── contact.php
│       ├── faqs.php
│       └── artikel.php
├── public/
│   └── style.css
└── README.md
```

## Kesimpulan

Praktikum ini berhasil mendemonstrasikan:
1. ✅ Pembuatan routing di CodeIgniter 4
2. ✅ Pembuatan controller dan method
3. ✅ Penggunaan auto routing
4. ✅ Pembuatan view dengan template
5. ✅ Implementasi layout CSS yang konsisten
6. ✅ Integrasi semua komponen menjadi aplikasi web yang utuh

Semua link navigasi berfungsi dengan baik dan menggunakan layout yang konsisten.

## Cara Menjalankan

1. Clone repository ini
2. Pastikan XAMPP sudah berjalan
3. Jalankan server development:
   ```bash
   php spark serve
   ```
4. Buka browser dan akses `http://localhost:8080`

## Author
- Nama: [Nama Anda]
- NIM: [NIM Anda]
- Kelas: [Kelas Anda]