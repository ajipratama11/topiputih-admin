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
        'price_1',
        'price_2',
        'price_3',
        'price_4',
        'price_5',
        'date_start',
        'date_end',
        'description',
        'scope',
        'status',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
