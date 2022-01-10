<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'contact_name',
        'username',
        'profile_picture',
        'phone_number',
        'password',
        'roles'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function researcherBank()
    {
        return $this->hasOne(ResearcherBank::class);
    }

    public function researcherCertificate()
    {
        return $this->hasOne(ResearcherSertificate::class);
    }

    public function cert_count_1($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'cert_type'=> 'keahlian'])->count();
    }
    
    public function cert_count_2($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'cert_type'=> 'penghargaan'])->count();
    }

    
}
