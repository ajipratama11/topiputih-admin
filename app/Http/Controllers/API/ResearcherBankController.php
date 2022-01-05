<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResearcherBank;
use Illuminate\Http\Request;
use Exception;

class ResearcherBankController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);
        
        return ResearcherBank::create($request->all());
    }

    public function update(Request $request)
    {
        
        $fields = $request->validate([
            'user_id' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);
        
            $bank = ResearcherBank::where('user_id', $fields['user_id'])->first();
            $bank = ResearcherBank::find( $fields['user_id']);
            $bank-> bank_name = $fields['bank_name'];
            $bank-> account_number = $fields['account_number'];
            $bank-> account_name = $fields['account_name'];
            $bank->save();
            return[
                'message' => ' Berhasil Update Data',
                'program' => $bank,
            ];
        
    }
}
