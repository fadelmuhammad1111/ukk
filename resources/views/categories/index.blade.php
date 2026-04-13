@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Kategori</h3>
    <a href="/categories/create" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<!-- TABLE CATEGORY -->
<table class="table table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Divisi</th>
            <th>Jumlah Item</th>
            <th>Detail Item</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $i => $category)
        <tr>

            <!-- NO -->
            <td>{{ $i + 1 }}</td>

            <!-- NAME -->
            <td>{{ $category->name }}</td>

            <!-- DIVISION -->
            <td>{{ $category->division }}</td>

            <!-- COUNT ITEM -->
            <td>
                <span class="badge bg-info">
                    {{ $category->items->count() }} Item
                </span>
            </td>

            <!-- DETAIL ITEM (RELASI) -->
            <td>
                @if($category->items->count() > 0)
                    <ul class="mb-0">
                        @foreach($category->items as $item)
                            <li>
                                {{ $item->item_name }}
                                <small class="text-muted">
                                    (Stok: {{ $item->total_stock }})
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted">Tidak ada item</span>
                @endif
            </td>

            <!-- ACTION -->
            <td>
                <a href="/categories/{{ $category->id }}/edit"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="/categories/{{ $category->id }}"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                        Delete
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

@endsection
