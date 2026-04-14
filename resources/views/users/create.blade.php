@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <h3 class="mb-3">Tambah User</h3>

        {{-- ERROR VALIDATION --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email') }}"
                       required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Role</label>

                @if(isset($role_locked) && $role_locked === 'staff')
                    {{-- STAFF TIDAK BISA PILIH ROLE --}}
                    <input type="hidden" name="role" value="staff">

                    <input type="text"
                           class="form-control"
                           value="Staff"
                           disabled>
                @else
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                            Staff
                        </option>
                    </select>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">
                    Simpan
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

@endsection