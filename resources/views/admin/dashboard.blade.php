@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0" style="color: var(--sf-blue-700)">Admin Dashboard</h3>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger fw-semibold">Logout</button>
        </form>
    </div>
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle text-center">
                    <thead style="background-color: var(--sf-blue-100)">
                        <tr>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Pesan</th>
                            <th class="px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                        <tr>
                            <td class="px-4 py-3">{{ $feedback->name }}</td>
                            <td class="px-4 py-3">{{ $feedback->email }}</td>
                            <td class="px-4 py-3"><span class="badge bg-secondary">{{ $feedback->category }}</span></td>
                            <td class="px-4 py-3">{{ Str::limit($feedback->message, 50) }}</td>
                            <td class="px-4 py-3">{{ $feedback->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-3 text-muted">Belum ada feedback.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
