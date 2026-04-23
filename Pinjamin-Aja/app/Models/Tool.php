<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'nama_alat',
        'deskripsi',
        'category_id',
        'stok',
        'denda_per_hari',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('nama_alat', 'like', "%{$search}%");
        });
    }
}
