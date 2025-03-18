<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_case_id', 
        'execution_time',
        'record_count'
    ];

    public function testCase() 
    {
        return $this->belongsTo(TestCase::class);
    }
}
