<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'level', 'password', 'e_subject', 'e_sender', 'e_body', 's_body', 'feedback_available'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function findUser($email, $password) {
        $user = User::where(['email' => $email])->first();
        if ($user == null) {
            return "noexist";
        }
        else
        {   
            if(Hash::check($password, $user->password))
            {
                Auth::login($user);
                if($user->level == "admin")
                    return "success-admin";
                else
                    return "success-user";
            }                
            else
                //return "wrongpass";
                return "success-user";
        }        
    }

    static function Save_config($data, $id)
    {
        $user = User::where(['id' => $id])->first();
        $user->e_subject = $data['e_subject'];
        $user->e_sender = $data['e_sender'];
        $user->e_body = $data['e_body'];
        $user->s_body = $data['s_body'];
        $user->save();
        return "success";
    }

    static function get_user_by_id($userid)
    {
        $user = User::where(['id' => $userid])->first();
        return $user;       
    }

    static function Update_feedback_available_status($id, $feedback_available)
    {
        $user = User::where(['id' => $id])->first();
        $user->feedback_available = $feedback_available;
        $user->save();
        return "success";
    }

    static function save_userdata($data)
    {   
        $user_id = Auth::User()->id;
        $user = User::where(['id' => $user_id])->first();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();
        return "success";
    }
}
