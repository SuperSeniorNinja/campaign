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

class FeedbackController extends Controller
{   
    protected $guard = 'admin';
    public function index(Request $request)
    {
        if(Auth::check())
        {   
            $survey;
            Session::put('active_menu', "step1");
            $survey = Survey::find_survey_by_userid(Auth::user()->id);
            if($survey == "noexist")
               {
                    $survey = array();
                    $survey['banner'] = "/img/survey_header.png";
                    $survey['title'] = "Hello. Please complete up to two custom survey questions below.";
                    $survey['description'] = "Hello. Please complete up to two custom survey questions below.";
                    $survey['question1'] = "President Donald Trump is doing a good job handling the coronavirus outbreak.";
                    $survey['question2'] = "Governor J.B Pritzker is doing a good job handling the coronavirus outbreak.";
                    $survey['question3'] = "I am concerned that I (or someone close to me) has or will get the coronavirus.";
                    $survey['question4'] = "I am afraid that if I (or a member of my family) gets coronavirus, we won't be able to pay the medical bills.";
                    $survey['question5'] = "Custom Question1";
                    $survey['question6'] = "Custom Question2";
               }            
            return view('members/step1')->with(array('survey'=>$survey));
        }
        else
            return redirect()->route('home');
    }

    public function Submit_feedback(Request $request)
    {           
        $posted_feedback = $request->all();
        $from_where = $posted_feedback["from"];
        $identifier;
        if($from_where == "Email")
            $identifier = "Email";
        else
            $identifier = "Phone Number";
        if(!isset($posted_feedback["qa5_answer"]))
            $posted_feedback["qa5_answer"] = "-";
        if(!isset($posted_feedback["qa6_answer"]))
            $posted_feedback["qa6_answer"] = "-";
        if(!isset($posted_feedback["qa7_answer"]))
            $posted_feedback["qa7_answer"] = "-";
        $survey = Survey::find_survey_by_id($posted_feedback['survey_id']);
        $user_id = $survey['user_id'];
        $doc_path = public_path('uploads')."/users/".$user_id;
        $feedback_file = $doc_path.'/'.$user_id.'-feedbacks.csv';

        $original_file = $doc_path.'/'.$user_id.'.csv';
        //add header columns for attaching feedbacks to audience data
        if(!is_file($feedback_file))
        {
            copy($original_file, $feedback_file);
            $arr = file($feedback_file);
            $first_line = $arr[0];
            $first_line_parts = explode(',', $first_line);
            $last_element_index = count($first_line_parts) - 1;
            $first_line_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($first_line_parts[$last_element_index]));
            /*array_push($first_line_parts, "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");*/
            array_push($first_line_parts, "Email sent?", "Email status", "Sms sent?", "Sms status", "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");
            $arr[0] = implode(',', $first_line_parts)."\n";
            file_put_contents($feedback_file, implode($arr));
        }
        //find email in audience data and attach feedback to that user.
        $arr = file($feedback_file);
        $updated_flag = false;
        for($i = 1; $i < count($arr); $i++)
        {
            $row = $arr[$i];
            $row_parts = explode(',', $row);
            $firstline = explode(',', $arr[0]);
            if($from_where == "Email")
            {
                if (in_array($posted_feedback["sender"], $row_parts)) 
                {   
                    $index = $i;
                    $last_element_index = count($row_parts) - 1;
                    $row_parts[$last_element_index] = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', trim($row_parts[$last_element_index]));
                    $qa1_answer_column_index = array_search('qa1_answer', $firstline);
                    //$row_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($row_parts[$last_element_index]));
                    if(count($row_parts) < count($firstline))
                    {   
                        for($z = count($row_parts); $z < $qa1_answer_column_index; $z++)
                        {
                            $row_parts[$z] = " ";
                        }
                        $row_parts[$qa1_answer_column_index] = $posted_feedback["qa1_answer"];
                        $row_parts[$qa1_answer_column_index + 1] = $posted_feedback["qa2_answer"];
                        $row_parts[$qa1_answer_column_index + 2] = $posted_feedback["qa3_answer"];
                        $row_parts[$qa1_answer_column_index + 3] = $posted_feedback["qa4_answer"];
                        $row_parts[$qa1_answer_column_index + 4] = $posted_feedback["qa5_answer"];
                        $row_parts[$qa1_answer_column_index + 5] = $posted_feedback["qa6_answer"];
                        $row_parts[$qa1_answer_column_index + 6] = $posted_feedback["qa7_answer"];
                        $row_parts[$qa1_answer_column_index + 7] = $from_where.' response';

                        //array_push($row_parts, $posted_feedback["qa1_answer"], $posted_feedback["qa2_answer"], $posted_feedback["qa3_answer"], $posted_feedback["qa4_answer"], $posted_feedback["qa5_answer"], $posted_feedback["qa6_answer"], $posted_feedback["qa7_answer"], $from_where.' response');
                    }
                    else
                    {
                        $row_parts[$last_element_index] = $from_where.' response';
                        $row_parts[$last_element_index - 1] = $posted_feedback["qa7_answer"];
                        $row_parts[$last_element_index - 2] = $posted_feedback["qa6_answer"];
                        $row_parts[$last_element_index - 3] = $posted_feedback["qa5_answer"];
                        $row_parts[$last_element_index - 4] = $posted_feedback["qa4_answer"];
                        $row_parts[$last_element_index - 5] = $posted_feedback["qa3_answer"];
                        $row_parts[$last_element_index - 6] = $posted_feedback["qa2_answer"];
                        $row_parts[$last_element_index - 7] = $posted_feedback["qa1_answer"];
                    }
                    $arr[$index] = implode(',', $row_parts)."\n";                    
                    file_put_contents($feedback_file, implode($arr));
                    $updated_flag = true;
                    break;
                }
            }
            else
            {
                for ($j=0; $j < count($row_parts); $j++) {
                    $true_val = preg_replace( '/[^0-9]/', '', $row_parts[$j]); 
                    if(strlen($posted_feedback["sender"]) > 10)
                        $posted_feedback["sender"] = substr($posted_feedback["sender"],1);
                    if (strpos($true_val, $posted_feedback["sender"]) !== false) {
                        $index = $i;
                        $last_element_index = count($row_parts) - 1;
                        $row_parts[$last_element_index] = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', trim($row_parts[$last_element_index]));
                        $qa1_answer_column_index = array_search('qa1_answer', $firstline);
                        //$row_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($row_parts[$last_element_index]));
                        if(count($row_parts) < count($firstline))
                        {
                            for($z = count($row_parts); $z < $qa1_answer_column_index; $z++)
                                $row_parts[$z] = " ";
                            $row_parts[$qa1_answer_column_index] = $posted_feedback["qa1_answer"];
                            $row_parts[$qa1_answer_column_index + 1] = $posted_feedback["qa2_answer"];
                            $row_parts[$qa1_answer_column_index + 2] = $posted_feedback["qa3_answer"];
                            $row_parts[$qa1_answer_column_index + 3] = $posted_feedback["qa4_answer"];
                            $row_parts[$qa1_answer_column_index + 4] = $posted_feedback["qa5_answer"];
                            $row_parts[$qa1_answer_column_index + 5] = $posted_feedback["qa6_answer"];
                            $row_parts[$qa1_answer_column_index + 6] = $posted_feedback["qa7_answer"];
                            $row_parts[$qa1_answer_column_index + 7] = $from_where.' response';
                            //array_push($row_parts, $posted_feedback["qa1_answer"], $posted_feedback["qa2_answer"], $posted_feedback["qa3_answer"], $posted_feedback["qa4_answer"], $posted_feedback["qa5_answer"], $posted_feedback["qa6_answer"], $posted_feedback["qa7_answer"], $from_where.' response');
                        }
                        else
                        {
                            $row_parts[$last_element_index] = $from_where.' response';
                            $row_parts[$last_element_index - 1] = $posted_feedback["qa7_answer"];
                            $row_parts[$last_element_index - 2] = $posted_feedback["qa6_answer"];
                            $row_parts[$last_element_index - 3] = $posted_feedback["qa5_answer"];
                            $row_parts[$last_element_index - 4] = $posted_feedback["qa4_answer"];
                            $row_parts[$last_element_index - 5] = $posted_feedback["qa3_answer"];
                            $row_parts[$last_element_index - 6] = $posted_feedback["qa2_answer"];
                            $row_parts[$last_element_index - 7] = $posted_feedback["qa1_answer"];
                        }
                        $arr[$index] = implode(',', $row_parts)."\n";
                        file_put_contents($feedback_file, implode($arr));
                        $updated_flag = true;
                        break;
                    }
                }
            }
        }       
        if($updated_flag == false)
        {   
            $firstline = explode(',', $arr[0]);
            $temp = array();
            for($i = 0; $i < count($firstline); $i++)
            {
                $temp[$i] = "unknown";
            }
            $index = array_search($identifier, $firstline);
            $temp[$index] = $posted_feedback["sender"];
            $response_index = count($firstline) - 8;
            $temp[$response_index] = $posted_feedback["qa1_answer"];
            $temp[$response_index + 1] = $posted_feedback["qa2_answer"];
            $temp[$response_index + 2] = $posted_feedback["qa3_answer"];
            $temp[$response_index + 3] = $posted_feedback["qa4_answer"];
            $temp[$response_index + 4] = $posted_feedback["qa5_answer"];
            $temp[$response_index + 5] = $posted_feedback["qa6_answer"];
            $temp[$response_index + 6] = $posted_feedback["qa7_answer"];
            $temp[$response_index + 7] = $from_where.' response';
            $num_rows = count($arr);
            $arr[$num_rows] = implode(',', $temp)."\n";
            file_put_contents($feedback_file, implode($arr));
            $updated_flag = true;
        }
        $feedback = Feedback::save_feedback($posted_feedback);
        return redirect()->route('thankyou');
        /*return redirect()->back()->with('success', "Thank you for taking our survey. Your feedback was successfully submitted.");*/
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

    public function show_thankyou(Request $request)
    {
        return view('front/thankyou');
    }
}
