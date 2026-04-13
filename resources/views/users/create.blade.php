@extends('layouts.app')

@section('content')

<h3>Tambah User</h3>

<form method="POST" action="/users">
@csrf

<input type="text" name="name" placeholder="Nama" class="form-control mb-2">
<input type="email" name="email" placeholder="Email" class="form-control mb-2">
<input type="password" name="password" placeholder="Password" class="form-control mb-2">

<select name="role" class="form-control mb-2">
    <option value="admin">Admin</option>
    <option value="staff">Staff</option>
</select>

<button class="btn btn-success">Simpan</button>

</form>

@endsection
