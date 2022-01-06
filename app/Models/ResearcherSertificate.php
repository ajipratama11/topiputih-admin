<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearcherSertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cert_name',
        'cert_file',
        'cert_date',
        'cert_type'
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
