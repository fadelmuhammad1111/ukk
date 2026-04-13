@extends('layouts.app')

@section('content')

<h3 class="mb-3">Tambah Peminjaman Barang</h3>

<div class="card shadow p-4">

    <form action="/borrowings" method="POST">
        @csrf

        <!-- NAMA PEMINJAM -->
        <div class="mb-3">
            <label>Nama Peminjam</label>
            <input type="text" name="name_borrower" class="form-control" required>
        </div>

        <!-- TANGGAL -->
        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="datetime-local" name="date" class="form-control" required>
        </div>

        <!-- CONTAINER ITEM -->
        <div id="items-wrapper">

            <div class="item-row border rounded p-3 mb-3">
                <div class="mb-2">
                    <label>Item</label>
                    <select name="items[0][item_id]" class="form-control" required>
                        <option value="">-- Pilih Item --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->item_name }} (Stok: {{ $item->total_stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label>Jumlah Pinjam</label>
                    <input type="number" name="items[0][total_item]" class="form-control" min="1" required>
                </div>

                <button type="button" class="btn btn-danger btn-sm remove-item d-none">
                    Hapus
                </button>
            </div>

        </div>

        <!-- BUTTON TAMBAH ITEM -->
        <button type="button" id="add-item" class="btn btn-success mb-3">
            + Tambah Item
        </button>

        <br>

        <button class="btn btn-primary">Simpan Peminjaman</button>
        <a href="/borrowings" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<script>
let itemIndex = 1;

document.getElementById('add-item').addEventListener('click', function () {
    let wrapper = document.getElementById('items-wrapper');

    let newRow = `
        <div class="item-row border rounded p-3 mb-3">
            <div class="mb-2">
                <label>Item</label>
                <select name="items[${itemIndex}][item_id]" class="form-control" required>
                    <option value="">-- Pilih Item --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->item_name }} (Stok: {{ $item->total_stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label>Jumlah Pinjam</label>
                <input type="number" name="items[${itemIndex}][total_item]" class="form-control" min="1" required>
            </div>

            <button type="button" class="btn btn-danger btn-sm remove-item">
                Hapus
            </button>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', newRow);

    itemIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('.item-row').remove();
    }
});
</script>

@endsection
