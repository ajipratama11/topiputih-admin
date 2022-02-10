<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'category',
        'detail'
        
    ];

    public function report()
    {
        return $this->hasOne(Report::class);
    }
}
