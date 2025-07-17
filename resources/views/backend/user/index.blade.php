@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Semua User Anda!!</h3>
                        <p class="text-white-75 mb-3">Kelola dan pantau semua user Anda dengan mudah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">User</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="user-dashboard"
                                class="img-fluid" style="max-height: 120px; filter: brightness(1.1);" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative elements -->
            <div class="position-absolute top-0 end-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
            </div>
            <div class="position-absolute bottom-0 start-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
            </div>
        </div>
        <!-- Action -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-users text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Daftar User Anda</h5>
                                <p class="text-muted mb-0">
                                    @if ($users->count() > 0)
                                        Menampilkan {{ $users->count() }} user dari total koleksi Anda
                                    @else
                                        Belum ada user yang dibuat - mulai dengan membuat user pertama!
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg px-4">
                            <i class="ti ti-plus me-2"></i>Buat User Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-table me-2 text-primary"></i>Tabel User
                    </h5>
                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                        {{ $users->count() }} User
                    </span>
                </div>
            </div>

            @if ($users->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover user-table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold text-dark py-3"><i class="ti ti-hash me-1"></i>No</th>
                                    <th class="border-0 fw-bold text-dark py-3"><i class="ti ti-user me-1"></i>Nama</th>
                                    <th class="border-0 fw-bold text-dark py-3"><i class="ti ti-mail me-1"></i>Email</th>
                                    <th class="border-0 fw-bold text-dark py-3"><i class="ti ti-shield me-1"></i>Role</th>
                                    <th class="border-0 fw-bold text-dark py-3"><i class="ti ti-shield me-1"></i>Kelas</th>
                                    <th class="border-0 fw-bold text-dark py-3"><i class="ti ti-calendar me-1"></i>Dibuat
                                    </th>
                                    <th class="border-0 fw-bold text-dark py-3 text-center pe-4"><i
                                            class="ti ti-settings me-1"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td class="py-4">
                                            <span class="fw-bold text-primary">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="py-4">
                                            <h6 class="mb-0 fw-bold text-dark" title="{{ $user->name }}">
                                                {{ $user->name }}</h6>
                                        </td>
                                        <td class="py-4 text-dark">{{ $user->email }}</td>
                                        <td class="py-4">
                                            <span
                                                class="badge {{ $user->isAdmin ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }}">
                                                {{ $user->isAdmin ? 'Admin' : 'User' }}
                                            </span>
                                        </td>
                                         <td class="py-4">
                                             <h6 class="mb-0 fw-bold text-dark" title="{{ $user->name }}">
                                                {{ $user->kelas->nama_kelas }}</h6>
                                        </td>
                                        <td class="py-4">
                                            <small class="text-muted"><i
                                                    class="ti ti-calendar me-1"></i>{{ $user->created_at->format('d M Y, H:i') }}</small>
                                        </td>
                                        @if ($user->email !== 'admin@gmail.com')
                                            <td class="py-4 text-center pe-4">
                                                @if (auth()->user()->canImpersonate() && $user->canBeImpersonated())
                                                    <a href="{{ route('impersonate', $user->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        Impersonate
                                                    </a>
                                                @endif
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-warning btn-sm" title="Edit User">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus User"
                                                        onclick="if(confirm('Yakin ingin menghapus user {{ $user->name }}?')) { document.getElementById('delete-form-{{ $user->id }}').submit(); }">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>

                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="ti ti-users text-primary" style="font-size: 48px;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Belum Ada User</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        Mulai dengan membuat user pertama untuk mengelola sistem Anda dengan lebih baik!
                    </p>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg px-5">
                        <i class="ti ti-plus me-2"></i>Buat User Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white border-0">
                    <i class="ti ti-check-circle me-2"></i>
                    <strong class="me-auto">Sukses</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white border-0">
                    <i class="ti ti-alert-circle me-2"></i>
                    <strong class="me-auto">Gagal</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">{{ session('error') }}</div>
            </div>
        </div>
    @endif


    <style>
        /* Enhanced Custom Styles */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .bg-gradient-primary {
            background: var(--primary-gradient) !important;
        }

        .stats-card {
            transition: all 0.3s ease;
            border-radius: 15px;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .card {
            border-radius: 15px;
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: var(--success-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
        }

        .btn-success:hover {
            box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
        }

        .badge {
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .toast {
            border-radius: 15px;
            min-width: 350px;
            backdrop-filter: blur(10px);
        }

        .toast-header {
            border-radius: 15px 15px 0 0;
        }

        .toast-body {
            border-radius: 0 0 15px 15px;
        }

        .breadcrumb-light .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.7);
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        .bg-primary-subtle {
            background-color: rgba(102, 126, 234, 0.1) !important;
        }

        .bg-success-subtle {
            background-color: rgba(17, 153, 142, 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(102, 126, 234, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .text-primary {
            color: #667eea !important;
        }

        .text-success {
            color: #11998e !important;
        }

        .text-info {
            color: #667eea !important;
        }

        .text-warning {
            color: #f5576c !important;
        }

        /* Table Specific Styles */
        .quiz-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .quiz-table thead th {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            color: #495057;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .quiz-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .quiz-table tbody tr:hover {
            background-color: #f8f9ff !important;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }

        .quiz-table tbody tr:nth-child(even) {
            background-color: #fafbff;
        }

        .quiz-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .quiz-table td {
            vertical-align: middle;
            border: none;
            padding: 1rem 0.75rem;
        }

        .quiz-table .btn-group {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .quiz-table .btn-group .btn {
            border-radius: 0;
            border: none;
            padding: 0.5rem 0.75rem;
        }

        .quiz-table .btn-group .btn:first-child {
            border-radius: 8px 0 0 8px;
        }

        .quiz-table .btn-group .btn:last-child {
            border-radius: 0 8px 8px 0;
        }

        .copy-quiz-btn {
            transition: all 0.2s ease;
        }

        .copy-quiz-btn:hover {
            transform: scale(1.1);
        }

        /* Loading animation for table rows */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .quiz-row {
            animation: slideInLeft 0.6s ease forwards;
        }

        .quiz-row:nth-child(2) {
            animation-delay: 0.1s;
        }

        .quiz-row:nth-child(3) {
            animation-delay: 0.2s;
        }

        .quiz-row:nth-child(4) {
            animation-delay: 0.3s;
        }

        .quiz-row:nth-child(5) {
            animation-delay: 0.4s;
        }

        /* Responsive table improvements */
        @media (max-width: 1200px) {

            .quiz-table th,
            .quiz-table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 992px) {
            .quiz-table {
                font-size: 0.8rem;
            }

            .quiz-table .btn-group .btn {
                padding: 0.375rem 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .quiz-table tbody tr:hover {
                transform: none;
            }
        }

        /* Focus states for accessibility */
        .btn:focus,
        .copy-quiz-btn:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            outline: none;
        }

        /* Print styles */
        @media print {
            .quiz-table {
                font-size: 0.75rem;
            }

            .quiz-table .btn-group {
                display: none;
            }

            .quiz-table tbody tr {
                break-inside: avoid;
            }

            .stats-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar for table */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Enhanced badge styles */
        .badge {
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Animation for success feedback */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-success.pulse {
            animation: pulse 0.3s ease-in-out;
        }

        /* Enhanced button group styling */
        .btn-group .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-color: #28a745;
        }

        .btn-group .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
            border-color: #17a2b8;
        }

        .btn-group .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border-color: #ffc107;
            color: #212529;
        }

        .btn-group .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            border-color: #dc3545;
        }

        /* Tooltip-like effect for truncated text */
        .quiz-table td[title]:hover {
            position: relative;
            cursor: help;
        }

        /* Status badge animations */
        .badge {
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* Icon animations */
        .ti {
            transition: transform 0.2s ease;
        }

        .btn:hover .ti {
            transform: scale(1.1);
        }

        /* Table header sorting indicators (if needed) */
        .quiz-table th.sortable {
            cursor: pointer;
            user-select: none;
        }

        .quiz-table th.sortable:hover {
            background-color: #e9ecef;
        }

        /* Loading state styles */
        .table-loading {
            position: relative;
            opacity: 0.6;
            pointer-events: none;
        }

        .table-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            margin: -20px 0 0 -20px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Enhanced mobile responsiveness */
        @media (max-width: 576px) {
            .quiz-table thead {
                display: none;
            }

            .quiz-table tbody tr {
                display: block;
                border: 1px solid #dee2e6;
                border-radius: 15px;
                margin-bottom: 1rem;
                padding: 1rem;
                background: white;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .quiz-table tbody td {
                display: block;
                text-align: left !important;
                border: none;
                padding: 0.5rem 0;
            }

            .quiz-table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: bold;
                color: #667eea;
            }

            .quiz-table .btn-group {
                width: 100%;
                display: flex;
                justify-content: space-between;
                margin-top: 1rem;
            }

            .quiz-table .btn-group .btn {
                flex: 1;
                margin: 0 2px;
                border-radius: 8px !important;
            }
        }
    </style>
@endsection
