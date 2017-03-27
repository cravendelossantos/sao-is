<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;


class MailController extends Controller
{
    public function forgotPasswordMail()
  	{
  			
    	$data = ['name' => 'Student Affairs Office'];
    	Mail::send('auth.emails.password',$data, function($message){
    		$message->to('delossantoscraven@gmail.com' , 'Craven Delos Santos')->subject('Reset your password');
    		$message->from('delossantoscraven@gmail.com', 'SAO');
    	});
    	echo "email  sent!";
    }
}
