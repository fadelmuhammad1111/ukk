@extends('layouts.app')

@section('content')

<h3>Item</h3>

<a href="/items/create" class="btn btn-primary mb-3">+ Tambah</a>
<a href="{{ route('items.export') }}" class="btn btn-success">
    Export Excel
</a>

<table class="table table-bordered">
<tr>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Stock</th>
    <th>Dipinjam</th>
    <th>Rusak</th>
    <th>Aksi</th>
</tr>

@foreach($items as $i)
<tr>
    <td>{{ $i->item_name }}</td>
    <td>{{ $i->category->name }}</td>
    <td>{{ $i->total_stock }}</td>
    <td>
        <a href="/items/{{ $i->id }}/borrow-detail">
            {{ $i->total_borrowed_active }}
        </a>
    </td>
    <td>{{ $i->total_repaired }}</td>
    <td>
        <a href="/items/{{ $i->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
        <form action="/items/{{ $i->id }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
</tr>
@endforeach

</table>

@endsection
