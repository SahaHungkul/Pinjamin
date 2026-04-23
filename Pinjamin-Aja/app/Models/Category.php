<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nama_kategori'
    ];

    // public function tool(){
    //     return $this->hasMany(Tool::class);
    // }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $search){
            $query->where('nama_kategori', 'like', "%{$search}%");
        });
    }
}
