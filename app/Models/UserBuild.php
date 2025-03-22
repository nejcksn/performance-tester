<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBuild extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'is_faker'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function parts() {
        return $this->hasMany(BuildPart::class, 'build_id');
    }
}
