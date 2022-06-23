<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class Feedback extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_id', 'email', 'qa1_answer', 'qa2_answer', 'qa3_answer', 'qa4_answer', 'qa5_answer', 'qa6_answer', 'qa7_answer', 'qa8_answer', 'qa9_answer', 'status'
    ];

    static function find_feedback_by_surveyid($surveyid)
    {
        $feedbacks = Feedback::where(['survey_id' => $surveyid])->where(['status' => 'new'])->get();
        return $feedbacks;
    }

    static function save_feedback($data)
    {   
        $data['email'] = $data['sender'];
        $data['status'] = "new";
        unset($data['sender']);
        $feedback = Feedback::where([
            ['email', '=', $data['email']],
            ['survey_id', '=', $data['survey_id']]
        ])->first();
        if ($feedback == null) {
            $feedback = Feedback::create($data);
            $feedback->save();
            return "success";
        }
        else
        {   
            $feedback->fill($data);
            $feedback->save();
            return "updated";
        }
    }

    static function update_status($survey)
    {   
        if(!empty($survey))
        {   
            $feedback = Feedback::where('survey_id', $survey["id"])
                                ->delete();
                                /*->where('status', 'new')
                                ->update(['status' => "old"]);*/
        }
    }
}
