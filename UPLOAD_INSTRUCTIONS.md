# Instruksi Upload ke GitHub

## Langkah-langkah untuk Upload Repository Lab7Web ke GitHub:

### 1. Buat Repository Baru di GitHub
1. Login ke GitHub.com
2. Klik tombol "New" atau "+" di pojok kanan atas
3. Beri nama repository: **Lab7Web**
4. Pilih "Public" repository
5. **JANGAN** centang "Initialize this repository with a README"
6. Klik "Create repository"

### 2. Connect Local Repository ke GitHub
Jalankan perintah berikut di terminal (di direktori project):

```bash
# Tambahkan remote origin
git remote add origin https://github.com/USERNAME/Lab7Web.git

# Ganti USERNAME dengan username GitHub Anda
# Contoh: git remote add origin https://github.com/johndoe/Lab7Web.git
```

### 3. Push ke GitHub
```bash
# Push ke branch main
git branch -M main
git push -u origin main
```

### 4. Verifikasi Upload
1. Refresh halaman repository di GitHub
2. Pastikan semua file sudah terupload
3. Cek apakah README.md tampil dengan baik

### 5. Tambahkan Screenshot
1. Ambil screenshot sesuai instruksi di `screenshots/README.md`
2. Upload screenshot ke direktori `screenshots/`
3. Commit dan push perubahan:

```bash
git add screenshots/
git commit -m "Menambahkan screenshot praktikum"
git push origin main
```

### 6. Update README (Opsional)
Jika perlu, update README.md dengan informasi tambahan:
- Nama lengkap
- NIM
- Kelas
- Link demo (jika ada)

```bash
git add README.md
git commit -m "Update informasi mahasiswa di README"
git push origin main
```

## Troubleshooting

### Jika ada error "remote origin already exists":
```bash
git remote remove origin
git remote add origin https://github.com/USERNAME/Lab7Web.git
```

### Jika diminta username/password:
- Gunakan Personal Access Token sebagai password
- Atau setup SSH key untuk autentikasi

### Jika ada conflict:
```bash
git pull origin main --allow-unrelated-histories
git push origin main
```

## Hasil Akhir

Setelah berhasil upload, repository GitHub Anda akan berisi:
- ✅ Semua file CodeIgniter 4
- ✅ Controller Page yang lengkap
- ✅ Views dengan template
- ✅ CSS styling
- ✅ README.md yang dokumentatif
- ✅ Screenshot praktikum
- ✅ Commit history yang rapi

Repository siap untuk dikumpulkan sebagai laporan praktikum!
