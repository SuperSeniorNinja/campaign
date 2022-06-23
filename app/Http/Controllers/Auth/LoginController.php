<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\EmailCampaign;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailable;
use DB;
use Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    public function showLoginForm(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {   
        $result = User::findUser($request['email'], $request['password']);        
        echo $result;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('home');
    }

    public function forget_pass(Request $request)
    {   
        //check if this email exists in db
        $result = User::findUser($request['email'], "");
        if($result == "wrongpass")
        {   
            $mail_sent_result = EmailCampaign::SendForgetPassword($request['email']);
            echo $mail_sent_result;
        }
        else
            echo "noexist";        
    }

    public function showPasswordResetForm($token)
    {
        $tokenData = DB::table('password_resets')->where('token', $token)->first();
        if ( !$tokenData ) return redirect()->to('home'); //redirect them anywhere you want if the token does not exist.
        return view('auth.reset_password');
    }

    public function resetPassword(Request $request, $token)
    {
        $password = $request->password;
        $tokenData = DB::table('password_resets')->where('token', $token)->first();

        $user = User::where('email', $tokenData->email)->first();
        if ( !$user ) return redirect()->to('home'); //or wherever you want

        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //do we log the user directly or let them login and try their password for the first time ? if yes 
        Auth::login($user);

        // If the user shouldn't reuse the token later, delete the token 
        DB::table('password_resets')->where('email', $user->email)->delete();
        return redirect()->route('step1');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
