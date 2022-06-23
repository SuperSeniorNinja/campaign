<?php

namespace App\Http\Controllers;

use App\User;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Redirect;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        if(!Auth::check())
            return redirect()->route('home');
    }

    
    public function update(Request $request, User $user)
    {        
        //$userData = array_filter($request->only(['username', 'email', 'level', 'password']));

        /*if ($request->has('password')) {
            $userData['password'] = bcrypt($userData['password']);
        }*/
        $userData = $request->all();
        $result = User::save_userdata($userData);
        //return redirect()->route('setting');
        return redirect()->back()->with('success', 'User:  <b style="color: #000;">'.$userData['username'] .'</b>  was  updated successfully.');
    }
    
    public function myprofile(User $user)
    {   
        if(Auth::check())
        {   
            Session::put('active_menu', "myprofile");
            return view('members/account/edit');
        }
        else
            return redirect()->route('home');
        
    }
}
