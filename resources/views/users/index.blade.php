@extends('layouts.app')

@section('content')

<h3>Users</h3>

<a href="/users/create" class="btn btn-primary mb-3">+ Tambah</a>
<a href="{{ route('users.export') }}" class="btn btn-success">
    Export Excel
</a>

<table class="table table-bordered">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>

@foreach($users as $u)
<tr>
    <td>{{ $u->name }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->role }}</td>
    <td>
        <a href="/users/{{ $u->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
        <form action="/users/{{ $u->id }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
</tr>
@endforeach

</table>

@endsection
