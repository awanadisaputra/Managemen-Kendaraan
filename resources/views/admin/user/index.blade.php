@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/user/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="user-management-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-users-cog"></i>
                Manajemen User
            </h1>
            <a href="{{ route('admin.user.create') }}" class="add-button">
                <i class="fas fa-user-plus"></i>
                Tambah User
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="data-card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user mr-1"></i> Nama</th>
                            <th><i class="fas fa-envelope mr-1"></i> Email</th>
                            <th><i class="fas fa-user-tag mr-1"></i> Peran</th>
                            <th><i class="fas fa-user-shield mr-1"></i> Atasan</th>
                            <th><i class="fas fa-cog mr-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge role-{{ strtolower($user->peran) }}">
                                        @switch($user->peran)
                                            @case('admin')
                                                <i class="fas fa-crown"></i>
                                            @break
                                            @case('manager')
                                                <i class="fas fa-user-tie"></i>
                                            @break
                                            @case('supervisor')
                                                <i class="fas fa-user-check"></i>
                                            @break
                                            @default
                                                <i class="fas fa-user"></i>
                                        @endswitch
                                        {{ ucfirst($user->peran) }}
                                    </span>
                                </td>
                                <td>{{ optional($user->atasan)->nama ?? '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.user.show', $user) }}" class="action-btn btn-view" title="Detail">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.user.edit', $user) }}" class="action-btn btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection