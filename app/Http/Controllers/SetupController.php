<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;
use Validator;
use Session;
use App\User;
use App\Survey;

class SetupController extends Controller
{
    public function index(Request $request)
    {
    	if(Auth::check())
      {
        Session::put('active_menu', "step2");
        return view('members/step2');
      }            
      
      else
        return redirect()->route('home');
    }

    public function Save_config(Request $request)
    {
      $config_data = $request->all();
      $result = User::Save_config($config_data, Auth::user()->id);
      if($result == 'success')
        return back()->with( 'success', "Configuration was successfully saved." );
    }

    public function SendSms(Request $request)
    {	
    	// Your Account SID and Auth Token from twilio.com/console
       $sid    = env( 'TWILIO_SID' );
       $token  = env( 'TWILIO_TOKEN' );
       $from = env( 'TWILIO_FROM' );
       $client = new Client( $sid, $token );
       $validator = Validator::make($request->all(), [
           'number' => 'required',
           'message' => 'required'
       ]);       

       if ( $validator->passes() ) {
       	    $number = $request->input('number');
            $message = $request->input('message');
       		  $client->messages->create(
                $number,
                [
                    "body" => $message,
                    "from" => $from
                ]
            );
            return back()->with( 'success', " messages sent!" );
       } else {
           return back()->withErrors( $validator );
       }
    }
}
 