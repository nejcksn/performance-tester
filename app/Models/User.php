<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'surname', 'slug', 'email', 'password',];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }

    public function builds() {
        return $this->hasMany(UserBuild::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function scopeFaker($query)
    {
        return $query->where('is_faker', 1);
    }
    public function generateSlug()
    {
        $name = $this->name;
        $surname = $this->surname;
        if($name && $surname) {
            $this->slug = Str::slug($name . '-' . $surname);
        } else {
            $this->slug = 'user-' . $this->id;
        }
        $i = 1;
        while(static::where('slug', $this->slug)->where('id', '<>', $this->id)->exists()) {
            $this->slug = Str::slug($name . '-' . $surname) . '-' . (++$i);
        }
        $this->save();
    }
}
