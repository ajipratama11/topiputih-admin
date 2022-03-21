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
        'slug',
        'scope_report',
        'description_report',
        'impact',
        'category_id',
        'file',
        'date',
        'status_report',
        'status_causes',
        'point',
        'reward',
        'status_reward',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function categoryReport()
    {
        return $this->belongsTo(CategoryReport::class,'category_id');
    }
}
