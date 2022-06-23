<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class Survey extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'banner', 'title', 'description', 'question1', 'question2', 'question3', 'question4', 'question5', 'question6', 'question7', 'question8', 'question9', 'publish_link'
    ];

    static function CreateorUpdate($data) {
        //DB::beginTransaction();
        $survey = Survey::where(['user_id' => $data['user_id']])->first();
        if ($survey == null) {
            $survey = Survey::create($data);            
            $publish_link = config('app.url').'/'.base64_encode("survey").'/'.base64_encode($survey->id);
            $survey->publish_link = $publish_link;
            $survey->save();
            return "success";
        }
        else
        {   
            $survey->fill($data);
            $survey->save();
            return "updated";
        }
        //DB::commit();        
    }

    static function find_survey_by_userid($userid)
    {
        $survey = Survey::where(['user_id' => $userid])->first();
        if ($survey != null)
            return $survey;
        else
            return "noexist";
    }

    static function find_survey_by_id($id)
    {
        $survey = Survey::where(['id' => $id])->first();
        if ($survey != null)
            return $survey;
        else
            return "noexist";
    }

    /*static function find_userid_by_surveylink($link)
    {
        $survey = Survey::where(['publish_link' => $link])->first();
        if ($survey != null)
            return $survey;
        else
            return "noexist";
    }*/
}
