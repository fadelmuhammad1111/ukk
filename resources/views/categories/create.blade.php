@extends('layouts.app')

@section('content')

<h3>Tambah Kategori</h3>

<form method="POST" action="/categories">
@csrf

<input type="text" name="name" placeholder="Nama" class="form-control mb-2">
<input type="text" name="division" placeholder="Divisi" class="form-control mb-2">

<button class="btn btn-success">Simpan</button>

</form>

@endsection
