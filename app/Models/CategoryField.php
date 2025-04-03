<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryField extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'label', 'type'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
