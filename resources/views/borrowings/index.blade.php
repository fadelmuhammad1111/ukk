@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Peminjaman Barang</h3>
    <a href="/borrowings/create" class="btn btn-primary">+ Borrow Item</a>
    <a href="{{ route('borrowings.export') }}" class="btn btn-success">
        Export Excel
    </a>
</div>

<table class="table table-hover bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Peminjam</th>
            <th>Staff</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($borrowedItems as $i => $b)
        <tr>

            <td>{{ $i + 1 }}</td>

            <td>
                <a href="/items/{{ $b->item->id }}/borrow-detail">
                    {{ $b->item->item_name }}
                </a>
            </td>

            <td>{{ $b->name_borrower }}</td>

            <td>{{ $b->user->name ?? '-' }}</td>

            <td>{{ $b->date }}</td>

            <td>
                <span class="badge bg-info">{{ $b->total_item }}</span>
            </td>

            <td>
                @if($b->returned_at)
                    <span class="badge bg-success">Returned</span>
                @else
                    <span class="badge bg-danger">Borrowed</span>
                @endif
            </td>

            <td>
                @if(!$b->returned_at)
                    <form action="/borrowings/{{ $b->id }}/return" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success">Return</button>
                    </form>
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

@endsection
