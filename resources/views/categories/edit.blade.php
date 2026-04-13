@extends('layouts.app')

@section('content')

<h3>Edit Category</h3>

<div class="card shadow p-4">
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ $category->name }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Divisi</label>
            <input type="text"
                   name="division"
                   class="form-control"
                   value="{{ $category->division }}"
                   required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
