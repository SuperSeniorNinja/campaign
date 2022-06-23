<?php

namespace App\Http\Controllers;

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
            Session::put('active_menu', "step1");
            $survey = Survey::find_survey_by_userid(Auth::user()->id);
            if($survey == "noexist")
               {
                    $survey = Survey::find_survey_by_userid("admin");
                    return view('members/step1')->with(array('survey'=>$survey, 'response' => 0));
               }
            else
            {
                $survey_id = $survey['id'];
                $feedbacks = Feedback::find_feedback_by_surveyid($survey_id);                
                        
                if($feedbacks == "[]")
                {   
                    return view('members/step1')->with(array('response' => 0, 'survey'=> $survey));
                }
                else
                {
                    $feedbacks = json_decode($feedbacks, true);
                    $qa1_answer = [];
                    $qa2_answer = [];
                    $qa3_answer = [];
                    $qa4_answer = [];
                    $qa5_answer = [];
                    $qa6_answer = [];
                    $qa7_answer = [];
                    $qa8_answer = [];
                    $qa9_answer = [];
                    for($i = 0; $i < count($feedbacks); $i++)
                    {   
                        $qa1_answer[] = $feedbacks[$i]['qa1_answer'];
                        $qa2_answer[] = $feedbacks[$i]['qa2_answer'];
                        $qa3_answer[] = $feedbacks[$i]['qa3_answer'];
                        $qa4_answer[] = $feedbacks[$i]['qa4_answer'];
                        if(!empty($feedbacks[$i]['qa5_answer']))
                            $qa5_answer[] = $feedbacks[$i]['qa5_answer'];
                        if(!empty($feedbacks[$i]['qa6_answer']))
                            $qa6_answer[] = $feedbacks[$i]['qa6_answer'];
                        if(!empty($feedbacks[$i]['qa7_answer']))
                            $qa7_answer[] = $feedbacks[$i]['qa7_answer'];
                        if(!empty($feedbacks[$i]['qa8_answer']))
                            $qa8_answer[] = $feedbacks[$i]['qa8_answer'];
                        if(!empty($feedbacks[$i]['qa9_answer']))
                            $qa9_answer[] = $feedbacks[$i]['qa9_answer'];
                    }
                    if(isset(array_count_values($qa1_answer)['Agree']))
                        $qa1_agree = array_count_values($qa1_answer)['Agree'];
                    else
                        $qa1_agree = 0;
                    if(isset(array_count_values($qa1_answer)['Disagree']))
                        $qa1_disagree = array_count_values($qa1_answer)['Disagree'];
                    else
                        $qa1_disagree = 0;
                    if(isset(array_count_values($qa2_answer)['Agree']))
                        $qa2_agree = array_count_values($qa2_answer)['Agree'];
                    else
                        $qa2_agree = 0;
                    if(isset(array_count_values($qa2_answer)['Disagree']))
                        $qa2_disagree = array_count_values($qa2_answer)['Disagree'];
                    else
                        $qa2_disagree = 0;
                    if(isset(array_count_values($qa3_answer)['Yes']))
                        $qa3_agree = array_count_values($qa3_answer)['Yes'];
                    else
                        $qa3_agree = 0;
                    if(isset(array_count_values($qa3_answer)['No']))
                        $qa3_disagree = array_count_values($qa3_answer)['No'];
                    else
                        $qa3_disagree = 0;
                    if(isset(array_count_values($qa4_answer)['Yes']))
                        $qa4_agree = array_count_values($qa4_answer)['Yes'];
                    else
                        $qa4_agree = 0;
                    if(isset(array_count_values($qa4_answer)['No']))
                        $qa4_disagree = array_count_values($qa4_answer)['No'];
                    else
                        $qa4_disagree = 0;                    
                    if(!empty($qa5_answer))
                    {
                        if(isset(array_count_values($qa5_answer)['Yes']))
                            $qa5_agree = array_count_values($qa5_answer)['Yes'];
                        else
                            $qa5_agree = 0;
                        if(isset(array_count_values($qa5_answer)['No']))
                            $qa5_disagree = array_count_values($qa5_answer)['No'];
                        else
                            $qa5_disagree = 0;
                    }
                    else
                    {
                        $qa5_agree = 0;
                        $qa5_disagree = 0;
                    }      

                    if(!empty($qa6_answer))
                    {
                        if(isset(array_count_values($qa6_answer)['Yes']))
                            $qa6_agree = array_count_values($qa6_answer)['Yes'];
                        else
                            $qa6_agree = 0;
                        if(isset(array_count_values($qa6_answer)['No']))
                            $qa6_disagree = array_count_values($qa6_answer)['No'];
                        else
                            $qa6_disagree = 0;
                    }
                    else
                    {
                        $qa6_agree = 0;
                        $qa6_disagree = 0;
                    }
                    if(!empty($qa7_answer))
                    {
                        if(isset(array_count_values($qa7_answer)['Yes']))
                            $qa7_agree = array_count_values($qa7_answer)['Yes'];
                        else
                            $qa7_agree = 0;
                        if(isset(array_count_values($qa7_answer)['No']))
                            $qa7_disagree = array_count_values($qa7_answer)['No'];
                        else
                            $qa7_disagree = 0;
                    }
                    else
                    {
                        $qa7_agree = 0;
                        $qa7_disagree = 0;
                    }
                    if(!empty($qa8_answer))
                    {
                        if(isset(array_count_values($qa8_answer)['Yes']))
                            $qa8_agree = array_count_values($qa8_answer)['Yes'];
                        else
                            $qa8_agree = 0;
                        if(isset(array_count_values($qa8_answer)['No']))
                            $qa8_disagree = array_count_values($qa8_answer)['No'];
                        else
                            $qa8_disagree = 0;
                    }
                    else
                    {
                        $qa8_agree = 0;
                        $qa8_disagree = 0;
                    }
                    if(!empty($qa9_answer))
                    {
                        if(isset(array_count_values($qa9_answer)['Yes']))
                            $qa9_agree = array_count_values($qa9_answer)['Yes'];
                        else
                            $qa9_agree = 0;
                        if(isset(array_count_values($qa9_answer)['No']))
                            $qa9_disagree = array_count_values($qa9_answer)['No'];
                        else
                            $qa9_disagree = 0;
                    }
                    else
                    {
                        $qa9_agree = 0;
                        $qa9_disagree = 0;
                    }
                    
                    return view('members/step1')->with(
                        array(
                            'feedbacks'=>$feedbacks,
                            'survey'=>$survey, 
                            'qa1_agree' => $qa1_agree,
                            'qa1_disagree' => $qa1_disagree,
                            'qa2_agree' => $qa2_agree,
                            'qa2_disagree' => $qa2_disagree,
                            'qa3_agree' => $qa3_agree,
                            'qa3_disagree' => $qa3_disagree,
                            'qa4_agree' => $qa4_agree,
                            'qa4_disagree' => $qa4_disagree,
                            'qa5_agree' => $qa5_agree,
                            'qa5_disagree' => $qa5_disagree,
                            'qa6_agree' => $qa6_agree,
                            'qa6_disagree' => $qa6_disagree,
                            'qa7_agree' => $qa7_agree,
                            'qa7_disagree' => $qa7_disagree,
                            'qa8_agree' => $qa8_agree,
                            'qa8_disagree' => $qa8_disagree,
                            'qa9_agree' => $qa9_agree,
                            'qa9_disagree' => $qa9_disagree,
                            'response' => count($feedbacks)
                        ));
                }
            }
            
        }
        else
            return redirect()->route('home');
    }

    public function save_survey(Request $request)
    {   
        $banner;
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $name = Auth::user()->id.'-banner.'.$image->getClientOriginalExtension();
            $target_dir = public_path('uploads').'/users/'.Auth::user()->id.'/';
            if(!is_dir($target_dir))
                mkdir($target_dir, 0777, true);
            $image->move($target_dir, $name);            
            $banner = '/uploads/users/'.Auth::user()->id.'/'.$name;
        }
        $requestData = $request->all();
        if(isset($banner) && !empty($banner))
            $requestData['banner'] = $banner;
        unset($requestData['_token']);
        $result = Survey::CreateorUpdate($requestData);

        $msg = "Survey was created successfully.";
        if($result == "updated")
            $msg = "Survey was updated successfully.";
        return redirect()->back()->with('success', $msg);
        //return view('formpage', ['success' => $msg, 'banner' => $banner ]);
    }

    public function show_survey(Request $request, $id)
    {   /*
        echo "ID:".$id.'<br>';
        echo "From:".$from.'<br>';
        echo "Sender:".$sender.'<br>';
        exit();
        echo request()->route('id').'<br>';
        echo request()->route('from').'<br>';
        exit();
        echo base64_encode("survey").'/{id}/'.base64_encode("from").'/'.base64_encode("sender");
        exit();
        echo base64_encode("survey").'/{id}?'.base64_encode("emails").'={email}&'.base64_encode("sms").'={sms}';
        exit();*/
        $survey = Survey::find_survey_by_id(base64_decode($id));
        if($survey == "noexist")
            return redirect()->route('permission_error');            
        else
        {
            return view('show_survey')->with(array('survey'=>$survey));
        }
    }

    public function show_survey_submit_form(Request $request, $id, $from, $sender)
    {   
        $survey_id = base64_decode($id);
        $from = base64_decode($from);
        $sender = base64_decode($sender);
        $survey = Survey::find_survey_by_id(base64_decode($id));
        if($survey == "noexist")
            return redirect()->route('permission_error');            
        else
        {
            return view('submit_survey')->with(array('survey'=>$survey, 'from' => $from, 'sender' => $sender));
        }
    }
}
