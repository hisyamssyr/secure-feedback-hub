# Design Specification — Secure Feedback Hub

**Versi:** 2.0 (Revisi)
**Framework:** Laravel + Bootstrap 5 (via CDN)
**Tone:** Modern Minimalis, Biru Muda

---

# 1. Konsep / Design Vision

Mengganti kesan "corporate dark blue" menjadi **ringan, bersih, dan modern**
dengan dominasi **tone biru muda (sky blue)** yang senada.

Prinsip desain:

1. **Minimal** — ruang kosong (whitespace) lapang, tanpa elemen dekoratif berlebih.
2. **Ringan** — latar terang alami, bukan blok warna pekat; warna gelap hanya untuk teks & aksen.
3. **Modern** — sudut membulat (rounded), shadow lembut, gradient subtil, focus ring jelas.
4. **Hierarki visual** — satu fokus per layar: kartu form / kartu sukses.
5. **Ramah & aman** — warna langit memberikan rasa tenang sekaligus tepercaya (relevan dengan "Secure").

Struktur halaman tetap: `Navbar → Hero Header → Main (kartu) → Footer`, namun tata letak
dan warna dirombak agar terasa jauh lebih modern.

---

# 2. Design Tokens

## 2.1 Palet Warna

Palet berbasis keluarga **Sky (biru muda)** yang senada + netral **Slate**.

| Token                  | Hex       | Penggunaan                                                        |
| ---------------------- | --------- | ----------------------------------------------------------------- |
| `--sf-blue-50`         | `#F0F9FF` | Latar halaman / area tint paling terang                            |
| `--sf-blue-100`        | `#E0F2FE` | Latar komponen lunak (captcha box, icon badge, gradient hero)      |
| `--sf-blue-200`        | `#BAE6FD` | Border lembut / dashed border                                      |
| `--sf-blue-300`        | `#7DD3FC` | Aksen ringan / border kartu                                        |
| `--sf-blue-400`        | `#38BDF8` | Hover state tombol, aksen hiasan                                   |
| `--sf-blue-500`        | `#0EA5E9` | Warna primer utama (tombol, focus ring)                            |
| `--sf-blue-600`        | `#0284C7` | Tekstual aksen / link / ikon aktif                                 |
| `--sf-blue-700`        | `#0369A1` | Teks judul berwarna biru (heading kartu)                           |
| `--sf-blue-900`        | `#0C4A6E` | Warna terpekat — hanya untuk teks besar / brand, bukan blok penuh   |
| `--sf-slate-900`       | `#0F172A` | Teks utama di luar cover                                           |
| `--sf-slate-600`       | `#475569` | Isi paragraf                                                       |
| `--sf-slate-500`       | `#64748B` | Teks muted / helper                                                |
| `--sf-slate-400`       | `#94A3B8` | Placeholder / disabled                                             |
| `--sf-slate-200`       | `#E2E8F0` | Border field default                                                |
| `--sf-white`           | `#FFFFFF` | Permukaan kartu / navbar                                           |
| `--sf-success`         | `#14B8A6` | Ikon sukses (teal — senada dengan keluarga biru)                   |
| `--sf-danger`          | `#F43F5E` | Pesan error (rose — tetap selaras, tidak mencolok)                 |

### Aturan pewarnaan

- **Tidak ada blok biru pekat selebar layar** (header). Warna gelap hanya untuk
  teks, tombol, dan aksen kecil.
- Latar halaman & kartu nyaris putih dengan sentuhan biru (tint), bukan putih murni.
- Error & success memakai aksen warna yang tetap *harmonious* terhadap biru muda.

## 2.2 Tipografi

- **Font:** `Inter` (via Google Fonts CDN) — proporsional, modern, mudah dibaca.
- Fallback: `system-ui, -apple-system, "Segoe UI", Roboto, sans-serif`.

| Skala         | Size | Weight | Use                        |
| ------------- | ---- | ------ | -------------------------- |
| Display       | 2rem–2.5rem | 800    | Judul hero (`SECURE FEEDBACK HUB`) |
| Section / Card title | 1.25rem | 700 | Judul kartu                  |
| Body          | 1rem | 400   | Isi form & paragraf          |
| Caption       | 0.875rem | 500 | Helper text, label kecil     |
| Error text    | 0.875rem | 500 | Pesan validasi               |

- `letter-spacing` kecil (0.02em–0.03em) pada judul agar terlihat modern.

## 2.3 Radius

| Elemen       | Radius             |
| ------------ | ------------------ |
| Kartu utama  | `1.25rem` (20px)   |
| Input/select/textarea | `0.625rem` (10px) |
| Tombol       | Pill (`50rem` / full rounding) |
| Captcha box  | `0.75rem` (12px)   |
| Badge / icon | Purna / lingkaran  |

## 2.4 Shadow

- **Kartu:** `0 10px 40px -12px rgba(2, 132, 199, 0.12)` — lembut, mengambang, berbau biru.
- **Input focus ring:** `0 0 0 4px rgba(14, 165, 233, 0.15)` + border `--sf-blue-500`.
- **Tombol:** shadow halus saat hover, tanpa bayangan blok tebal.

## 2.5 Spacing

- Grid konten dibatasi `max-width: 72rem` (container).
- Kartu form: `py-5 px-4` di mobile, `p-5` di ≥768px.
- Jarak antar field: `1.25rem` (Bootstrap `mb-4`).
- Hero: padding besar vertikal, seimbang antara header & kartu.

---

# 3. Halaman & Komponen

## 3.1 Halaman Form (`feedback/form.blade.php`)

```
┌──────────────────────────────────────────────┐
│  Navbar minimal (putih, blur, logo biru)     │
├──────────────────────────────────────────────┤
│  Hero (tint biru muda + gradient halus):     │
│   ✓ Badge kecil: "Aman & Terverifikasi"      │
│   SECURE FEEDBACK HUB                        │
│   Portal Aspirasi Mahasiswa TI ITS           │
├──────────────────────────────────────────────┤
│  Kartu form (putih, rounded, shadow lembut): │
│   ✉  Kirim Feedback                          │
│   Nama Mahasiswa            [ input ]        │
│   Email ITS                 [ input ]        │
│   Kategori Masukan          [ select ]       │
│   Isi Pesan                 [ textarea ]     │
│   ┌── Verifikasi (captcha box tint biru) ──┐ │
│   │ Berapakah 5 + 7?         [ input ]      │ │
│   └─────────────────────────────────────────┘ │
│   [  Kirim Feedback  ]  (gradien biru, pill) │
├──────────────────────────────────────────────┤
│  Footer minimal (slate shadow)               │
└──────────────────────────────────────────────┘
```

Detail:

- **Navbar:** latar putih lembut dengan blur (`backdrop-filter`), brand pakai
  ikon *shield-check* biru muda + teks slate-900. Tanpa background gelap.
- **Hero:** latar gradien halus `#E0F2FE → #F0F9FF` (bukan blok gelap). Judul teks
  `--sf-blue-900`, subtitle `--sf-slate-600`. Badge pill kecil di atas judul
  (biru muda + teks biru tua) berisi "Aman & Terverifikasi".
- **Kartu:** putih, `border-radius: 1.25rem`, shadow lembut biru, ring tipis
  `1px solid rgba(125, 211, 252, 0.4)`.
- **Input:** border `--sf-slate-200`, radius 10px. Saat fokus → biru muda samar
  di dalam + `focus ring` biru. Label `fw-semibold` slate-900 kecil.
- **Error state:** `is-invalid` → border rose; text error kecil di bawah field
  dengan ikon kecil.
- **Captcha box:** `--sf-blue-50` merah tint lembut + border dashed `--sf-blue-300`,
  ikon *shield-check* biru. Konsisten sebagai "zona verifikasi".
- **Tombol:** gradien `--sf-blue-500 → --sf-blue-600`, pill, `fw-semibold`,
  label putih, ikon *send*, gelap samar saat hover (`--sf-blue-400`).

## 3.2 Halaman Sukses (`feedback/success.blade.php`)

- Kartu yang sama, konten **dipusatkan**.
- **Icon:** lingkaran 84px dengan latar `--sf-blue-100` + ikon *check-circle* besar
  warna `--sf-success` (teal) — aksen senada dengan blue, bukan hijau mentah.
- Judul `--sf-blue-700`; dua baris paragraf `--sf-slate-500`.
- Tombol "Kirim Feedback Lagi" — gaya tombol primer yang sama, bullet ke arah form.

## 3.3 Layout (`layouts/app.blade.php`)

Satu file sumber untuk seluruh token & styling global:

```
:root { semua --sf-* tokens; }
body  { background gradient F0F9FF → E0F2FE; font Inter; color slate-600; }
navbar minimal (white + blur)
hero  section (gradient tint)
main  (container)
footer (slate-500, padding kecil)
```

Semua *style* berada dalam `<style>` di layout sehingga kedua halaman saling
konsisten tanpa file CSS tambahan.

---

# 4. Responsive & Aksesibilitas

## 4.1 Responsive

| Breakpoint | Perilaku                                   |
| ---------- | ------------------------------------------ |
| <576px     | Hero berukuran mengecil, kartu full-width  |
| 576–991px  | Kartu form `col-md-8` tetap nyaman         |
| ≥992px     | Kartu `col-lg-6`, konten terpusat          |

## 4.2 Aksesibilitas

- Kontras teks ≥ WCAG AA pada semua level (slate-600 di atas putih terpenuhi).
- `focus-visible` outline biru terlihat di semua elemen interaktif.
- Label dikaitkan via `for`/`id`.
- Ukuran font tidak di bawah `0.875rem` untuk teks fungsional.
- `aria`/semantik: gunakan `<header>`, `<main>`, `<footer>`.

---

# 5. Catatan Implementasi

1. Teknologi tetap **Bootstrap 5 via CDN** + **Bootstrap Icons** (mengikuti PRD).
2. Font `Inter` ditambahkan via Google Fonts `<link>` di layout.
3. Seluruh pewarnaan lewat CSS variables `--sf-*`, di-*override* di atas Bootstrap
   (tidak menimpa file vendor).
4. Tidak mengubah logic controller, route, validasi, maupun captcha — murni revisi
   tampilan pada `layouts/app.blade.php`, `feedback/form.blade.php`, dan
   `feedback/success.blade.php`.
5. Tidak ada database, JS form tambahan, maupun fitur baru.