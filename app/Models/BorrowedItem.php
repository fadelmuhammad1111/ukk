<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Item;
use App\Models\ReturnedItem;

class BorrowedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'item_id',
        'total_item',
        'name_borrower',
        'date',
        'notes',
        'returned_at'
    ];

    // 👷 staff yang melakukan peminjaman
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // 📦 item yang dipinjam
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // 🔁 jika pakai tabel returned_items (opsional)
    public function returned()
    {
        return $this->hasOne(ReturnedItem::class, 'borrowed_item_id');
    }
}
