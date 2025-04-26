# **🎓 Aplikasi Manajemen Data Mahasiswa**  
**Dibuat oleh Arya Wardhana**  

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)  
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)  
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.3.0-06B6D4?logo=tailwind-css&logoColor=white)  
![MVC](https://img.shields.io/badge/Pattern-MVC-brightgreen)  

---

## **🌟 Fitur Utama**

### **🛠️ Operasi Dasar**
| Fitur | Deskripsi | Teknologi |
|-------|-----------|-----------|
| **Create** | Tambah data mahasiswa lengkap | Form Validation |
| **Read** | Tampilan data dengan pagination | PHP PDO |
| **Update** | Edit semua field termasuk foto | AJAX Upload |
| **Delete** | Hapus data dengan konfirmasi | SweetAlert |

### **🔍 Pencarian & Filter**
- 🔎 Pencarian real-time (Nama, NIM, Jurusan)
- 🗂 Filter multi-kriteria (Angkatan, Jenis Kelamin)
- 🏷 Sistem tagging jurusan otomatis

### **📊 Dashboard & Analitik**
```mermaid
pie
    title Distribusi Mahasiswa
    "Teknik Informatika" : 42
    "Sistem Informasi" : 31
    "Manajemen" : 20
    "Akuntansi" : 7
```

### **🎨 Tampilan Interaktif**
- 🌙 **Dark Mode** dengan sistem penyimpanan cookie
- 📱 **Responsive Design** (Mobile, Tablet, Desktop)
- 🎚 **Sorting Data** dengan indikator visual
- 💅 **Animasi Modern** menggunakan Tailwind CSS

### **📁 Ekspor Data**
| Format | Fitur | Ikon |
|--------|-------|------|
| Excel | Export semua data dengan styling | 📊 |
| PDF | Generate laporan profesional | 📄 |
| Print | Cetak langsung dari browser | 🖨️ |

---

## **🖼️ Screenshot Aplikasi**

<div align="center">
  <img src="screenshots/dashboard-light.jpg" width="45%" alt="Dashboard Light Mode">
  <img src="screenshots/dashboard-dark.jpg" width="45%" alt="Dashboard Dark Mode">
  
  <img src="screenshots/form-edit.jpg" width="45%" alt="Form Edit Data">
  <img src="screenshots/mobile-view.jpg" width="20%" alt="Tampilan Mobile">
</div>

---

## **⚙️ Teknologi Stack**

### **Frontend**
```mermaid
graph LR
    A[HTML5] --> B[Tailwind CSS]
    B --> C[Font Awesome]
    C --> D[Chart.js]
    D --> E[Vanilla JavaScript]
```

### **Backend**
```mermaid
graph TD
    A[PHP 8.0+] --> B[PDO MySQL]
    B --> C[MVC Architecture]
    C --> D[RESTful Routing]
```

### **Keamanan**
- 🔒 Prepared Statements
- 🛡️ Input Sanitization
- 🔐 CSRF Protection
- 📛 XSS Prevention

---

## **🚀 Panduan Instalasi**

### **Prasyarat**
1. Web Server (Apache/Nginx)
2. PHP ≥ 8.0
3. MySQL ≥ 5.7
4. Composer (untuk autoloading)

### **Langkah Instalasi**
```bash
# Clone repository
git clone https://github.com/username/crud-mahasiswa.git
cd crud-mahasiswa

# Install dependencies
composer install

# Setup database
mysql -u root -p crud_mvc < database.sql

# Konfigurasi
cp config/database.example.php config/database.php
nano config/database.php
```

### **Struktur File Penting**
```
.
├── app/
│   ├── core/       # Sistem MVC
│   ├── models/     # Model database
│   └── views/      # Template tampilan
├── assets/         # CSS & JS
├── config/         # Konfigurasi
├── uploads/        # Penyimpanan file
└── public/         # Document root
```

---

## **📚 Dokumentasi API**

### **Endpoint CRUD**
```http
GET    /mahasiswa          # List semua data
POST   /mahasiswa          # Tambah data baru
GET    /mahasiswa/{id}     # Detail mahasiswa
PUT    /mahasiswa/{id}     # Update data
DELETE /mahasiswa/{id}     # Hapus data
```

### **Contoh Response**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama": "John Doe",
    "nim": "20210001",
    "jurusan": "Teknik Informatika",
    "foto": "uploads/photo_1.jpg"
  }
}
```

---

## **🛠 Troubleshooting**

| Masalah | Solusi |
|---------|--------|
| Foto tidak terupload | Cek permission folder `uploads/` |
| Export error | Install PHP extensions: mbstring, dom |
| Dark mode tidak berfungsi | Enable JavaScript di browser |
| Koneksi database gagal | Verifikasi credential di `config/database.php` |

---

## **📜 Lisensi**

MIT License © 2025 Muhammad Alhafiz Arya Wardhana

```text
Dilarang menggunakan projek ini untuk:
- Aktivitas illegal
- Plagiarisme
- Tujuan komersial tanpa izin
```

---

## **💌 Kontak & Dukungan**

<div align="center">
  <a href="mailto:email@anda.com">
    <img src="https://img.shields.io/badge/Email-D14836?style=for-the-badge&logo=gmail&logoColor=white">
  </a>
  <a href="https://github.com/username">
    <img src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white">
  </a>
  <a href="https://linkedin.com/in/username">
    <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white">
  </a>
</div>

---

**🎨 "Kode yang indah adalah seni yang fungsional"**  
**🔥 Happy Coding!** 🔥
