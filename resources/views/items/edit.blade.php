@extends('layouts.app')

@section('content')

<h3>Edit Item</h3>

<div class="card shadow p-4">
    <form action="{{ route('items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Item</label>
            <input type="text"
                   name="item_name"
                   class="form-control"
                   value="{{ $item->item_name }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $item->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Total Stock</label>
            <input type="number"
                   name="total_stock"
                   class="form-control"
                   value="{{ $item->total_stock }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Total Rusak</label>
            <input type="number"
                   name="total_repaired"
                   class="form-control"
                   value="{{ $item->total_repaired }}">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
