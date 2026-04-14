@extends('layouts.app')

@section('content')

<h3>Detail Peminjaman: {{ $item->item_name }}</h3>

<a href="{{ route('items.index') }}" class="btn btn-secondary mb-3">
    ← Kembali
</a>

<table class="table table-bordered bg-white shadow">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Staff</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($borrowedItems as $i => $b)
        <tr>
            <td>{{ $i + 1 }}</td>

            <td>{{ $b->name_borrower }}</td>

            <td>{{ $b->staff->name ?? '-' }}</td>

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
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">
                Belum ada data peminjaman
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection