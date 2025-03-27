<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'category_id', 'brand_id', 'price', 'image', 'is_faker'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function specs() {
        return $this->hasMany(ProductSpec::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function scopeFaker($query)
    {
        return $query->where('is_faker', 1);
    }

    public function generateSlug()
    {
        if(!trim($this->name)) $this->slug = 'product-' . $this->id;
        else {
            $this->slug = Str::slug($this->name);
            $i = 1;
            while(static::where('slug', $this->slug)->where('id', '<>', $this->id)->exists())
                $this->slug = Str::slug($this->name).'-'.(++$i);
        }
        $this->save();
    }
}
