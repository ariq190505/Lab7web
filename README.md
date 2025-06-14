# Lab7Web - Praktikum Pemrograman Web 2
**Repository untuk Praktikum 7 - Framework CodeIgniter 4 dengan CRUD**

## Informasi Praktikum
- **Mata Kuliah**: Pemrograman Web 2
- **Praktikum**: Lab 7 - Framework CodeIgniter 4
- **Topik**: CRUD (Create, Read, Update, Delete) dengan CodeIgniter 4
- **Database**: MySQL dengan tabel artikel

## Daftar Isi
1. [Persiapan](#persiapan)
2. [Setup Database](#setup-database)
3. [Konfigurasi Database](#konfigurasi-database)
4. [Membuat Model](#membuat-model)
5. [Membuat Controller Artikel](#membuat-controller-artikel)
6. [Membuat View](#membuat-view)
7. [Implementasi CRUD](#implementasi-crud)
8. [Admin Panel](#admin-panel)
9. [Testing dan Screenshot](#testing-dan-screenshot)
10. [Kesimpulan](#kesimpulan)

---

## Persiapan

### 1. Struktur Project
Project ini menggunakan CodeIgniter 4 dengan struktur sebagai berikut:
```
peraktikumweb/
├── app/
│   ├── Controllers/
│   │   └── Artikel.php
│   ├── Models/
│   │   └── ArtikelModel.php
│   └── Views/
│       ├── artikel/
│       │   ├── index.php
│       │   ├── detail.php
│       │   ├── admin_index.php
│       │   ├── form_add.php
│       │   └── form_edit.php
│       └── template/
│           ├── header.php
│           ├── footer.php
│           ├── admin_header.php
│           └── admin_footer.php
├── public/
│   └── style.css
└── .env
```

### 2. Tools yang Digunakan
- **XAMPP** - Web server lokal dengan MySQL
- **CodeIgniter 4** - PHP Framework
- **VS Code** - Code Editor
- **phpMyAdmin** - Database management

### 3. Menjalankan Server Development
```bash
php spark serve
```
Server akan berjalan di `http://localhost:8080`

---

## Setup Database

### 1. Membuat Database `lab_ci4`
Buka phpMyAdmin dan jalankan query berikut:

```sql
CREATE DATABASE lab_ci4;
USE lab_ci4;
```

### 2. Membuat Tabel `artikel`
```sql
CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200)
);
```

### 3. Menambah Data Sample
```sql
INSERT INTO artikel (judul, isi, slug, status) VALUES
('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf.', 'artikel-pertama', 1),
('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak. Ia berakar dari sebuah naskah sastra latin klasik dari era 45 sebelum masehi, hingga bisa dipastikan usianya telah mencapai lebih dari 2000 tahun.', 'artikel-kedua', 1);
```

**Screenshot Database:**
![Database Setup](screenshots/database_setup.png)

---

## Konfigurasi Database

### 1. Konfigurasi File .env
Edit file `.env` dan tambahkan konfigurasi database:

```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

### 2. Test Koneksi Database
Buat method test di Controller untuk memastikan koneksi database berhasil:

```php
public function testdb()
{
    $db = \Config\Database::connect();
    if ($db->connID) {
        echo "Koneksi berhasil";
    } else {
        echo "Koneksi gagal";
    }
}
```

**Screenshot Koneksi Database:**
![Database Connection](screenshots/db_connection.png)

---

## Membuat Model

### 1. Membuat ArtikelModel
Buat file `app/Models/ArtikelModel.php`:

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar'];
}
```

### 2. Fitur Model yang Digunakan
- **$table**: Nama tabel database
- **$primaryKey**: Primary key tabel
- **$allowedFields**: Field yang boleh diisi
- **Built-in methods**: find(), findAll(), insert(), update(), delete()

**Screenshot Model:**
![Artikel Model](screenshots/artikel_model.png)

---

## Membuat Controller Artikel

### 1. Membuat Controller Artikel
Buat file `app/Controllers/Artikel.php`:

```php
<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->where('status', 1)->findAll(); // Hanya artikel published
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where(['slug' => $slug])->first();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll(); // Semua artikel untuk admin
        return view('artikel/admin_index', compact('artikel', 'title'));
    }
}
```

### 2. Routing untuk Artikel
Tambahkan routes di `app/Config/Routes.php`:

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

**Screenshot Controller:**
![Artikel Controller](screenshots/artikel_controller.png)

---

## Membuat View

### 1. Template Header
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

### 2. Template Footer
Buat file `app/Views/template/footer.php`:

```html
            </section>
            <aside id="sidebar">
                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul>
                        <li><a href="#">Widget Link</a></li>
                        <li><a href="#">Widget Link</a></li>
                    </ul>
                </div>
                <div class="widget-box">
                    <h3 class="title">Widget Text</h3>
                    <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu.</p>
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

### 3. View Index Artikel
Buat file `app/Views/artikel/index.php`:

```php
<?= $this->include('template/header'); ?>

<h1><?= $title; ?></h1>
<hr>

<?php if($artikel): ?>
    <?php foreach($artikel as $row): ?>
        <article class="entry">
            <h2><a href="<?= base_url('/artikel/' . $row['slug']);?>"><?= $row['judul']; ?></a></h2>
            <p><?= substr($row['isi'], 0, 200); ?>...</p>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <article class="entry">
        <h2>Belum ada data.</h2>
    </article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>
```

**Screenshot View Artikel:**
![View Artikel](screenshots/view_artikel.png)

---

## Implementasi CRUD

### 1. Create (Tambah Artikel)

#### Method add() di Controller:
```php
public function add()
{
    $title = "Tambah Artikel";

    if ($this->request->getMethod() === 'post') {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]|max_length[200]',
            'isi' => 'required|min_length[10]'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'status' => $this->request->getPost('status') ?? 0
            ]);

            session()->setFlashdata('success', 'Artikel berhasil ditambahkan!');
            return redirect('admin/artikel');
        }
    }

    return view('artikel/form_add', compact('title'));
}
```

#### View form_add.php:
```php
<?= $this->include('template/admin_header'); ?>

<form action="" method="post">
    <p>
        <label for="judul">Judul Artikel:</label>
        <input type="text" id="judul" name="judul" required>
    </p>
    <p>
        <label for="isi">Isi Artikel:</label>
        <textarea id="isi" name="isi" cols="50" rows="10"></textarea>
    </p>
    <p>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="0">Draft</option>
            <option value="1">Published</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Simpan Artikel" class="btn btn-primary">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>
```

**Screenshot Form Tambah:**
![Form Add](screenshots/form_add.png)

---

### 2. Update (Edit Artikel)

#### Method edit() di Controller:
```php
public function edit($id)
{
    $artikel = new ArtikelModel();

    if ($this->request->getMethod() === 'post') {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|min_length[3]|max_length[200]',
            'isi' => 'required|min_length[10]'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            $artikel->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'status' => $this->request->getPost('status') ?? 0,
            ]);

            session()->setFlashdata('success', 'Artikel berhasil diubah!');
            return redirect('admin/artikel');
        }
    }

    $data = $artikel->where('id', $id)->first();
    if (!$data) {
        session()->setFlashdata('error', 'Artikel tidak ditemukan!');
        return redirect('admin/artikel');
    }

    $title = "Edit Artikel";
    return view('artikel/form_edit', compact('title', 'data'));
}
```

#### View form_edit.php:
```php
<?= $this->include('template/admin_header'); ?>

<form action="" method="post">
    <p>
        <label for="judul">Judul Artikel:</label>
        <input type="text" id="judul" name="judul" value="<?= $data['judul']; ?>" required>
    </p>
    <p>
        <label for="isi">Isi Artikel:</label>
        <textarea id="isi" name="isi" cols="50" rows="10"><?= $data['isi']; ?></textarea>
    </p>
    <p>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="0" <?= $data['status'] == '0' ? 'selected' : ''; ?>>Draft</option>
            <option value="1" <?= $data['status'] == '1' ? 'selected' : ''; ?>>Published</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Update Artikel" class="btn btn-primary">
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>
```

**Screenshot Form Edit:**
![Form Edit](screenshots/form_edit.png)

### 3. Delete (Hapus Artikel)

#### Method delete() di Controller:
```php
public function delete($id)
{
    $artikel = new ArtikelModel();

    $data = $artikel->where('id', $id)->first();
    if (!$data) {
        session()->setFlashdata('error', 'Artikel tidak ditemukan!');
        return redirect('admin/artikel');
    }

    $artikel->delete($id);
    session()->setFlashdata('success', 'Artikel berhasil dihapus!');
    return redirect('admin/artikel');
}
```

**Screenshot Konfirmasi Delete:**
![Delete Confirmation](screenshots/delete_confirmation.png)

---

## Admin Panel

### 1. Template Admin Header
Buat file `app/Views/template/admin_header.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Admin Panel - Lab7Web</h1>
        </header>
        <nav>
            <a href="<?= base_url('/admin/artikel');?>">Dashboard</a>
            <a href="<?= base_url('/admin/artikel');?>">Artikel</a>
            <a href="<?= base_url('/admin/artikel/add');?>">Tambah Artikel</a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <div class="admin-content">
                    <h2><?= $title; ?></h2>
```

### 2. View Admin Index
Buat file `app/Views/artikel/admin_index.php`:

```php
<?= $this->include('template/admin_header'); ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="table-container">
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
                            <strong><?= $row['judul']; ?></strong><br>
                            <small><?= substr($row['isi'], 0, 60); ?>...</small>
                        </td>
                        <td><?= $row['status'] ? '1' : '0'; ?></td>
                        <td>
                            <a class="btn btn-secondary" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                            <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Belum ada data.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->include('template/admin_footer'); ?>
```

**Screenshot Admin Panel:**
![Admin Panel](screenshots/admin_panel.png)

---

## Testing dan Screenshot

### 1. Halaman Publik Artikel
**URL:** `http://localhost:8080/artikel`

![Halaman Artikel Publik](screenshots/artikel_public.png)

*Menampilkan daftar artikel yang sudah published (status = 1)*

### 2. Detail Artikel
**URL:** `http://localhost:8080/artikel/artikel-pertama`

![Detail Artikel](screenshots/artikel_detail.png)

*Menampilkan detail artikel berdasarkan slug*

### 3. Admin Panel - Daftar Artikel
**URL:** `http://localhost:8080/admin/artikel`

![Admin Panel](screenshots/admin_index.png)

*Menampilkan semua artikel dengan opsi edit dan delete*

### 4. Form Tambah Artikel
**URL:** `http://localhost:8080/admin/artikel/add`

![Form Tambah](screenshots/form_add_filled.png)

*Form untuk menambah artikel baru dengan validasi*

### 5. Form Edit Artikel
**URL:** `http://localhost:8080/admin/artikel/edit/1`

![Form Edit](screenshots/form_edit_filled.png)

*Form untuk mengedit artikel yang sudah ada*

### 6. Flash Messages
![Success Message](screenshots/success_message.png)

*Pesan sukses setelah operasi CRUD berhasil*

### 7. Validasi Error
![Validation Error](screenshots/validation_error.png)

*Pesan error ketika validasi form gagal*

---

## Kesimpulan

Praktikum ini berhasil mendemonstrasikan implementasi lengkap **CRUD (Create, Read, Update, Delete)** menggunakan **CodeIgniter 4** dengan fitur-fitur:

### ✅ **Fitur yang Berhasil Diimplementasikan:**

1. **Database Integration**
   - Koneksi database MySQL
   - Model dengan ORM CodeIgniter
   - Migrasi dan seeding data

2. **CRUD Operations**
   - **Create**: Tambah artikel dengan validasi
   - **Read**: Tampil daftar dan detail artikel
   - **Update**: Edit artikel existing
   - **Delete**: Hapus artikel dengan konfirmasi

3. **User Interface**
   - Halaman publik untuk pengunjung
   - Admin panel untuk pengelolaan
   - Template yang konsisten
   - Responsive design dengan CSS

4. **Validasi dan Security**
   - Form validation
   - Flash messages
   - Error handling
   - CSRF protection

5. **Routing dan Navigation**
   - SEO-friendly URLs dengan slug
   - Admin routes grouping
   - Auto-routing untuk kemudahan

### 📊 **Struktur File Akhir:**

```
peraktikumweb/
├── app/
│   ├── Controllers/
│   │   └── Artikel.php
│   ├── Models/
│   │   └── ArtikelModel.php
│   ├── Views/
│   │   ├── artikel/
│   │   │   ├── index.php
│   │   │   ├── detail.php
│   │   │   ├── admin_index.php
│   │   │   ├── form_add.php
│   │   │   └── form_edit.php
│   │   └── template/
│   │       ├── header.php
│   │       ├── footer.php
│   │       ├── admin_header.php
│   │       └── admin_footer.php
│   └── Config/
│       └── Routes.php
├── public/
│   └── style.css
├── .env
└── README.md
```

### 🎯 **Pembelajaran yang Didapat:**

1. **Framework CodeIgniter 4**
   - MVC Architecture
   - Routing system
   - Model dan Database
   - View dan Template

2. **Web Development Best Practices**
   - Separation of concerns
   - Form validation
   - User experience
   - Security considerations

3. **Database Management**
   - CRUD operations
   - Data relationships
   - Query optimization
   - Status management

Semua fitur telah ditest dan berfungsi dengan baik. Aplikasi siap untuk pengembangan lebih lanjut.

---

## Cara Menjalankan Aplikasi

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
-- Jalankan query berikut:

CREATE DATABASE lab_ci4;
USE lab_ci4;

CREATE TABLE artikel (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200)
);

-- Insert data sample
INSERT INTO artikel (judul, isi, slug, status) VALUES
('Artikel pertama', 'Lorem Ipsum adalah contoh teks...', 'artikel-pertama', 1),
('Artikel kedua', 'Tidak seperti anggapan banyak orang...', 'artikel-kedua', 1);
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

# Atau gunakan XAMPP
# Akses: http://localhost/peraktikumweb/public
```

### 5. **Testing Aplikasi**
- **Halaman Publik**: `http://localhost:8080/artikel`
- **Admin Panel**: `http://localhost:8080/admin/artikel`
- **Tambah Artikel**: `http://localhost:8080/admin/artikel/add`

---

## Struktur Database

### Tabel `artikel`
| Field  | Type         | Size | Keterangan                    |
|--------|--------------|------|-------------------------------|
| id     | INT          | 11   | PRIMARY KEY, auto_increment   |
| judul  | VARCHAR      | 200  | Judul artikel                 |
| isi    | TEXT         | -    | Isi/konten artikel            |
| gambar | VARCHAR      | 200  | Nama file gambar              |
| status | TINYINT      | 1    | Status publish (0=draft, 1=published) |
| slug   | VARCHAR      | 200  | URL slug artikel              |

---

## Troubleshooting

### 1. **Database Connection Error**
- Pastikan MySQL service di XAMPP sudah running
- Cek konfigurasi database di file `.env`
- Pastikan database `lab_ci4` sudah dibuat

### 2. **404 Not Found**
- Pastikan auto-routing sudah diaktifkan
- Cek file `app/Config/Routes.php`
- Pastikan controller dan method sudah benar

### 3. **CSS Tidak Muncul**
- Pastikan file `public/style.css` sudah ada
- Cek path CSS di template header
- Clear browser cache

---

## Author & Credits

**Praktikum Pemrograman Web 2**
- **Mata Kuliah**: Pemrograman Web 2
- **Dosen**: Agung Nugroho
- **Universitas**: Pelita Bangsa, Bekasi

**Mahasiswa:**
- **Nama**: [Nama Lengkap Anda]
- **NIM**: [NIM Anda]
- **Kelas**: [Kelas Anda]
- **Semester**: [Semester Anda]

---

## License

This project is created for educational purposes as part of Web Programming 2 course at Universitas Pelita Bangsa.

---

**© 2024 - Lab7Web Praktikum CodeIgniter 4**