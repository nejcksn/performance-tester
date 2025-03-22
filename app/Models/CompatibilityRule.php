<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompatibilityRule extends Model
{
    use HasFactory;

    protected $fillable = ['category_1', 'category_2', 'rule', 'is_faker'];

    public function categoryOne() {
        return $this->belongsTo(Category::class, 'category_1');
    }

    public function categoryTwo() {
        return $this->belongsTo(Category::class, 'category_2');
    }

}
