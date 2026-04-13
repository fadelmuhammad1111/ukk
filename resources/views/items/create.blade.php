@extends('layouts.app')

@section('content')

<h3>Tambah Item</h3>

<form method="POST" action="/items">
@csrf

<select name="category_id" class="form-control mb-2">
    @foreach($categories as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
    @endforeach
</select>

<input type="text" name="item_name" placeholder="Nama Item" class="form-control mb-2">
<input type="number" name="total_stock" placeholder="Stock" class="form-control mb-2">

<button class="btn btn-success">Simpan</button>

</form>

@endsection
