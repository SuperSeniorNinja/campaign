<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\EmailCampaign;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailable;
use DB;
use Session;
use App\Survey;
use App\Feedback;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check())
        {   
            $survey;
            Session::put('active_menu', "admin.survey");
            $survey = Survey::find_survey_by_userid("admin");
            if($survey == "noexist")
            {
                $survey = array();
                $survey['banner'] = "/img/survey_header.png";
                $survey['title'] = "Hello. Please complete up to two custom survey questions below.";
                $survey['description'] = "Hello. Please complete up to two custom questions below.";
                $survey['question1'] = "President Donald Trump is doing a good job handling the coronavirus outbreak.";
                $survey['question2'] = "Governor J.B Pritzker is doing a good job handling the coronavirus outbreak.";
                $survey['question3'] = "I am concerned that I (or someone close to me) has or will get the coronavirus.";
                $survey['question4'] = "I am afraid that if I (or a member of my family) gets coronavirus, we won't be able to pay the medical bills.";
                $survey['question5'] = "";
                $survey['question6'] = "";
                $survey['question7'] = "";
                $survey['question8'] = "";                    
                $survey['question9'] = "";                
            }
            return view('admin/survey')->with(array('survey'=>$survey));            
        }
        else
            return redirect()->route('home');
    }

    
}
