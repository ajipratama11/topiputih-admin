<?php

namespace App\Http\Controllers;

use App\Mail\InviteProgramMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index($email){
        // Mail::to($email)->send(new InviteProgramMail());
 
        if (Mail::failures()) {
             return 'Sorry! Please try again latter';
        }else{
              return 'Great! Successfully send in your mail';
            }
    }
}
