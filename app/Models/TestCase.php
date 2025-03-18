<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description'
    ];

    public function testResults() 
    {
        return $this->hasMany(TestResult::class);
    }
}
