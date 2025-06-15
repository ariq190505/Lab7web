# Lab7Web - Praktikum Pemrograman Web 2
**Repository Lengkap untuk Praktikum CodeIgniter 4**

## 📚 Informasi Praktikum
- **Mata Kuliah**: Pemrograman Web 2
- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Topik**: Routing, Controller, View, CRUD, Layout & View Cell

## 📋 Daftar Modul
1. [Modul 1 - Routing & Controller](#modul-1---routing--controller)
2. [Modul 2 - CRUD Operations](#modul-2---crud-operations)
3. [Modul 3 - View Layout & View Cell](#modul-3---view-layout--view-cell)
4. [Setup & Konfigurasi](#setup--konfigurasi)
5. [Screenshots](#screenshots)

---

## 🚀 Setup & Konfigurasi

### Tools yang Digunakan
- **XAMPP** - Web server lokal dengan MySQL
- **CodeIgniter 4** - PHP Framework
- **VS Code** - Code Editor
- **phpMyAdmin** - Database management

### Menjalankan Server
```bash
php spark serve
```
Server: `http://localhost:8080`

### Struktur Project Akhir
```
peraktikumweb/
├── app/
│   ├── Controllers/
│   │   ├── Home.php
│   │   ├── Page.php
│   │   └── Artikel.php
│   ├── Models/
│   │   └── ArtikelModel.php
│   ├── Views/
│   │   ├── layout/
│   │   │   ├── main.php
│   │   │   └── admin.php
│   │   ├── components/
│   │   │   └── artikel_terkini.php
│   │   ├── artikel/
│   │   └── template/
│   ├── Cells/
│   │   └── ArtikelTerkini.php
│   └── Database/Migrations/
├── public/
│   └── style.css
└── .env
```

---

## 📖 Modul 1 - Routing & Controller

### 1.1 Membuat Controller
**File**: `app/Controllers/Page.php`
```php
<?php
namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang aplikasi ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Kontak Kami',
            'content' => 'Ini adalah halaman kontak.'
        ]);
    }
}
```

### 1.2 Konfigurasi Routing
**File**: `app/Config/Routes.php`
```php
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:segment)', 'Artikel::view/$1');
```

### 1.3 Membuat View
**File**: `app/Views/about.php`
```php
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```

**✅ Hasil**: Routing dan controller berhasil dibuat dengan navigation yang berfungsi.

---

## 🗄️ Modul 2 - CRUD Operations

### 2.1 Setup Database
**Database**: `lab_ci4`
```sql
CREATE DATABASE lab_ci4;
USE lab_ci4;

CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    kategori VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME
);
```

### 2.2 Konfigurasi Database
**File**: `.env`
```env
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### 2.3 Membuat Model
**File**: `app/Models/ArtikelModel.php`
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar', 'kategori'];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
```

### 2.4 Membuat Controller CRUD
**File**: `app/Controllers/Artikel.php`
```php
<?php
namespace App\Controllers;
use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    public function index()
    {
        $model = new ArtikelModel();
        $artikel = $model->where('status', 1)->findAll();
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'judul' => 'required|min_length[3]',
                'isi' => 'required|min_length[10]'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $artikel = new ArtikelModel();
                $artikel->insert([
                    'judul' => $this->request->getPost('judul'),
                    'isi' => $this->request->getPost('isi'),
                    'slug' => url_title($this->request->getPost('judul')),
                    'status' => $this->request->getPost('status') ?? 0
                ]);
                return redirect('admin/artikel');
            }
        }
        return view('artikel/form_add', ['title' => 'Tambah Artikel']);
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();
        if ($this->request->getMethod() === 'post') {
            // Update logic
            $artikel->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'status' => $this->request->getPost('status')
            ]);
            return redirect('admin/artikel');
        }

        $data = $artikel->find($id);
        return view('artikel/form_edit', compact('data', 'title'));
    }

    public function delete($id)
    {
        $artikel = new ArtikelModel();
        $artikel->delete($id);
        return redirect('admin/artikel');
    }
}
```

### 2.5 Routing CRUD
**File**: `app/Config/Routes.php`
```php
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:segment)', 'Artikel::view/$1');
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->get('artikel/add', 'Artikel::add');
    $routes->post('artikel/add', 'Artikel::add');
    $routes->get('artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->post('artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:num)', 'Artikel::delete/$1');
});
```

**✅ Hasil**: CRUD operations lengkap dengan Create, Read, Update, Delete.

---

## 🎨 Modul 3 - View Layout & View Cell

### 3.1 Membuat Layout Utama
**File**: `app/Views/layout/main.php`
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'My Website' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Layout Sederhana</h1>
        </header>
        <nav>
            <a href="<?= base_url('/');?>">Home</a>
            <a href="<?= base_url('/artikel');?>">Artikel</a>
            <a href="<?= base_url('/about');?>">About</a>
            <a href="<?= base_url('/contact');?>">Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content') ?>
            </section>
            <aside id="sidebar">
                <?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>
                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul>
                        <li><a href="#">Widget Link</a></li>
                        <li><a href="#">Widget Link</a></li>
                    </ul>
                </div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2021 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>
```

### 3.2 Mengubah View ke Layout Baru
**File**: `app/Views/home.php`
```php
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```

### 3.3 Membuat View Cell
**File**: `app/Cells/ArtikelTerkini.php`
```php
<?php
namespace App\Cells;
use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
    public function render($kategori = null)
    {
        $model = new ArtikelModel();
        $query = $model->where('status', 1);

        if ($kategori) {
            $query = $query->where('kategori', $kategori);
        }

        $artikel = $query->orderBy('created_at', 'DESC')->limit(5)->findAll();

        return view('components/artikel_terkini', [
            'artikel' => $artikel,
            'kategori' => $kategori
        ]);
    }
}
```

**File**: `app/Views/components/artikel_terkini.php`
```php
<h3>Artikel Terkini<?= $kategori ? ' - ' . ucfirst($kategori) : '' ?></h3>
<?php if($artikel): ?>
    <ul>
        <?php foreach ($artikel as $row): ?>
            <li>
                <a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?= $row['judul'] ?></a>
                <?php if($row['kategori']): ?>
                    <small style="color: #999;"><?= $row['kategori'] ?></small>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Belum ada artikel.</p>
<?php endif; ?>
```

### 3.4 Penggunaan View Cell
```php
// Semua artikel
<?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>

// Artikel kategori tertentu
<?= view_cell('App\\Cells\\ArtikelTerkini::render', ['kategori' => 'teknologi']) ?>
```

**✅ Hasil**: Layout yang konsisten dan komponen yang dapat digunakan ulang.

---

## 📸 Screenshots

### Daftar Artikel
![image](https://github.com/user-attachments/assets/a1c628c3-38f4-4c4b-94f4-1ce1c5f26802)
*Halaman daftar artikel dengan View Cell sidebar*

### Form Tambah Artikel
![Screenshot 2025-06-15 151209](https://github.com/user-attachments/assets/b8cc5ee2-6756-4098-972c-af0b7b31cdaa)
*Form tambah artikel dengan validasi*

---

## 🎯 Fitur yang Berhasil Diimplementasikan

### ✅ **Modul 1 - Routing & Controller**
- Routing dengan auto-routing dan manual routing
- Controller dengan multiple methods
- Navigation yang berfungsi
- Halaman About, Contact, dan Home

### ✅ **Modul 2 - CRUD Operations**
- **Create**: Tambah artikel dengan validasi
- **Read**: Tampil daftar dan detail artikel
- **Update**: Edit artikel existing
- **Delete**: Hapus artikel dengan konfirmasi
- Model dengan ORM CodeIgniter
- Database integration dengan MySQL

### ✅ **Modul 3 - View Layout & View Cell**
- Layout utama dengan extend/section pattern
- Layout admin terpisah
- View Cell untuk komponen yang dapat digunakan ulang
- Sidebar dinamis dengan artikel terkini
- Support kategori pada View Cell

### ✅ **Fitur Tambahan**
- Timestamps (created_at, updated_at)
- Kategori artikel
- Flash messages
- Form validation
- Responsive design
- Admin panel yang lengkap

---

## 🚀 Cara Menjalankan Aplikasi

### 1. **Persiapan Environment**
```bash
# Clone repository
git clone [repository-url]
cd peraktikumweb

# Pastikan XAMPP sudah running
# - Apache service: ON
# - MySQL service: ON
```

### 2. **Setup Database**
```sql
-- Buka phpMyAdmin: http://localhost/phpmyadmin
CREATE DATABASE lab_ci4;
USE lab_ci4;

CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    kategori VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME
);
```

### 3. **Konfigurasi CodeIgniter**
```bash
# Copy file .env
cp env .env

# Edit file .env dan sesuaikan konfigurasi database
```

### 4. **Menjalankan Server**
```bash
# Jalankan development server
php spark serve

# Akses: http://localhost:8080
```

### 5. **Testing URL**
- **Halaman Publik**: `http://localhost:8080`
- **Daftar Artikel**: `http://localhost:8080/artikel`
- **Admin Panel**: `http://localhost:8080/admin/artikel`
- **Tambah Artikel**: `http://localhost:8080/admin/artikel/add`

---

## 📚 Pembelajaran dan Kesimpulan

### **Konsep yang Dipelajari:**

#### **1. MVC Architecture**
- **Model**: Mengelola data dan business logic
- **View**: Menampilkan data ke user
- **Controller**: Mengatur alur aplikasi

#### **2. Routing System**
- Auto-routing untuk kemudahan development
- Manual routing untuk kontrol yang lebih baik
- Route grouping untuk admin area

#### **3. View Layout vs View Cell**
| Aspek | View Layout | View Cell |
|-------|-------------|-----------|
| **Fungsi** | Template struktur halaman | Komponen yang dapat digunakan ulang |
| **Penggunaan** | `extend/section` | `view_cell()` |
| **Scope** | Seluruh halaman | Bagian kecil halaman |
| **Data** | Dari controller | Mengambil data sendiri |

#### **4. Database Operations**
- Migration untuk perubahan struktur database
- Model dengan ORM untuk query yang mudah
- Timestamps untuk tracking perubahan data

### **Best Practices yang Diterapkan:**
- ✅ Separation of concerns
- ✅ DRY (Don't Repeat Yourself) principle
- ✅ Form validation dan security
- ✅ Responsive design
- ✅ Clean URL dengan slug
- ✅ Error handling yang baik

### **Hasil Akhir:**
Aplikasi web lengkap dengan fitur CRUD, layout yang konsisten, dan komponen yang dapat digunakan ulang. Semua modul terintegrasi dengan baik dan siap untuk pengembangan lebih lanjut.

---

## 👨‍💻 Author & Credits

**Praktikum Pemrograman Web 2**
- **Mata Kuliah**: Pemrograman Web 2
- **Dosen**: Agung Nugroho
- **Universitas**: Pelita Bangsa, Bekasi

**Mahasiswa:**
- **Nama**: [Ariq Ibtihal]
- **NIM**: [312310446]
- **Kelas**: [TI.23.A5]

---

## 📄 License

This project is created for educational purposes as part of Web Programming 2 course at Universitas Pelita Bangsa.

---

**© 2025 - Lab7Web Praktikum CodeIgniter 4**

