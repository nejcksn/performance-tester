<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildPart extends Model
{
    use HasFactory;

    protected $fillable = ['build_id', 'product_id', 'is_faker'];

    public function build() {
        return $this->belongsTo(UserBuild::class, 'build_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
