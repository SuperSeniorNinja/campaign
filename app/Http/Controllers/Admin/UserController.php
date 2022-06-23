<?php

namespace App\Http\Controllers\Admin;

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


    public function index(Request $request)
    {   
        Session::put('active_menu', "admin.users");
        $users = User::orderBy('id')->get();
        return view('admin/users/list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $userData = $request->all();

        if (!$request->has('password')) {
            $userData['password'] = null;
        }
        $result = User::findUser($userData['email'], $userData['password']);
        if($result == "noexist")
        {
            $userData = $request->only(['username', 'email', 'level', 'password']);
            $userData['password'] = bcrypt($userData['password']);
            User::create($userData);
            return redirect()->back()->with('success', 'User: <b style="color: #000;">'.$userData['username'] .'</b> was added successfully.');
            
        }
        else
            return redirect()->back()->with('error', 'User: <b style="color: #000;">'.$userData['email'] .'</b> already exists!');
    }

    public function edit(User $user)
    {
        return view('admin/users/edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {        
        //$userData = array_filter($request->only(['username', 'email', 'level', 'password']));

        /*if ($request->has('password')) {
            $userData['password'] = bcrypt($userData['password']);
        }*/
        $userData = $request->all();
        $user->update($userData);
        return redirect()->back()->with('success', 'User:  <b style="color: #000;">'.$userData['username'] .'</b>  was  updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User:  <b style="color: #000;">'.$user->username.'</b>  was deleted successfully');
    }

    public function loginAsUser($id)
    {
        $user = User::find($id);
        Auth::logout();
        Auth::login($user);
        return redirect()->route('dashboard');
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

    public function show_permission_error()
    {
        return view('errors/500');
    }

    public function Update_feedback_available_status(Request $request)
    {
        $result = User::Update_feedback_available_status($request["id"], $request["feedback_available"]);
        echo $result;
    }
}
