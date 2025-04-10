<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFaker($query)
    {
        return $query->where('is_faker', 1);
    }

    public function generateSlug()
    {
        if(!trim($this->name)) $this->slug = 'category-' . $this->id;
        else {
            $this->slug = Str::slug($this->name);
            $i = 1;
            while(static::where('slug', $this->slug)->where('id', '<>', $this->id)->exists())
                $this->slug = Str::slug($this->name).'-'.(++$i);
        }
        $this->save();
    }
}
