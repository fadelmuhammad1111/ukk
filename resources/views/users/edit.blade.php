@extends('layouts.app')

@section('content')

<h3>Edit User</h3>

<div class="card shadow p-4">
    <form action="/users-admin/{{ $user->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ $user->name }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ $user->email }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>
                    Staff
                </option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
