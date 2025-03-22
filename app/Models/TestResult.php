<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = ['test_case_id', 'min_time', 'avg_time', 'max_time', 'record_count', 'test_count'];


    public function testCase()
    {
        return $this->belongsTo(TestCase::class);
    }
}
