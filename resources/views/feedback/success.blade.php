@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-feedback p-4 p-md-5 text-center">

            {{-- Success Icon --}}
            <div class="mb-4">
                <div class="success-icon-bg">
                    <i class="bi bi-check-circle-fill success-icon"></i>
                </div>
            </div>

            {{-- Heading --}}
            <h2 class="card-title-sf mb-2">
                Feedback Berhasil Dikirim
            </h2>

            <p class="mb-1" style="color: var(--sf-slate-500);">
                Terima kasih atas masukan yang telah Anda berikan.
            </p>
            <p class="mb-4" style="color: var(--sf-slate-500);">
                Masukan Anda telah berhasil diterima oleh sistem.
            </p>

            {{-- Back Button --}}
            <a href="{{ route('feedback.form') }}" class="btn btn-primary-sf btn-lg d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-left-circle me-2"></i>Kirim Feedback Lagi
            </a>
        </div>
    </div>
</div>
@endsection
