<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'summary',
        'scope_report',
        'description_report',
        'impact',
        'category_report',
        'file',
        'date',
        'status_report',
        'point',
        'reward'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(program::class);
    }
}
