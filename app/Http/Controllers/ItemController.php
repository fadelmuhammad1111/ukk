<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')
            ->withCount([
                'borrowedItems as total_borrowed_active' => function ($q) {
                    $q->whereNull('returned_at');
                }
            ])
            ->latest()
            ->get();

        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required',
            'total_stock' => 'required|integer|min:0',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil ditambahkan');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required',
            'total_stock' => 'required|integer|min:0',
            'total_repaired' => 'nullable|integer|min:0',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil diupdate');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return back()->with('success', 'Item berhasil dihapus');
    }

    public function borrowDetail(Item $item)
    {
        $borrowedItems = $item->borrowedItems()
            ->with('staff')
            ->latest()
            ->get();

        return view('items.borrow-detail', compact('item', 'borrowedItems'));
    }

    public function addDamaged(Request $request, Item $item)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $item->increment('total_repaired', $request->jumlah);

        return back()->with('success', 'Jumlah barang rusak ditambahkan');
    }

    public function export()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }
}
