@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-feedback p-4 p-md-5">
            <h2 class="card-title-sf mb-1">
                <i class="bi bi-envelope me-1"></i> Kirim Feedback
            </h2>
            <p class="mb-4" style="color: var(--sf-slate-500); font-size: 0.875rem;">
                Sampaikan masukan, kritik, dan gagasan Anda untuk Teknik Informatika ITS.
            </p>

            <form method="POST" action="{{ route('feedback.submit') }}" novalidate>
                @csrf

                {{-- Nama Mahasiswa --}}
                <div class="mb-4">
                    <label for="name" class="form-label">
                        Nama Mahasiswa <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Hisyam Syafa Raditya"
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email ITS --}}
                <div class="mb-4">
                    <label for="email" class="form-label">
                        Email ITS <span class="text-danger">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="5025241130@student.its.ac.id"
                        autocomplete="email"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Kategori Masukan --}}
                <div class="mb-4">
                    <label for="category" class="form-label">
                        Kategori Masukan <span class="text-danger">*</span>
                    </label>
                    <select
                        id="category"
                        name="category"
                        class="form-select @error('category') is-invalid @enderror"
                    >
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>— Pilih Kategori —</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Isi Pesan --}}
                <div class="mb-4">
                    <label for="message" class="form-label">
                        Isi Pesan <span class="text-danger">*</span>
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Tuliskan masukan Anda di sini (minimal 15 karakter)…"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Math Captcha --}}
                <div class="captcha-box mb-4">
                    <label for="captcha" class="form-label mb-2 d-flex align-items-center">
                        <i class="bi bi-shield-check me-2 fs-5"></i> Verifikasi
                    </label>
                    <p class="mb-3" style="color: var(--sf-slate-600); font-size: 0.875rem;">
                        Berapakah <strong>{{ $numberA }} + {{ $numberB }}</strong>?
                    </p>
                    <input
                        type="number"
                        id="captcha"
                        name="captcha"
                        class="form-control @error('captcha') is-invalid @enderror"
                        placeholder="Masukkan hasil penjumlahan"
                        autocomplete="off"
                    >
                    @error('captcha')
                        <div class="invalid-feedback mt-2">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary-sf btn-lg">
                        <i class="bi bi-send-fill me-2"></i>Kirim Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
