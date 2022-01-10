<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearcherCertificate;
use App\Models\ResearcherSertificate;

class ResearcherSertificateController extends Controller
{
    public function show_1($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'cert_type' => 'keahlian'])->get();
    }

    public function show_2($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'cert_type' => 'penghargaan'])->get();
    }
}
