<?php

namespace App\Http\Controllers;

use App\Models\BorrowedItem;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Exports\BorrowingsExport;
use Maatwebsite\Excel\Facades\Excel;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowedItems = BorrowedItem::with('item', 'staff')
            ->latest()
            ->get();

        return view('borrowings.index', compact('borrowedItems'));
    }

    public function create()
    {
        $items = Item::all();

        return view('borrowings.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_borrower' => 'required',
            'date' => 'required',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.total_item' => 'required|integer|min:1',
        ]);

        foreach ($request->items as $borrowed) {
            $item = Item::findOrFail($borrowed['item_id']);

            if ($item->total_stock < $borrowed['total_item']) {
                return back()->with(
                    'error',
                    'Stok item "' . $item->item_name . '" tidak cukup'
                );
            }
        }

        foreach ($request->items as $borrowed) {
            $item = Item::findOrFail($borrowed['item_id']);

            BorrowedItem::create([
                'item_id' => $borrowed['item_id'],
                'staff_id' => auth()->id(),
                'name_borrower' => $request->name_borrower,
                'total_item' => $borrowed['total_item'],
                'date' => $request->date,
                'notes' => $request->notes,
            ]);

            $item->decrement('total_stock', $borrowed['total_item']);
            $item->increment('total_borrowed', $borrowed['total_item']);
        }

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function show(BorrowedItem $borrowing)
    {
        return view('borrowings.show', compact('borrowing'));
    }

    public function destroy($id)
    {
        $borrowing = BorrowedItem::findOrFail($id);
    
        if (is_null($borrowing->returned_at)) {
            return back()->with('error', 'Tidak bisa hapus, barang belum dikembalikan');
        }
    
        $borrowing->delete();
    
        return back()->with('success', 'Data peminjaman berhasil dihapus');
    }

    public function returnItem($id)
    {
        $borrow = BorrowedItem::findOrFail($id);

        if ($borrow->returned_at) {
            return back()->with('error', 'Barang sudah dikembalikan');
        }

        $borrow->update([
            'returned_at' => now()
        ]);

        $borrow->item->increment('total_stock', $borrow->total_item);
        $borrow->item->decrement('total_borrowed', $borrow->total_item);

        return back()->with('success', 'Barang berhasil dikembalikan');
    }

    public function export()
    {
        return Excel::download(new BorrowingsExport, 'borrowings.xlsx');
    }
}
