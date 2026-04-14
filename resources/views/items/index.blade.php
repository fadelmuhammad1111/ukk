@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Item</h3>

    <div>
        <a href="{{ route('items.create') }}" class="btn btn-primary">
            + Tambah
        </a>

        <a href="{{ route('items.export') }}" class="btn btn-success">
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
                    <th>Kategori</th>
                    <th>Stock</th>
                    <th>Dipinjam</th>
                    <th>Rusak</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $i)
                <tr>
                    <td>{{ $i->item_name }}</td>

                    <td>
                        {{ $i->category->name ?? '-' }}
                    </td>

                    <td>{{ $i->total_stock }}</td>

                    <td>
                        <a href="{{ route('items.borrowDetail', $i->id) }}">
                            {{ $i->total_borrowed_active }}
                        </a>
                    </td>

                    <td>{{ $i->total_repaired ?? 0 }}</td>

                    <td>
                        @if(auth()->user()->role === 'admin')
                            <div class="d-flex gap-1">
                                <a href="{{ route('items.edit', $i->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('items.destroy', $i->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus item ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Data item belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection