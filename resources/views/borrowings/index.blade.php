@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Peminjaman Barang</h3>

    <div>
        <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
            + Pinjam Barang
        </a>

        <a href="{{ route('borrowings.export') }}" class="btn btn-success">
            Export Excel
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="50">No</th>
                    <th>Item</th>
                    <th>Peminjam</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($borrowedItems as $i => $b)
                <tr>

                    <td>{{ $i + 1 }}</td>

                    <td>
                        {{ $b->item->item_name ?? '-' }}
                    </td>

                    <td>{{ $b->name_borrower }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($b->date)->format('d M Y') }}
                    </td>

                    <td>
                        <span class="badge bg-info">
                            {{ $b->total_item }}
                        </span>
                    </td>

                    <td>
                        @if($b->returned_at)
                            <div>
                                <span class="badge bg-success">Returned</span>
                                <div class="small text-muted">
                                    {{ \Carbon\Carbon::parse($b->returned_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </div>
                            </div>
                        @else
                            <span class="badge bg-danger">Borrowed</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">

                            {{-- Return --}}
                            @if(!$b->returned_at)
                                <form action="{{ url('borrowings/'.$b->id.'/return') }}"
                                      method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        Return
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            @if($b->returned_at)
                                <form action="{{ route('borrowings.destroy', $b->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            @endif

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Data peminjaman belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection