# Implementation Plan — Menyimpan Feedback ke Database + Admin Page

**Versi:** 1.2 (Draft — belum dieksekusi)
**Lampiran dari:** `docs/PRD.md`
**Status:** Menunggu perintah eksekusi

---

# 1. Konteks

Saat ini `PageController@submitFeedback()` hanya melakukan validasi lalu
redirect ke halaman sukses. Feedback hasil kiriman **tidak disimpan** sehingga
tidak ada data yang dapat diolah lebih lanjut.

Tujuan plan ini: menambahkan penyimpanan feedback ke **database (SQLite)** tanpa
mengubah requirement inti tugas (alur request → validasi → sukses) dan tetap
mengalirkan seluruh request melalui `PageController` serta route yang ada.

# 2. Pendekatan yang Dipilih

**Database via Eloquent ORM** — membuat tabel `feedbacks` melalui migration dan
model `Feedback`, lalu melakukan `Feedback::create(...)` di controller.

Alasan:

- Arsitektur Laravel standar (tugas menilai kerapian struktur kode).
- Data mudah di-query, diuji dengan factory, dan dipersiapkan untuk fitur
  admin/list di masa depan.
- Project sudah menggunakan SQLite — tanpa setup tambahan.

Alternatif yang dipertimbangkan (tidak dipilih pada versi ini):

| Opsi           | Alasan tidak dipilih                                    |
| -------------- | ------------------------------------------------------- |
| File/JSON      | Bukan arsitektur Laravel standar; sulit query & update |
| Log file       | Kurang tepat untuk data fungsional                     |
| Cache          | Penyimpanan sementara, tidak persisten                  |

# 3. Langkah Implementasi

## 3.1 Buat Migration tabel `feedbacks`

Menggunakan `php artisan make:migration create_feedbacks_table`.

Kolom (mengikuti field form):

| Kolom       | Tipe      | Constraint                     |
| ----------- | --------- | ------------------------------ |
| `id`        | bigint    | PK, auto-increment             |
| `name`      | string    | required, length 255           |
| `email`     | string    | required, length 255           |
| `category`  | string    | required, masuk whitelist      |
| `message`   | text      | required                       |
| `timestamps`| timestamp | created_at / updated_at        |

Catatan: field `captcha` **tidak** disimpan karena hanya berfungsi sebagai
verifikasi sesaat, bukan data feedback.

## 3.2 Buat Model `Feedback`

Menggunakan `php artisan make:model Feedback --factory`.

Elemen:

- `$fillable` = `['name', 'email', 'category', 'message']` (proteksi mass
  assignment).
- `casts` untuk `created_at`/`updated_at` (default Eloquent).
- Factory dengan state 3 pilihan kategori yang valid.

## 3.3 Update `PageController@submitFeedback()`

Setelah semua validasi (termasuk captcha) lolos dan sebelum redirect:

```php
Feedback::create($request->only(['name', 'email', 'category', 'message']));
session()->forget('captcha_answer'); // Hapus session captcha
```

Alur tetap:

```text
POST /feedback
      ↓
CSRF middleware
      ↓
Validasi standar (name, email, category, message, captcha)
      ↓
Validasi captcha dari session
      ↓
Feedback::create(...)   ← TAMBAHAN
      ↓
Hapus session captcha   ← TAMBAHAN
      ↓
Redirect feedback.success
```

Tidak ada perubahan pada route, view form, atau validasi.

## 3.4 Buat Feature Test

Menggunakan `php artisan make:test --phpunit FeedbackSubmissionTest`:

1. `test_valid_feedback_is_stored_in_database` — submit valid, assert record
   tersimpan di tabel `feedbacks`.
2. `test_invalid_feedback_is_not_stored` — submit dengan data invalid (mis. email
   salah), assert database tidak berubah & redirect balik ke form.
3. `test_captcha_answer_is_not_stored` — memastikan jawaban captcha tidak ikut
   tersimpan.

Test memakai factory untuk data valid dan `assertDatabaseHas`/`assertDatabaseMissing`.

# 4. Fitur Admin Page (Bonus)

Menambahkan halaman `/admin` yang dilindungi login menggunakan **Auth bawaan
Laravel** (tabel `users` sudah ada), lalu menampilkan seluruh feedback.
Controller admin **dipisah** ke `AdminController` agar `PageController` tetap
fokus ke tugas utama (konvensi: satu controller per area). Tabel `users` dan
model `User` (dengan cast `password => hashed`) sudah tersedia di project —
tidak ada tabel/migration baru untuk auth.

## 4.1 Akun Admin Tunggal (Tanpa Opsi Register)

Auth bawaan **tidak menghasilkan halaman register secara otomatis** — register
hanya ada jika kita buat route-nya. Rencana ini **tidak membuat route register**
sehingga mustahil bagi publik untuk membuat akun.

- **Seeder**: buat class `AdminSeeder` (dipanggil dari `DatabaseSeeder`) yang
  membuat tepat satu user admin:

```php
User::updateOrCreate(
    ['email' => 'admin@student.its.ac.id'],
    ['name' => 'Administrator', 'password' => 'rahasia123'],
);
```

`password` ter-hash otomatis oleh cast `hashed` pada model `User` — tidak ada
password plain text di kode.

## 4.2 Autentikasi dengan `Auth::attempt()`

- Login memakai `Auth::attempt($credentials)` — Eloquent + guard bawaan.
- `password` dibandingkan lewat bcrypt (Hash facade, via cast `hashed`).
- Login sukses → `$request->session()->regenerate()` (cegah session fixation)
  lalu redirect ke dashboard.
- Logout memakai `Auth::logout()` + `regenerate()`.
- Gagal → redirect balik dengan error "Username atau password salah."
- Middleware proteksi memakai **`auth` bawaan Laravel** (bukan custom).
- Opsional: `throttle` bawaan untuk mencegah brute-force login.

## 4.3 Route (named, tetap lewat controller)

```php
Route::get('/admin', [AdminController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
```

Semua POST didampingi `@csrf` di view. Rute dashboard dilindungi middleware
`auth` bawaan — guest yang mengakses diarahkan ke `login`.

## 4.4 Penampilan Data

`AdminController@dashboard`:

```php
$feedbacks = Feedback::latest()->get();
```

Menampilkan tabel: Nama, Email, Kategori, Pesan, Tanggal (format lokal).

## 4.5 Design (mengikuti `docs/design.md`)

- Reuse `layouts/app.blade.php` + seluruh CSS variable `--sf-*` (tone sky blue).
- **Login card**: layout kartu sama seperti form feedback (hero + kartu putih
  rounded + shadow), field `username` & `password` dengan focus ring biru.
- **Dashboard**: kartu lebar berisi tabel, header hijau/tint `--sf-blue-100`,
  tombol logout beraksen rose (`--sf-danger`).
- Konsisten dengan tanda error di bawah field (rose).

## 4.6 Feature Test Admin

1. `test_guest_cannot_access_dashboard` — redirect ke `login`.
2. `test_admin_can_login_with_valid_credentials` — `Auth::check()` true,
   redirect ke dashboard.
3. `test_admin_cannot_login_with_wrong_credentials` — error, `Auth::check()` false.
4. `test_dashboard_lists_feedback` — login (`actingAs`), buat data, assert muncul.
5. `test_admin_can_logout` — `Auth::check()` false, dashboard tak bisa diakses.

# 5. File yang Terdampak

| File                                       | Aksi       |
| ------------------------------------------ | ---------- |
| `database/migrations/<timestamp>_create_feedbacks_table.php` | Baru       |
| `app/Models/Feedback.php`                  | Baru       |
| `database/factories/FeedbackFactory.php`   | Baru       |
| `app/Http/Controllers/PageController.php`  | Modify     |
| `tests/Feature/FeedbackSubmissionTest.php` | Baru       |
| `database/database.sqlite`                 | Migrate    |
| `app/Http/Controllers/AdminController.php` | Baru       |
| `routes/web.php`                           | Modify     |
| `database/seeders/AdminSeeder.php`         | Baru       |
| `database/seeders/DatabaseSeeder.php`      | Modify     |
| `resources/views/admin/login.blade.php`    | Baru       |
| `resources/views/admin/dashboard.blade.php`| Baru       |
| `tests/Feature/AdminAuthTest.php`          | Baru       |

Tidak mengubah: tabel `users` + model `User` (sudah ada), view
`feedback/form.blade.php` / `success.blade.php`, `docs/PRD.md`.
`layouts/app.blade.php` hanya ditambah navigasi login/logout (opsional).

# 6. Perintah yang Akan Dijalankan (Saat Eksekusi)

```bash
php artisan make:migration create_feedbacks_table
php artisan make:model Feedback --factory
php artisan make:test --phpunit FeedbackSubmissionTest
php artisan make:controller AdminController
mkdir -p resources/views/admin
touch resources/views/admin/login.blade.php resources/views/admin/dashboard.blade.php
php artisan make:seeder AdminSeeder
php artisan make:test --phpunit AdminAuthTest
php artisan migrate
php artisan db:seed
php artisan test --compact
vendor/bin/pint --dirty --format agent
```

# 7. Kriteria Selesai

- [ ] Migration `create_feedbacks_table` berhasil dijalankan.
- [ ] Model `Feedback` dibuat dengan `$fillable` yang benar.
- [ ] Factory `FeedbackFactory` tersedia dengan data valid.
- [ ] `submitFeedback()` menyimpan data sebelum redirect.
- [ ] Jawaban captcha tidak ikut tersimpan.
- [ ] `AdminSeeder` membuat tepat satu akun admin dengan password ter-hash.
- [ ] Tidak ada route register; publik tidak bisa membuat akun sendiri.
- [ ] `/admin` menampilkan form login; login benar diterima (`Auth::check()` true).
- [ ] Kredensial salah ditolak dengan pesan error.
- [ ] Dashboard `/admin/dashboard` hanya bisa diakses setelah login (middleware `auth`).
- [ ] Dashboard menampilkan seluruh feedback (nama, email, kategori, pesan, tanggal).
- [ ] Logout mengakhiri sesi dan mengunci dashboard kembali.
- [ ] Design admin memakai tone `--sf-*` yang sama dengan halaman utama.
- [ ] Seluruh feature test (feedback + admin) lolos.
- [ ] Pint bersih, tanpa perubahan format.
- [ ] Rute & alur sukses existing tetap berjalan (tidak ada regression).

---

*DOKUMEN INI BELUM DIEKSEKUSI. Perubahan kode hanya akan diterapkan setelah
perintah eksekusi diberikan.*