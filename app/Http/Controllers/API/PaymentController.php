<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function encodeing($sourcestr)  
    {
        
        $pathToPublicKey = app_path('Http/Controllers/api/client_pubkey.php');
        $key_content = file_get_contents($pathToPublicKey);  
        $pubkeyid    = openssl_get_publickey($key_content);  
          
        if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))  
        {
            return base64_encode("".$crypttext);  
        }
    }

    public function decodeing($crypttext)
    {
        $pathToPrivateKey = app_path('Http/Controllers/privkey.php');
        $prikeyid    = file_get_contents($pathToPrivateKey);
        $crypttext   = base64_decode($crypttext);

        if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, OPENSSL_PKCS1_PADDING))
        {
            return "".$sourcestr;
        }
        return ;
    }

    public function show($user_id)
    {
        $bank =  Payment::where('user_id',$user_id)
        ->select('total_bayar','status','tanggal_pembayaran')
        ->orderBy('id','desc')
        ->get();
        return[

            'message' => 'berhasil',
            'history' =>$bank
        ];
        
    }

    public function create(Request $request)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        $fields = $request->validate([
            'user_id' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'nama_rekening' => 'required',
            'status'=> '',
            'total_bayar'=>'',
            'tanggal_pembayaran' => '',
            'bukti_transfer' => 'required|max:20000|without_spaces'
        ],
        [
            'bukti_transfer.without_spaces' => 'Berkas tidak boleh menggunakan spasi'
        ]);
            $bank = new Payment();
             
        if ($image = $request->file('bukti_transfer')) {
            $destinationPath = 'img/payment/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $bank-> bukti_transfer = $fields['bukti_transfer'] = "$profileImage";
            }
            // $bank-> bukti_transfer = $fields['image_tra']
            // $this->decodeing($fields['status_report']);
            $bank-> user_id =  $this->decodeing($fields['user_id']);
            $bank-> nama_bank =  $this->decodeing($fields['nama_bank']);
            $bank-> nomor_rekening = $this->decodeing($fields['nomor_rekening']);
            $bank-> nama_rekening =  $this->decodeing($fields['nama_rekening']);
            $bank-> status ='Proses';
            $bank-> total_bayar = $this->decodeing($fields['total_bayar']);
            $bank-> tanggal_pembayaran =date('Y-m-d H:i:s');
            $bank->save();
            return[
                'message' => ' Berhasil Menambahkan Data',
                'bank' => $bank
            ];
    }

    public function total($user_id){
        $total = Payment::where('user_id',$user_id)
        ->where('status','Diterima')
        ->sum('total_bayar');

        $used =  Program::where('users.id',$user_id)
        ->where('reports.status_reward','Sudah Dibayarkan')
        ->rightJoin('reports', 'reports.program_id', '=', 'programs.id')
        ->leftJoin('users', 'users.id', '=', 'programs.user_id')
        ->sum('reports.reward');

        $balance = $total - $used;

        
        return[
            'balance' => $this->encodeing($balance),
            'total' => $this->encodeing($total),
            'used' => $this->encodeing($used),
        ];
    }

    public function payment_program_company($user_id){
        $bank =  Program::select('programs.id as program_id','programs.program_name','reports.id as report_userid','users.nama','reports.reward','reports.status_reward','reports.updated_at')
        ->rightJoin('reports', 'reports.program_id', '=', 'programs.id')
        ->leftJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('users.id',$user_id)
        ->where('reports.status_report','Disetujui')
        ->orderBy('reports.updated_at','desc')
        ->get();

        return 
        $bank;
    }

    public function payment_program_report($user_id){
        $bank =  Report::select('programs.program_name','users.nama','reports.reward','reports.status_reward','reports.updated_at')
        ->rightJoin('programs', 'programs.id', '=', 'reports.program_id')
        ->leftJoin('users', 'users.id', '=', 'reports.user_id')
        ->where('reports.id',$user_id)
        ->get();

        return $this->encodeing($bank);
    }


    public function payment_researcher_total($user_id){
        // $bank =  Program::select('programs.program_name','reports.reward','reports.status_reward','reports.updated_at')
        $bank =  Report::where('reports.user_id',$user_id)
        // 
        ->where('reports.status_report','Disetujui')
        ->where('reports.status_reward','Sudah Dibayarkan')
        ->sum('reports.reward');

        return $this->encodeing($bank);
    }

    public function payment_researcher_process($user_id){
        $bank =  Program::select('programs.program_name','reports.reward','reports.status_reward','reports.updated_at')
        ->rightJoin('reports', 'reports.program_id', '=', 'programs.id')
        ->leftJoin('users', 'users.id', '=', 'reports.user_id')
        ->where('users.id',$user_id)
        ->where('reports.status_report','Disetujui')
        ->orderBy('reports.status_reward')
        ->orderBy('reports.updated_at','desc')
        ->get();

        return 
            $bank;

    }

    
}
