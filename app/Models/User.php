<?php

namespace App\Models;

use App\Models\Program;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
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
        'nama',
        'slug',
        'email',
        'nama_pengguna',
        'foto_pengguna',
        'nomor_telepon',
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
        return $this->hasOne(ResearcherCertificate::class);
    }

    public function cert_count_1($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'tipe_sertifikat'=> 'keahlian'])->count();
    }
    
    public function cert_count_2($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'tipe_sertifikat'=> 'penghargaan'])->count();
    }

    public function report_count($user_id)
    {
        return Report::where([
            'user_id'=> $user_id])->count();
    }


    public function companyProgram()
    {
        return $this->hasOne(Program::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function invitedUser()
    {
        return $this->hasOne(InvitedUser::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function program_count($user_id)
    {
        
        // if(Program::where('user_id', $user_id)->exists()){
           
            $program = Program::where('user_id', $user_id)->count();
            return $program;
        // }
        // return '0';
        
    }

    public function get_balance($user_id)
    {
        return Payment::where('status','Diterima')
        ->where('user_id',$user_id)
        ->sum('payments.total_bayar');
    }

    public function get_payment($user_id)
    {
        return  Program::where('users.id',$user_id)
        ->where('reports.status_reward','Sudah Dibayarkan')
        ->rightJoin('reports', 'reports.program_id', '=', 'programs.id')
        ->leftJoin('users', 'users.id', '=', 'programs.user_id')
        ->sum('reports.reward');
    }

    public function get_reward_process($user_id)
    {
        return Report::where('user_id',$user_id)
        ->where('status_report','Disetujui')
        ->where('status_reward','Proses')
        ->sum('reward');
    }
    public function get_reward($user_id)
    {
        return Report::where('user_id',$user_id)
        ->where('status_report','Disetujui')
        ->where('status_reward','Belum Dibayarkan')
        ->sum('reward');
    }
    public function get_reward_done($user_id)
    {
        return Report::where('user_id',$user_id)
        ->where('status_report','Disetujui')
        ->where('status_reward','Sudah Dibayarkan')
        ->sum('reward');
    }

    public function payment_used($user_id)
    {
        $calculate = $this->get_balance($user_id) -  $this->get_payment($user_id);

        return $calculate;
    }

    public function sendPasswordResetNotification($token)
    {

        // $query= [$token,$this->email];

        $url = 'http://192.168.1.10:3000/reset-password?token=' . $token.'&email='.$this->email;

        $this->notify(new ResetPasswordNotification($url));
    }
}
