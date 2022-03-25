<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_bank',
        'nomor_rekening',
        'nama_rekening',
        'total_bayar',
        'status',
        'tanggal_pembayaran',
        'bukti_transfer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_balance($user_id)
    {
        return Payment::where('status','Diterima')
        ->where('user_id',$user_id)
        ->sum('payments.total_bayar');
    }
}
