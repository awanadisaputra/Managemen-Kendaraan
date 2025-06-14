@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/user/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="user-detail-container">
        <div class="detail-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-user-circle"></i>
                    Detail Pengguna
                </h1>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-user"></i>
                        Nama:
                    </span>
                    <span class="detail-value">{{ $user->nama }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-envelope"></i>
                        Email:
                    </span>
                    <span class="detail-value">{{ $user->email }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-user-tag"></i>
                        Peran:
                    </span>
                    <span class="detail-value">
                        <span class="role-badge role-{{ $user->peran }}">
                            @switch($user->peran)
                                @case('admin')
                                    <i class="fas fa-user-shield mr-1"></i>
                                @break
                                @case('manager')
                                    <i class="fas fa-user-tie mr-1"></i>
                                @break
                                @case('supervisor')
                                    <i class="fas fa-user-check mr-1"></i>
                                @break
                                @default
                                    <i class="fas fa-user mr-1"></i>
                            @endswitch
                            {{ ucfirst($user->peran) }}
                        </span>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-user-friends"></i>
                        Atasan:
                    </span>
                    <span class="detail-value">
                        {{ optional($user->atasan)->nama ?? '-' }}
                        @if($user->atasan)
                            <span class="text-sm text-gray-500 ml-2">
                                ({{ ucfirst($user->atasan->peran) }})
                            </span>
                        @endif
                    </span>
                </div>

                <a href="{{ route('admin.user.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection