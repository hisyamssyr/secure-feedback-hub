# Product Requirements Document (PRD)

## Laravel Secure Feedback Hub

**Versi:** 1.0
**Jenis:** Tugas Mandiri Pertemuan 3
**Platform:** Web
**Framework:** Laravel
**Environment:** Local Development
**Target Pengguna:** Mahasiswa Teknik Informatika ITS
**Durasi Pengerjaan:** 1 minggu

---

# 1. Ringkasan Project

**Secure Feedback Hub** adalah aplikasi web sederhana berbasis Laravel yang digunakan mahasiswa Teknik Informatika ITS untuk mengirimkan masukan, kritik, dan gagasan akademis secara terstruktur.

Project ini berfokus pada implementasi fundamental Laravel, khususnya:

* Request `POST`
* Controller
* Named Route
* Server-side validation
* CSRF protection
* Session
* Old input recovery
* Dynamic validation error
* Dynamic Math Captcha
* Responsive UI

Aplikasi tidak membutuhkan database pada versi tugas dasar. Fokus utama adalah **alur request → validation → response** dan penerapan keamanan pada form.

---

# 2. Tujuan Project

## 2.1 Tujuan Utama

Membangun aplikasi Laravel lokal yang mampu menerima feedback mahasiswa melalui form dengan validasi dan proteksi keamanan yang benar.

## 2.2 Tujuan Pembelajaran

Setelah project selesai, mahasiswa diharapkan mampu:

1. Membuat route Laravel dengan struktur yang benar.
2. Mengarahkan request melalui `PageController`.
3. Menangani request `POST`.
4. Menerapkan validasi server-side.
5. Menerapkan CSRF protection.
6. Menggunakan `old()` untuk mempertahankan input.
7. Menggunakan session untuk menyimpan data sementara.
8. Membuat validasi custom menggunakan Dynamic Math Captcha.
9. Membuat UI form yang responsif.

---

# 3. Scope

## 3.1 In Scope

Aplikasi wajib memiliki:

* Halaman form feedback.
* Form dengan empat field utama.
* Validasi server-side.
* CSRF protection.
* Error message berbahasa Indonesia.
* Old input recovery.
* Halaman sukses setelah submit.
* Dynamic Math Captcha.
* Responsive UI.
* Semua request ditangani melalui `PageController`.

## 3.2 Out of Scope

Fitur berikut tidak diperlukan:

* Login/register.
* Database.
* Admin dashboard.
* CRUD feedback.
* Email notification.
* File upload.
* REST API.
* Role management.
* Authentication.
* Real-time notification.

Versi pertama cukup mensimulasikan proses penerimaan feedback dan menampilkan hasil submit.

---

# 4. Target User

### Primary User

Mahasiswa Teknik Informatika ITS.

### User Journey

```text
User membuka halaman feedback
        ↓
User mengisi form
        ↓
User menjawab Math Captcha
        ↓
User menekan "Kirim Feedback"
        ↓
Laravel menerima POST request
        ↓
CSRF validation
        ↓
Server-side validation
        ↓
Jika gagal → kembali ke form + error + old input
        ↓
Jika berhasil → halaman sukses
```

---

# 5. Functional Requirements

## FR-01 — Feedback Form

Sistem harus menyediakan halaman form feedback pada:

```text
GET /
```

Form harus memiliki field berikut:

| Field            | Type        | Required | Validation                                                 |
| ---------------- | ----------- | -------: | ---------------------------------------------------------- |
| Nama Mahasiswa   | text        |      Yes | Minimal 3 karakter                                         |
| Email            | email       |      Yes | Format email valid + harus berakhiran `@student.its.ac.id` |
| Kategori Masukan | select      |      Yes | Hanya 3 pilihan valid                                      |
| Isi Pesan        | textarea    |      Yes | Minimal 15 karakter                                        |
| Jawaban Captcha  | number/text |      Yes | Harus sesuai dengan soal                                   |

Pilihan kategori:

```text
Akademik
Sarana Prasarana
Kegiatan Mahasiswa
```

---

# 6. Route Requirements

Semua route harus menggunakan **named route**.

Tidak boleh menggunakan route closure pada `routes/web.php`.

## Route yang diperlukan

### GET `/`

Menampilkan halaman form.

Controller:

```php
PageController
```

Method:

```php
showFeedbackForm()
```

Name:

```text
feedback.form
```

---

### POST `/feedback`

Memproses submission form.

Controller:

```php
PageController
```

Method:

```php
submitFeedback()
```

Name:

```text
feedback.submit
```

---

### GET `/feedback/success`

Menampilkan halaman sukses setelah feedback berhasil dikirim.

Controller:

```php
PageController
```

Method:

```php
feedbackSuccess()
```

Name:

```text
feedback.success
```

---

# 7. Controller Requirements

Seluruh logic request harus ditangani melalui:

```text
app/Http/Controllers/PageController.php
```

Minimal memiliki method:

```php
showFeedbackForm()
submitFeedback()
feedbackSuccess()
```

Tidak boleh membuat controller lain untuk kebutuhan utama tugas.

Controller bertanggung jawab terhadap:

1. Menampilkan form.
2. Membuat Dynamic Math Captcha.
3. Memproses POST request.
4. Melakukan server-side validation.
5. Memvalidasi captcha.
6. Mengarahkan user ke halaman sukses.

---

# 8. Validation Requirements

Validasi harus dilakukan **di server-side**.

Client-side validation boleh digunakan sebagai UX tambahan, tetapi tidak boleh menggantikan server-side validation.

## 8.1 Nama Mahasiswa

Rules:

```text
required
string
min:3
```

Contoh:

```text
"H"          → Invalid
"Hi"         → Invalid
"Hisyam"     → Valid
```

Error message:

```text
Nama mahasiswa wajib diisi.
```

dan untuk karakter kurang dari 3:

```text
Nama mahasiswa minimal 3 karakter.
```

---

# 9. Email Validation

Email harus:

1. Wajib diisi.
2. Memiliki format email valid.
3. Berasal dari domain mahasiswa ITS.

Format valid:

```text
nama@student.its.ac.id
```

Format invalid:

```text
nama@gmail.com
nama@its.ac.id
nama@student.its.ac.id.example.com
```

Rules dapat menggunakan kombinasi:

```text
required
email
ends_with:@student.its.ac.id
```

Error message:

```text
Email wajib diisi.
```

atau:

```text
Email harus menggunakan alamat @student.its.ac.id.
```

---

# 10. Category Validation

Kategori wajib dipilih.

Allowed values:

```text
Akademik
Sarana Prasarana
Kegiatan Mahasiswa
```

Sistem tidak boleh menerima arbitrary value dari request.

Contoh manipulasi:

```text
POST category = "Test"
```

harus ditolak oleh server.

Gunakan validation seperti:

```text
required
in:Akademik,Sarana Prasarana,Kegiatan Mahasiswa
```

Error:

```text
Kategori masukan wajib dipilih.
```

---

# 11. Message Validation

Rules:

```text
required
string
min:15
```

Contoh:

```text
"Bagus" 
```

→ Invalid

```text
"Fasilitas laboratorium perlu ditingkatkan."
```

→ Valid

Error:

```text
Isi pesan wajib diisi.
```

atau:

```text
Isi pesan minimal 15 karakter.
```

---

# 12. CSRF Protection

Semua request `POST` wajib menggunakan Laravel CSRF protection.

Form harus menyertakan:

```blade
@csrf
```

Contoh struktur:

```blade
<form method="POST" action="{{ route('feedback.submit') }}">
    @csrf

    ...
</form>
```

Sistem harus menolak submission yang tidak memiliki token CSRF valid.

Tidak boleh menonaktifkan CSRF middleware untuk route feedback.

---

# 13. Dynamic Math Captcha

Dynamic Math Captcha merupakan fitur challenge utama.

## 13.1 Generate Captcha

Ketika user membuka halaman form, sistem menghasilkan dua angka random.

Contoh:

```text
5 + 7
```

Sistem kemudian menyimpan jawaban yang benar ke session.

Contoh session:

```php
session([
    'captcha_answer' => 12
]);
```

Pertanyaan ditampilkan pada halaman:

```text
Berapakah 5 + 7?
```

---

# 14. Captcha Rules

Captcha harus memenuhi ketentuan:

* Angka dihasilkan secara random.
* Jawaban disimpan di session.
* Jawaban tidak dikirim sebagai hidden input.
* User wajib mengisi jawaban.
* Server melakukan pengecekan jawaban.
* Captcha tidak boleh hanya divalidasi melalui JavaScript.

Contoh:

```text
Question:
8 + 4 = ?

User:
12
```

→ Valid.

Contoh:

```text
Question:
8 + 4 = ?

User:
15
```

→ Invalid.

Error:

```text
Jawaban captcha salah.
```

---

# 15. Captcha Lifecycle

Flow yang direkomendasikan:

```text
User GET /
      ↓
Generate random number A
      ↓
Generate random number B
      ↓
Calculate A + B
      ↓
Store answer in Session
      ↓
Display question
```

Kemudian:

```text
User POST /feedback
      ↓
Read captcha_answer from session
      ↓
Compare with user input
      ↓
Correct → continue
Wrong   → validation error
```

Setelah submit berhasil, captcha session sebaiknya dihapus atau diganti agar tidak dapat digunakan kembali.

---

# 16. Error Handling

Ketika validation gagal:

```text
POST /feedback
       ↓
Validation failed
       ↓
redirect back
       ↓
withErrors()
       ↓
withInput()
```

Form harus menampilkan error di bawah field yang bermasalah.

Contoh:

```blade
<input
    type="text"
    name="name"
    value="{{ old('name') }}"
>
```

Error:

```blade
@error('name')
    <div>{{ $message }}</div>
@enderror
```

---

# 17. Old Input Recovery

Ketika validasi gagal, input user harus tetap tersedia.

Contoh:

```php
old('name')
old('email')
old('category')
old('message')
```

Captcha answer **tidak wajib** dipertahankan setelah validasi gagal karena user harus memasukkan kembali jawaban captcha.

Contoh:

```text
Nama:
Hisyam

Email:
hisyam@student.its.ac.id

Kategori:
Akademik

Pesan:
Jadwal perkuliahan perlu diperbaiki.

Captcha:
[ kosong ]
```

Setelah captcha salah, seluruh field selain captcha tetap terisi.

---

# 18. Success Flow

Jika seluruh validasi berhasil:

```text
POST /feedback
      ↓
Validation passed
      ↓
Captcha passed
      ↓
Clear captcha session
      ↓
redirect
      ↓
GET /feedback/success
```

Halaman sukses harus menampilkan informasi bahwa feedback berhasil diterima.

Contoh:

```text
Feedback Berhasil Dikirim

Terima kasih atas masukan yang telah Anda berikan.

Masukan Anda telah berhasil diterima oleh sistem.
```

Tidak perlu benar-benar menyimpan feedback ke database untuk versi tugas ini.

---

# 19. UI/UX Requirements

Challenge UI menggunakan:

```text
Bootstrap 5
```

atau

```text
Tailwind CSS via CDN
```

Untuk mengurangi kompleksitas setup, **Bootstrap 5 via CDN direkomendasikan**.

UI harus:

* Responsive.
* Bersih.
* Tidak terlalu ramai.
* Mudah dibaca.
* Memiliki hierarchy visual yang jelas.
* Error message mudah ditemukan.
* Button submit terlihat jelas.

---

# 20. Branding

Gunakan nuansa visual yang terinspirasi dari branding ITS tanpa membuat halaman terlalu kompleks.

Rekomendasi:

```text
Primary:
ITS Blue

Background:
Light / White

Card:
White

Text:
Dark Gray
```

Header:

```text
SECURE
FEEDBACK
HUB
```

Subtitle:

```text
Portal Aspirasi Mahasiswa Teknik Informatika ITS
```

---

# 21. UI Structure

Halaman utama:

```text
┌──────────────────────────────────────────┐
│         SECURE FEEDBACK HUB              │
│  Portal Aspirasi Mahasiswa TI ITS       │
├──────────────────────────────────────────┤
│                                          │
│  Nama Mahasiswa                         │
│  [____________________________]          │
│                                          │
│  Email ITS                               │
│  [____________________________]          │
│                                          │
│  Kategori Masukan                        │
│  [ Pilih Kategori ▼ ]                    │
│                                          │
│  Isi Pesan                               │
│  [____________________________]          │
│  [____________________________]          │
│                                          │
│  Verifikasi                              │
│  Berapakah 5 + 7?                        │
│  [____________]                          │
│                                          │
│             [ Kirim Feedback ]           │
│                                          │
└──────────────────────────────────────────┘
```

---

# 22. Error State

Contoh:

```text
Nama Mahasiswa
[Hi]

⚠ Nama mahasiswa minimal 3 karakter.
```

Email:

```text
Email ITS
[hisyam@gmail.com]

⚠ Email harus menggunakan alamat @student.its.ac.id.
```

Captcha:

```text
Berapakah 8 + 5?

[10]

⚠ Jawaban captcha salah.
```

Error harus tampil dekat dengan field yang bersangkutan.

---

# 23. Success State

Halaman sukses harus memiliki visual feedback yang jelas.

Contoh:

```text
✓

Feedback Berhasil Dikirim

Terima kasih atas masukan Anda.

Masukan Anda telah berhasil diterima oleh
Secure Feedback Hub.

[ Kirim Feedback Lagi ]
```

Button dapat mengarah kembali ke:

```text
route('feedback.form')
```

---

# 24. Technical Architecture

Struktur minimal project:

```text
secure-feedback-hub/
│
├── app/
│   └── Http/
│       └── Controllers/
│           └── PageController.php
│
├── resources/
│   └── views/
│       ├── feedback/
│       │   ├── form.blade.php
│       │   └── success.blade.php
│       │
│       └── layouts/
│           └── app.blade.php
│
├── routes/
│   └── web.php
│
├── public/
│
├── storage/
│
└── ...
```

Tidak perlu membuat struktur yang terlalu kompleks.

---

# 25. Route Architecture

`routes/web.php` hanya bertanggung jawab mendefinisikan route.

Contoh struktur:

```php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'showFeedbackForm'])
    ->name('feedback.form');

Route::post('/feedback', [PageController::class, 'submitFeedback'])
    ->name('feedback.submit');

Route::get('/feedback/success', [PageController::class, 'feedbackSuccess'])
    ->name('feedback.success');
```

Tidak boleh:

```php
Route::get('/', function () {
    ...
});
```

---

# 26. Validation Architecture

Validation dilakukan di `submitFeedback()`.

Konsep logic:

```text
Request
   ↓
CSRF Middleware
   ↓
PageController@submitFeedback
   ↓
Validate input
   ↓
Validate captcha
   ↓
Failed?
 ┌───────────────┐
 │ Yes           │ No
 ↓               ↓
Back + Errors    Success
+ Old Input
```

---

# 27. Recommended Validation Rules

Contoh requirement teknis:

```php
$request->validate([
    'name' => ['required', 'string', 'min:3'],
    'email' => [
        'required',
        'email',
        'ends_with:@student.its.ac.id'
    ],
    'category' => [
        'required',
        Rule::in([
            'Akademik',
            'Sarana Prasarana',
            'Kegiatan Mahasiswa'
        ])
    ],
    'message' => ['required', 'string', 'min:15'],
    'captcha' => ['required', 'numeric'],
], [
    'name.required' => 'Nama mahasiswa wajib diisi.',
    'name.min' => 'Nama mahasiswa minimal 3 karakter.',
    ...
]);
```

Captcha comparison dapat dilakukan setelah validation standar.

---

# 28. Security Requirements

Project harus memenuhi prinsip berikut:

### SR-01 — CSRF

Setiap POST menggunakan CSRF token.

### SR-02 — Server-side Validation

Tidak mempercayai input dari browser.

### SR-03 — Whitelist Category

Kategori harus berasal dari daftar yang diperbolehkan.

### SR-04 — Session Captcha

Jawaban captcha hanya disimpan di server session.

### SR-05 — Escaping Output

Data user yang ditampilkan kembali harus menggunakan Blade escaping default:

```blade
{{ $value }}
```

dan bukan:

```blade
{!! $value !!}
```

kecuali memang diperlukan.

### SR-06 — No Sensitive Data

Jangan menampilkan atau menyimpan data sensitif yang tidak diperlukan.

---

# 29. Non-Functional Requirements

## Performance

Halaman harus dapat dibuka dengan cepat pada local environment.

## Maintainability

Kode harus mudah dibaca dan mengikuti struktur Laravel standar.

## Usability

User harus dapat memahami cara mengisi form tanpa dokumentasi tambahan.

## Responsiveness

Halaman harus usable pada:

* Desktop
* Laptop
* Tablet
* Mobile

## Code Quality

Gunakan:

* PSR-compatible naming.
* Method yang jelas.
* Variable name deskriptif.
* Tidak ada logic route yang kompleks.
* Tidak ada duplicate code yang tidak perlu.

---

# 30. Acceptance Criteria

Project dianggap selesai apabila semua kondisi berikut terpenuhi.

### AC-01

User dapat membuka:

```text
/
```

dan melihat form feedback.

### AC-02

Form menggunakan:

```text
POST
```

untuk submission.

### AC-03

POST request diproses oleh:

```text
PageController
```

### AC-04

Tidak terdapat route closure pada:

```text
routes/web.php
```

### AC-05

Form memiliki:

```text
@csrf
```

### AC-06

Nama kosong ditolak.

### AC-07

Nama kurang dari 3 karakter ditolak.

### AC-08

Email selain domain:

```text
@student.its.ac.id
```

ditolak.

### AC-09

Kategori di luar tiga pilihan ditolak.

### AC-10

Pesan kurang dari 15 karakter ditolak.

### AC-11

Validation error ditampilkan dalam Bahasa Indonesia.

### AC-12

Old input tetap muncul setelah validation failure.

### AC-13

Captcha dihasilkan secara random.

### AC-14

Jawaban captcha disimpan di session.

### AC-15

Captcha salah menyebabkan submission ditolak.

### AC-16

Captcha benar memungkinkan submission diproses.

### AC-17

Submission valid mengarah ke halaman success.

### AC-18

UI responsive.

---

# 31. Testing Plan

Minimal lakukan pengujian berikut.

| Test             | Input                    | Expected Result  |
| ---------------- | ------------------------ | ---------------- |
| Empty form       | Semua kosong             | Validation error |
| Short name       | `Hi`                     | Name error       |
| Valid name       | `Hisyam`                 | Pass             |
| Invalid email    | `user@gmail.com`         | Email error      |
| Invalid domain   | `user@its.ac.id`         | Email error      |
| Valid email      | `user@student.its.ac.id` | Pass             |
| Invalid category | Value random             | Category error   |
| Short message    | `Bagus`                  | Message error    |
| Valid message    | >15 karakter             | Pass             |
| Wrong captcha    | Jawaban salah            | Captcha error    |
| Correct captcha  | Jawaban benar            | Pass             |
| Missing CSRF     | Request tanpa token      | Request ditolak  |
| All valid        | Semua valid              | Success page     |

---

# 32. Demo Scenario

Saat presentasi, demo sebaiknya mengikuti urutan:

### Demo 1 — Form

Buka halaman:

```text
/
```

Tunjukkan seluruh field dan captcha.

### Demo 2 — Validation

Submit form kosong.

Tunjukkan:

* Error message.
* Old input.

### Demo 3 — Email Validation

Masukkan:

```text
user@gmail.com
```

Tunjukkan bahwa server menolak email.

### Demo 4 — Captcha

Masukkan jawaban captcha yang salah.

Tunjukkan pesan:

```text
Jawaban captcha salah.
```

### Demo 5 — Successful Submission

Isi seluruh field dengan benar.

Tunjukkan halaman success.

### Demo 6 — Source Code

Jelaskan:

```text
routes/web.php
        ↓
PageController
        ↓
Validation
        ↓
Session Captcha
        ↓
Redirect
        ↓
Success Page
```

---

# 33. Suggested File Responsibilities

## `routes/web.php`

Hanya routing.

## `PageController.php`

Menangani:

* Generate captcha.
* Menampilkan form.
* Process POST.
* Validation.
* Success redirect.

## `form.blade.php`

Menampilkan:

* Form.
* Input.
* Old values.
* Error messages.
* Captcha.

## `success.blade.php`

Menampilkan status berhasil.

## `app.blade.php`

Menampung:

* HTML structure.
* Bootstrap CDN.
* Global styling.
* Responsive layout.

---

# 34. Definition of Done

Project dinyatakan selesai ketika:

```text
[✓] Laravel project dapat dijalankan
[✓] GET / dapat dibuka
[✓] Form feedback tersedia
[✓] POST menggunakan PageController
[✓] Tidak ada route closure
[✓] CSRF aktif
[✓] Validation server-side aktif
[✓] Error message Bahasa Indonesia
[✓] old() bekerja
[✓] Dynamic Math Captcha bekerja
[✓] Captcha menggunakan session
[✓] Success page tersedia
[✓] Bootstrap/Tailwind diterapkan
[✓] Responsive
[✓] Semua test utama berhasil
[✓] Code rapi dan mudah dijelaskan
```

---

# 35. Prioritas Implementasi

Urutan pengerjaan yang direkomendasikan:

```text
1. Setup Laravel
        ↓
2. Buat PageController
        ↓
3. Buat routes
        ↓
4. Buat halaman form
        ↓
5. Tambahkan POST handling
        ↓
6. Tambahkan validation
        ↓
7. Tambahkan error handling
        ↓
8. Tambahkan old input
        ↓
9. Tambahkan CSRF
        ↓
10. Implementasikan Math Captcha
        ↓
11. Buat success page
        ↓
12. Styling Bootstrap
        ↓
13. Testing
        ↓
14. Rapikan code untuk demo
```

---

# 36. Expected Final Experience

User membuka aplikasi dan langsung memahami:

> "Ini adalah portal untuk mengirimkan feedback mahasiswa."

User mengisi form, menjawab captcha, lalu menekan:

```text
Kirim Feedback
```

Jika terdapat kesalahan:

```text
Form tidak hilang.
Input sebelumnya tetap ada.
Error muncul tepat di field yang bermasalah.
```

Jika seluruh input benar:

```text
Feedback berhasil dikirim.
```

Aplikasi harus terasa sederhana, aman, dan terstruktur tanpa menambahkan fitur yang tidak dibutuhkan oleh tugas.

# 37. Success Metric

Project berhasil apabila seluruh fitur wajib berjalan sesuai requirement dan seluruh challenge utama berhasil diterapkan.

Prioritas utama:

```text
Security
    >
Validation
    >
Correct Laravel Architecture
    >
UX
    >
Visual Design
```

Dengan demikian, kualitas implementasi tidak hanya dinilai dari tampilan, tetapi terutama dari **ketepatan alur request, validasi server-side, CSRF protection, session handling, dan struktur Laravel yang benar.**
