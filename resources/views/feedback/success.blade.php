@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-feedback p-4 p-md-5 text-center">

            {{-- Success Icon --}}
            <div class="mb-4">
                <div
                    class="d-inline-flex align-items-center justify-content-center rounded-circle"
                    style="width: 80px; height: 80px; background-color: var(--its-accent);"
                >
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #28a745;"></i>
                </div>
            </div>

            {{-- Heading --}}
            <h2 class="fw-bold mb-2" style="color: var(--its-blue);">
                Feedback Berhasil Dikirim
            </h2>

            <p class="text-muted mb-1">
                Terima kasih atas masukan yang telah Anda berikan.
            </p>
            <p class="text-muted mb-4">
                Masukan Anda telah berhasil diterima oleh <strong>Secure Feedback Hub</strong>.
            </p>

            {{-- Back Button --}}
            <a href="{{ route('feedback.form') }}" class="btn btn-its btn-lg">
                <i class="bi bi-arrow-left-circle me-2"></i>Kirim Feedback Lagi
            </a>
        </div>
    </div>
</div>
@endsection
