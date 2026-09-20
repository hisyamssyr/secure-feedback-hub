# Deskripsi Tugas: Laravel Secure Feedback Hub

## Tugas Mandiri Pertemuan 3 (Durasi 1 Minggu)

Latar Belakang: Departemen Teknik Informatika ITS membutuhkan portal terpusat untuk menampung masukan, kritik, dan gagasan akademis dari mahasiswa secara aman dan terverifikasi. Tugas Anda: Bangun aplikasi web Laravel lokal sederhana bernama 'Secure Feedback Hub'. Tujuan Praktik:

1. Mengimplementasikan alur form penanganan request POST secara terstruktur.
2. Menerapkan skema validasi server-side yang ketat untuk seluruh field formulir.
3. Memastikan tingkat keamanan tinggi terhadap serangan Cross-Site Request Forgery (CSRF).
4. Menyajikan pengalaman pengguna (UX) yang baik melalui penanganan pesan error dinamis dan old input recovery.

# Spesifikasi Teknis & Kebutuhan Fitur Tugas

## Ketentuan Fitur Wajib (Bobot 80%)

1. Arsitektur Kode: Semua penanganan request wajib dialirkan melalui satu Controller bernama PageController. Tidak diperkenankan menggunakan route closure langsung di routes/web.php.
2. Input Form: Menyediakan formulir umpan balik yang berisi field berikut:
- Nama Mahasiswa (Wajib diisi, minimal 3 karakter).
- Email (Wajib diisi, format email ITS valid yang diakhiri '@student.its.ac.id').
- Kategori Masukan (Wajib dipilih dari dropdown: Akademik, Sarana Prasarana, Kegiatan Mahasiswa).
- Isi Pesan (Wajib diisi, minimal 15 karakter).
3. Proteksi CSRF: Semua rute POST wajib diamankan dengan token CSRF.
4. Penanganan UX: Jika validasi gagal, kembalikan input lama menggunakan helper old() dan tampilkan pesan kesalahan bahasa Indonesia yang rapi di bawah masing-masing kolom.

# Tantangan Tambahan / Challenge (Nilai Plus A+)

## Fitur Ekstra untuk Mahasiswa yang Ingin Tantangan Lebih (Bobot 20%)

Tantangan 1: Dynamic Math Captcha

- Buat generator penjumlahan matematika acak (misal: 'Berapakah 5 + 7?') yang disimpan di dalam sesi (session).
- Tampilkan pertanyaan tersebut sebagai kolom verifikasi wajib di form masukan.
- Lakukan validasi server-side untuk memastikan jawaban matematika dari user benar sebelum memproses form. Jika
salah, beri pesan error kustom. Tantangan 2: Tampilan UI Modern dengan Bootstrap 5 / Tailwind CSS via CDN

- Percantik halaman formulir umpan balik dan halaman respon sukses agar responsif dan nyaman dipandang,
menerapkan estetika branding ITS.

# Kriteria Penilaian & Rubrik Evaluasi

## Bobot Penilaian Tugas Mandiri

1. Kesesuaian Fungsionalitas & Keamanan (Bobot 40%)
- Penggunaan Form POST, Named Routing, dan integrasi pengaman token CSRF secara sempurna.
2. Validasi Server-Side & Desain UX (Bobot 25%)
- Ketepatan aturan validasi, pesan kesalahan bahasa Indonesia yang rapi, dan old input recovery.
3. Kerapian Kode & Standar PSR (Bobot 15%)
- Penulisan controller terpisah (PageController), penamaan variabel yang bersih, dan kerapian struktur folder.
4. Keberhasilan Menyelesaikan Tantangan / Challenge (Bobot 10%)
- Implementasi fungsional Dynamic Math Captcha dan styling antarmuka.
5. Kualitas Presentasi & Demo Kode (Bobot 10%)
- Kemampuan menjelaskan alur logika kode Anda secara lugas dan lancar saat sesi demo kelas.