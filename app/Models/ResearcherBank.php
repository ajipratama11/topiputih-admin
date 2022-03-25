<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearcherBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_bank',
        'nomor_rekening',
        'nama_rekening'
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
