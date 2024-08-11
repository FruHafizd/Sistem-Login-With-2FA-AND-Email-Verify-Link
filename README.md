

### Sistem Login dengan Verifikasi Email dan 2FA (Two-Factor Authentication)

Proyek ini mengimplementasikan sistem login yang aman dengan dua lapisan verifikasi, yaitu verifikasi email dan autentikasi dua faktor (2FA) menggunakan QR code. Sistem ini dirancang untuk meningkatkan keamanan akun pengguna dengan memastikan bahwa hanya pemilik sah yang dapat mengakses akun mereka.

#### Fitur Utama:
1. **Verifikasi Email:**
   - Setelah pendaftaran, pengguna akan menerima email verifikasi untuk mengaktifkan akun mereka.
   - Email ini berisi tautan unik yang harus diklik oleh pengguna untuk memverifikasi kepemilikan email tersebut.
   - Proses ini mencegah penggunaan email palsu dan memastikan bahwa pengguna dapat menerima komunikasi penting dari sistem.

2. **Autentikasi Dua Faktor (2FA):**
   - Selain verifikasi email, pengguna juga dapat mengaktifkan 2FA sebagai langkah keamanan tambahan.
   - Sistem ini menggunakan standar TOTP (Time-based One-Time Password), di mana pengguna harus memindai QR code yang disediakan untuk menghubungkan aplikasi autentikator seperti Google Authenticator atau Authy dengan akun mereka.
   - Setiap kali login, pengguna harus memasukkan kode yang dihasilkan oleh aplikasi autentikator selain kredensial standar (username dan password).
   - Hal ini memastikan bahwa meskipun kredensial utama (username/password) dicuri, akun tetap terlindungi oleh lapisan keamanan kedua.

3. **Manajemen QR Code:**
   - Pengguna dapat mengakses dan memindai QR code dari halaman profil mereka untuk mengaktifkan 2FA.
   - QR code ini dikaitkan dengan TOTP secret key yang disimpan aman di server, sehingga kode yang dihasilkan oleh aplikasi autentikator selalu sinkron dengan server.

4. **Pengaturan dan Pengelolaan 2FA:**
   - Pengguna memiliki opsi untuk menonaktifkan 2FA dari pengaturan akun mereka jika tidak lagi diperlukan.
   - TOTP secret key disimpan secara permanen untuk memastikan kode yang dihasilkan oleh aplikasi autentikator tetap valid meskipun halaman direfresh.

#### Keuntungan:
- **Keamanan Ganda:** Kombinasi verifikasi email dan 2FA membuat akun lebih sulit untuk diretas.
- **Kenyamanan Pengguna:** Dengan integrasi QR code, mengaktifkan 2FA menjadi mudah dan cepat.
- **Fleksibilitas:** Pengguna dapat memilih apakah ingin mengaktifkan atau menonaktifkan 2FA sesuai kebutuhan.

#### Teknologi yang Digunakan:
- **Backend:** PHP
- **Autentikasi:** Authentication, TOTP
- **Database:** MySQL/MariaDB
- **Library Pihak Ketiga:** Authenticator, QR Code Generator, Google Captcha



---
