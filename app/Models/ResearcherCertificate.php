<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearcherCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_sertifikat',
        'berkas_sertifikat',
        'tagggal_sertifikat',
        'tipe_sertifikat'
        
    ];

    public function show_1($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'tipe_sertifikat' => 'keahlian'])->get();
    }

    public function show_2($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'tipe_sertifikat' => 'penghargaan'])->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function user_cert()
    // {
    //     return $this->belongsTo(User::class,'user_id','id');
    // }

    
}
