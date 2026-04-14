@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Users</h3>

    <div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            + Tambah
        </a>

        <a href="{{ route('users.export') }}" class="btn btn-success">
            Export Excel
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>

                    <td>{{ $u->email }}</td>

                    <td>
                        <span class="badge 
                            {{ $u->role === 'admin' ? 'bg-secondary' : 'bg-secondary' }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('users.edit', $u->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('users.destroy', $u->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus User?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Data user belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection