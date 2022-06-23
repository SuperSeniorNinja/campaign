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
use App\User;
use App\Csv;

class ReportController extends Controller
{   
    protected $guard = 'admin';
    public function index(Request $request)
    {
        if(Auth::check())
        {   
            $survey;
            Session::put('active_menu', "admin.reports");
            $users = User::where(['level' => "user"])->orderBy('id')->get();
            $reports = array();
            for($i = 0; $i < count($users); $i++)
            {
                $reports[$i]['id'] = $users[$i]["id"];
                $reports[$i]['username'] = $users[$i]["username"];
                $survey = Survey::find_survey_by_userid($users[$i]["id"]);
                if($survey != "noexist")
                {
                    $survey_id = $survey['id'];                
                    $reports[$i]['publish_link'] = $survey['publish_link'];
                    
                    
                    $reports[$i]['sent_emails'] = Csv::Get_sent_emails($users[$i]["id"]);
                    $reports[$i]['sent_sms'] = Csv::Get_sent_sms($users[$i]["id"]);
                    /*echo "sent emails: ".$reports[$i]['sent_emails'].'<br>';
                    echo "sent_sms: ".$reports[$i]['sent_sms'].'<br>';
                    exit();*/
                    /*
                    $csvs = Csv::find_csv_by_userid($users[$i]["id"]);
                    $emails = [];
                    $phones = [];
                    if($csvs != "noexist")
                    {                       
                        $real_csvs = json_decode($csvs, true);                    
                        for($z = 0; $z < count($real_csvs);$z++)
                        {
                            if(!empty($real_csvs[$z]['email']) && $real_csvs[$z]['email_sent'] == "Sent")
                                $emails[] = $real_csvs[$z]['email'];
                            if(!empty($real_csvs[$z]['phone']) && $real_csvs[$z]['sms_sent'] == "Sent")
                                $phones[] = $real_csvs[$z]['phone'];
                        }
                        $reports[$i]['sent_emails'] = count($emails);
                        $reports[$i]['sent_sms'] = count($phones);
                        //$reports[$i]['sent_date'] = $real_csvs[0]['created_at'];
                    }
                    else
                    {
                        $reports[$i]['sent_emails'] = 0;
                        $reports[$i]['sent_sms'] = 0;
                        //$reports[$i]['sent_date'] = '-';
                    }*/
                    if($reports[$i]['sent_emails'] == 0 && $reports[$i]['sent_sms'] == 0)
                    {   
                        $reports[$i]['feedback_link'] = "noexist";
                        $reports[$i]['num_responses'] = 0;
                    }
                    else
                    {
                        $feedbacks = Feedback::find_feedback_by_surveyid($survey_id);
                        if($feedbacks == "[]")
                        {
                            $reports[$i]['num_responses'] = 0;
                            $reports[$i]['feedback_link'] = "noexist";
                        }
                        else
                        {
                            $reports[$i]['num_responses'] = count(json_decode($feedbacks, true));                            
                            $path = '/uploads/users/'.$users[$i]["id"].'/'.$users[$i]["id"].'-feedbacks.csv';                            
                            if(is_file(public_path('/uploads/users/'.$users[$i]["id"].'/'.$users[$i]["id"].'-feedbacks.csv')))
                                $reports[$i]['feedback_link'] = $path;
                            else
                                $reports[$i]['feedback_link'] = "noexist";
                        }
                    }
                }
                else
                {
                    $reports[$i]['publish_link'] = "noexist";
                    $reports[$i]['num_responses'] = 0;
                    $reports[$i]['sent_emails'] = 0;
                    $reports[$i]['sent_sms'] = 0;
                    //$reports[$i]['sent_date'] = '-';
                    $reports[$i]['feedback_link'] = "noexist";
                }
            }
            /*var_dump($reports);
            exit();*/
            return view('admin/reports', ['reports' => $reports]);
        }
        else
            return redirect()->route('home');
    }

    public function Show_feedbacks_for_each_user(Request $request, $id)
    {   
        Session::put('active_menu', "show_feedbacks");
        //get survey_id from user id from surveys table
        $survey = Survey::find_survey_by_userid($id);
        $survey_id = $survey['id'];

        $user = User::get_user_by_id($id);
        $feedbacks = Feedback::find_feedback_by_surveyid($survey_id);          
        if($feedbacks == "[]")
        {   
            return view('admin/users/feedback')->with(array('response' => 0, 'survey'=> $survey, 'user' => $user));
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
            if(isset(array_count_values($qa3_answer)['Agree']))
                $qa3_agree = array_count_values($qa3_answer)['Agree'];
            else
                $qa3_agree = 0;
            if(isset(array_count_values($qa3_answer)['Disagree']))
                $qa3_disagree = array_count_values($qa3_answer)['Disagree'];
            else
                $qa3_disagree = 0;
            if(isset(array_count_values($qa4_answer)['Agree']))
                $qa4_agree = array_count_values($qa4_answer)['Agree'];
            else
                $qa4_agree = 0;
            if(isset(array_count_values($qa4_answer)['Disagree']))
                $qa4_disagree = array_count_values($qa4_answer)['Disagree'];
            else
                $qa4_disagree = 0;
            if(!empty($qa5_answer))
            {
                if(isset(array_count_values($qa5_answer)['Agree']))
                    $qa5_agree = array_count_values($qa5_answer)['Agree'];
                else
                    $qa5_agree = 0;
                if(isset(array_count_values($qa5_answer)['Disagree']))
                    $qa5_disagree = array_count_values($qa5_answer)['Disagree'];
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
                if(isset(array_count_values($qa6_answer)['Agree']))
                    $qa6_agree = array_count_values($qa6_answer)['Agree'];
                else
                    $qa6_agree = 0;
                if(isset(array_count_values($qa6_answer)['Disagree']))
                    $qa6_disagree = array_count_values($qa6_answer)['Disagree'];
                else
                    $qa6_disagree = 0;
            }
            else
            {
                $qa6_agree = 0;
                $qa6_disagree = 0;
            }
            return view('admin/users/feedback')->with(
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
                    'response' => count($feedbacks),
                    'user' => $user
                ));
        }
    }

    public function delete_feedback(Request $request, $id)
    {
        $user_id = $id;
        $doc_path = public_path('uploads')."/users/".$user_id;
        $doc_path = $doc_path.'/'.$user_id.'-feedbacks.csv';
        if(is_file(public_path('/uploads/users/'.$user_id.'/'.$user_id.'-feedbacks.csv')))
        {
            unlink($doc_path);
            return redirect()->back()->with('success', 'Report was deleted successfully.');
        }
        else
            return redirect()->back()->with('success', 'Report does not exist.');
    }
}
