<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
        'payment_amount',
        'status',
        'payment_date',
        'image_transfer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_balance($user_id)
    {
        return Payment::where('status','Diterima')
        ->where('user_id',$user_id)
        ->sum('payments.payment_amount');
    }
}
