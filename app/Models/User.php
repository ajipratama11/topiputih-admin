<?php

namespace App\Models;

use App\Models\Program;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function companyProgram()
    {
        return $this->hasOne(Program::class);
    }

    public function program_count($user_id)
    {
        
        // if(Program::where('user_id', $user_id)->exists()){
           
            $program = Program::where('user_id', $user_id)->count();
            return $program;
        // }
        // return '0';
        
    }
}
