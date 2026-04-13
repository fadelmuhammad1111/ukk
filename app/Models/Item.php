<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'item_name',
        'total_stock',
        'total_repaired',
        'total_borrowed'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function borrowedItems()
    {
        return $this->hasMany(BorrowedItem::class, 'item_id');
    }
}
