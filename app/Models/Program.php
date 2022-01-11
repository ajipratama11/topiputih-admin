<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_name',
        'program_image',
        'company_name',
        'max_price',
        'date_start',
        'date_end',
        'description',
        'status',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
