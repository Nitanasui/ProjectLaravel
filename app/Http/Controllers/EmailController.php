<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sandEmailOTP(Request $request){
        dispatch(new SendEmailJob($request->email));
    }
}
