<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Csv;
use App\User;
use App\EmailCampaign;
use App\Survey;

class LaunchController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check())
        {   
            Session::put('active_menu', "step3");
            $csvs = Csv::find_csv_by_userid(Auth::user()->id);
            $survey = Survey::find_survey_by_userid(Auth::user()->id);

            $emails = [];
            $phones = [];
            if($csvs != "noexist")
            {
                $real_csvs = json_decode($csvs, true);
                $phone_index = 0;
                for($i = 0; $i < count($real_csvs);$i++)
                {
                    if(!empty($real_csvs[$i]['email']) && $real_csvs[$i]["email_sent"] != "Sent")
                        $emails[] = $real_csvs[$i]['email'];
                    
                    if(!empty($real_csvs[$i]['phone']) && $real_csvs[$i]["sms_sent"] != "Sent")
                    {   
                        $phones[$phone_index]['id'] = $real_csvs[$i]['id'];
                        $phones[$phone_index]['phone'] = $real_csvs[$i]['phone'];
                        $phones[$phone_index]['sms_sent'] = $real_csvs[$i]['sms_sent'];
                        $phone_index++;
                    }
                }
                $e_count = count($emails);
                $s_count = count($phones);
                if(!isset($survey->publish_link))
                    return redirect('step1')->with('msg','Please save a survey to generate a survey link.');
                    /*return redirect()->route('step1')->withSuccess('Please save a survey to generate a survey link.'
                        array(
                            'success'=> 'Please save a survey to generate a survey link.',
                            'response' => 0
                        ));*/
                    //return view("members/step1")->with('success', 'Please save a survey to generate a survey link.', 'response' );
                else
                    return view("members/step4", ['status' => 'success', 'e_count' => $e_count, 's_count' => $s_count, 'publish_link' => $survey->publish_link, 'phones'=> $phones]);
            }
            else
                return view("members/step4", ['status' => 'noexist']);
            //return view("members/step4", ['emails' => $emails, 'phones' => $phones]);
        }
        else
            return redirect()->route('home');
    }

    public function launch_survey(Request $request)
    {   
        $doc_path = public_path('uploads')."/users/".Auth::user()->id;
        $original_file = $doc_path.'/'.Auth::user()->id.'.csv';
        $target_file = $doc_path.'/'.Auth::user()->id.'-feedbacks.csv';
        //add header columns for attaching feedbacks to audience data
        if(!is_file($target_file))
        {
            copy($original_file, $target_file);
            $arr = file($target_file);
            $first_line = $arr[0];
            $first_line_parts = explode(',', $first_line);
            $last_element_index = count($first_line_parts) - 1;
            $first_line_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($first_line_parts[$last_element_index]));
            array_push($first_line_parts, "Email sent?", "Email status", "Sms sent?", "Sms status", "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");
            $arr[0] = implode(',', $first_line_parts)."\n";
            file_put_contents($target_file, implode($arr));
        }
        

        $csvs = Csv::find_csv_by_userid(Auth::user()->id);
        $emails = [];
        $phones = [];
        $csv_email_ids = [];
        $csv_phone_ids = [];
        if($csvs != "noexist")
        {
            $real_csvs = json_decode($csvs, true);
            for($i = 0; $i < count($real_csvs);$i++)
            {
                if(!empty($real_csvs[$i]['email']) && $real_csvs[$i]['email_sent'] !="Sent")
                {
                    $emails[] = $real_csvs[$i]['email'];
                    $csv_email_ids[] = $real_csvs[$i]['id'];
                }
                if(!empty($real_csvs[$i]['phone']) && $real_csvs[$i]['sms_sent'] !="Sent")
                {
                    $phones[] = $real_csvs[$i]['phone'];
                    $csv_phone_ids[] = $real_csvs[$i]['id'];
                }
            }            
        }
        //get survey link of current user
        $survey = Survey::find_survey_by_userid(Auth::user()->id);
        $publish_link = $survey['publish_link'];
        $banner = $survey['banner'];
        if($banner == "NULL" || empty($banner))
            $banner = '/uploads/users/4/4-banner.jpg';
        $description = $survey['description'];
        //get email/sms configuration data
        $user = User::get_user_by_id(Auth::user()->id);
        $e_body = $user['e_body'];
        $e_subject = $user['e_subject'];
        $e_sender = $user['e_sender'];
        $s_body = $user['s_body'];

        $successful_emails = [];
        $successful_phones = [];
        
        if(count($emails) > 0)
        {
            for($i = 0; $i < count($emails); $i++)
            {   
                /*if (filter_var($emails[$i], FILTER_VALIDATE_EMAIL)) {
                    $successful_emails[] = EmailCampaign::Send_survey_email($emails[$i], $e_subject, $e_body, $e_sender, $publish_link, $banner, $description);                
                }   */
                $result = EmailCampaign::Send_survey_email($emails[$i], $e_subject, $e_body, $e_sender, $publish_link, $banner, $description);
                $status = array();
                //failed so we should set error message here
                if (strpos($result, 'failure:') !== false) {
                    $response = explode("failure:", $result);
                    $error_msg = $response[1];
                    $status["email_sent"] = "Failed";
                    $status["email_reason"] = $error_msg;
                }
                else
                {
                    $successful_emails[] = $result;
                    $status["email_sent"] = "Sent";
                    $status["email_reason"] = "Success";
                }
                //update email sent status and reason
                Csv::update_sent_status($csv_email_ids[$i], $status);

                //update email sent status to csv
                $arr = file($target_file);
                for($j = 1; $j < count($arr); $j++)
                {
                    $row = $arr[$j];
                    $row_parts = explode(',', $row);
                    $firstline = explode(',', $arr[0]);
                    $last_element_index = count($row_parts) - 1;
                    $row_parts[$last_element_index] = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', trim($row_parts[$last_element_index]));
                    if (in_array($emails[$i], $row_parts)) 
                    {   
                        $email_sent_column_index = array_search('Email sent?', $firstline);
                        if(count($row_parts) < count($firstline))
                        {
                            for($z = count($row_parts); $z < count($firstline); $z++)
                                $row_parts[$z] = " ";
                        }
                        $row_parts[$email_sent_column_index] = $status["email_sent"];
                        $row_parts[$email_sent_column_index + 1] = $status["email_reason"];
                        $arr[$j] = implode(',', $row_parts)."\n";
                        file_put_contents($target_file, implode($arr));
                        break;
                    }
                }
            }
        }
        
        else
            $successful_emails = [];

        if(count($phones) > 0)
        {
            for($j = 0; $j < count($phones); $j++)
               {             
                    $status = array();
                    $phone = preg_replace('/[^0-9]/', '', $phones[$j]);
                    if(strlen($phone) == 10)
                        $phone = "1".$phone;
                    if(!empty($phone))
                    {   
                        $temp_phone = EmailCampaign::Send_survey_sms($phone, $s_body, $publish_link);
                        if (strpos($temp_phone, 'failure:') !== false)
                        {                
                            $response = explode("failure:", $temp_phone);
                            $error_msg = $response[1];
                            $status["sms_sent"] = "Failed";
                            $status["sms_reason"] = $error_msg;
                        }l
                        else
                        {   
                            $status["sms_sent"] = "Sent";
                            $status["sms_reason"] = "Success";
                            $successful_phones[] = $temp_phone;
                        }
                        Csv::update_sent_status($csv_phone_ids[$j], $status);

                        //update sms sent status to csv
                        $arr = file($target_file);
                        for($k = 1; $k < count($arr); $k++)
                        {
                            $row = $arr[$k];
                            $row_parts = explode(',', $row);
                            $firstline = explode(',', $arr[0]);
                            $last_element_index = count($row_parts) - 1;
                            $row_parts[$last_element_index] = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', trim($row_parts[$last_element_index]));
                            if(strlen($phone) > 10)
                                $phone = substr($phone,1);

                            for ($z = 0; $z < count($row_parts); $z++) {
                                $true_val = preg_replace( '/[^0-9]/', '', $row_parts[$z]); 
                                if (strpos($true_val, $phone) !== false) {
                                    $sms_sent_column_index = array_search('Sms sent?', $firstline);
                                    if(count($row_parts) < count($firstline))
                                    {
                                        for($i = count($row_parts); $i < count($firstline); $i++)
                                            $row_parts[$i] = " ";
                                    }
                                    $row_parts[$sms_sent_column_index] = $status["sms_sent"];
                                    $row_parts[$sms_sent_column_index + 1] = $status["sms_reason"];
                                    $arr[$k] = implode(',', $row_parts)."\n";
                                    file_put_contents($target_file, implode($arr));
                                    break;
                                }
                            }
                        } 
                    } 
               }
        }              
        else
            $successful_phones = [];
        echo count($successful_phones).'|'.count($successful_emails);
        /*$msg = "We have sent <b>".count($successful_phones).'</b> phone numbers via text and <b>'.count($successful_emails).'</b> emails.';
        return redirect()->back()->with('success', $msg);*/
        /*$return_val = count($successful_phones).'|'.count($successful_emails);
        return response()->json([
            'response' => $return_val
        ]);*/
    }

    public function p2p_text(Request $request)
    {   
        $doc_path = public_path('uploads')."/users/".Auth::user()->id;
        $original_file = $doc_path.'/'.Auth::user()->id.'.csv';
        $target_file = $doc_path.'/'.Auth::user()->id.'-feedbacks.csv';
        //add header columns for attaching feedbacks to audience data
        if(!is_file($target_file))
        {
            copy($original_file, $target_file);
            $arr = file($target_file);
            $first_line = $arr[0];
            $first_line_parts = explode(',', $first_line);
            $last_element_index = count($first_line_parts) - 1;
            $first_line_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($first_line_parts[$last_element_index]));
            array_push($first_line_parts, "Email sent?", "Email status", "Sms sent?", "Sms status", "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");
            $arr[0] = implode(',', $first_line_parts)."\n";
            file_put_contents($target_file, implode($arr));
        }

        $phone = $request['phone'];
        $phone_id = $request['id'];
        $phone = preg_replace('/[^0-9]/', '', $phone);        
        if(!empty($phone))
        {   
            //get survey link of current user
            $survey = Survey::find_survey_by_userid(Auth::user()->id);
            $publish_link = $survey['publish_link'];
            //get email/sms configuration data
            $user = User::get_user_by_id(Auth::user()->id);
            $s_body = $user['s_body'];
            if(strlen($phone) == 10)
                $phone = "1".$phone;
            $temp_phone = EmailCampaign::Send_survey_sms($phone, $s_body, $publish_link);
            $status = array();
            $response;
            if (strpos($temp_phone, 'failure:') !== false)
            {                
                $response = explode("failure:", $temp_phone);
                $error_msg = $response[1];
                $status["sms_sent"] = "Failed";
                $status["sms_reason"] = $error_msg;
                $response = "failure:".$error_msg;
            }
            else
            {   
                $status["sms_sent"] = "Sent";
                $status["sms_reason"] = "Success";
                $response = "success";
            }
            Csv::update_sent_status($phone_id, $status);
            //update sms sent status to csv
            $arr = file($target_file);
            for($j = 1; $j < count($arr); $j++)
            {
                $row = $arr[$j];
                $row_parts = explode(',', $row);
                $firstline = explode(',', $arr[0]);
                $last_element_index = count($row_parts) - 1;
                $row_parts[$last_element_index] = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', trim($row_parts[$last_element_index]));
                if(strlen($phone) > 10)
                    $phone = substr($phone,1);

                for ($z = 0; $z < count($row_parts); $z++) {
                    $true_val = preg_replace( '/[^0-9]/', '', $row_parts[$z]); 
                    if (strpos($true_val, $phone) !== false) {
                        $sms_sent_column_index = array_search('Sms sent?', $firstline);
                        if(count($row_parts) < $sms_sent_column_index)
                        {
                            for($z = count($row_parts); $z < count($firstline); $z++)
                                $row_parts[$z] = " ";
                        }
                        $row_parts[$sms_sent_column_index] = $status["sms_sent"];
                        $row_parts[$sms_sent_column_index + 1] = $status["sms_reason"];
                        //echo "sms_sent INDEX:".$sms_sent_column_index.'<br>';
                        //echo "sms_reason INDEX:".($sms_sent_column_index + 1).'<br>';                        
                        $arr[$j] = implode(',', $row_parts)."\n";
                        //var_dump($arr[$j]);
                        //exit();
                        file_put_contents($target_file, implode($arr));
                        echo $response;
                        break;
                    }
                }
            }            
        }
    }

    public function launch_all_emails(Request $request)
    {   
        $doc_path = public_path('uploads')."/users/".Auth::user()->id;
        $original_file = $doc_path.'/'.Auth::user()->id.'.csv';
        $target_file = $doc_path.'/'.Auth::user()->id.'-feedbacks.csv';
        //add header columns for attaching feedbacks to audience data
        if(!is_file($target_file))
        {
            copy($original_file, $target_file);
            $arr = file($target_file);
            $first_line = $arr[0];
            $first_line_parts = explode(',', $first_line);
            $last_element_index = count($first_line_parts) - 1;
            $first_line_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($first_line_parts[$last_element_index]));
            /*array_push($first_line_parts, "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");*/
            array_push($first_line_parts, "Email sent?", "Email status", "Sms sent?", "Sms status", "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");
            $arr[0] = implode(',', $first_line_parts)."\n";
            file_put_contents($target_file, implode($arr));
        }
        $arr = file($target_file);
        $first_line = $arr[0];

        if (strpos($first_line, 'Email sent?') == false) {
            //add header columns for attaching feedbacks to audience data
            copy($original_file, $target_file);
            
            $first_line_parts = explode(',', $first_line);
            $last_element_index = count($first_line_parts) - 1;
            $first_line_parts[$last_element_index] = preg_replace('/[\n\r]+/', ',', trim($first_line_parts[$last_element_index]));
            /*array_push($first_line_parts, "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");*/
            array_push($first_line_parts, "Email sent?", "Email status", "Sms sent?", "Sms status", "qa1_answer", "qa2_answer", "qa3_answer", "qa4_answer", "qa5_answer", "qa6_answer", "qa7_answer", "from_where");
            $arr[0] = implode(',', $first_line_parts)."\n";
            file_put_contents($target_file, implode($arr));
        }

        $csvs = Csv::find_csv_by_userid(Auth::user()->id);
        $emails = [];
        $csv_email_ids = [];
        if($csvs != "noexist")
        {
            $real_csvs = json_decode($csvs, true);
            for($i = 0; $i < count($real_csvs);$i++)
            {
                if(!empty($real_csvs[$i]['email']) && $real_csvs[$i]['email_sent'] !="Sent")
                {
                    $emails[] = $real_csvs[$i]['email'];
                    $csv_email_ids[] = $real_csvs[$i]['id'];
                }
            }            
        }
        //get survey link of current user
        $survey = Survey::find_survey_by_userid(Auth::user()->id);
        $publish_link = $survey['publish_link'];
        $banner = $survey['banner'];
        $description = $survey['description'];
        //get email/sms configuration data
        $user = User::get_user_by_id(Auth::user()->id);
        $e_body = $user['e_body'];
        $e_subject = $user['e_subject'];
        $e_sender = $user['e_sender'];
        $s_body = $user['s_body'];

        $successful_emails;        
        if(count($emails) > 0)
        {
            for($i = 0; $i < count($emails); $i++)
            {   
                /*if (filter_var($emails[$i], FILTER_VALIDATE_EMAIL)) {
                    $successful_emails[] = EmailCampaign::Send_survey_email($emails[$i], $e_subject, $e_body, $e_sender, $publish_link, $banner, $description);                
                } */
                $result = EmailCampaign::Send_survey_email($emails[$i], $e_subject, $e_body, $e_sender, $publish_link, $banner, $description);
                $status = array();
                //failed so we should set error message here
                if (strpos($result, 'failure:') !== false) {
                    $response = explode("failure:", $result);
                    $error_msg = $response[1];
                    $status["email_sent"] = "Failed";
                    $status["email_reason"] = $error_msg;
                }
                else
                {
                    $successful_emails[] = $result;
                    $status["email_sent"] = "Sent";
                    $status["email_reason"] = "Success";
                }
                //update email sent status and reason
                Csv::update_sent_status($csv_email_ids[$i], $status);

                //update email sent status to csv
                $arr = file($target_file);
                for($j = 1; $j < count($arr); $j++)
                {
                    $row = $arr[$j];
                    $row_parts = explode(',', $row);
                    $firstline = explode(',', $arr[0]);
                    $last_element_index = count($row_parts) - 1;
                    $row_parts[$last_element_index] = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', trim($row_parts[$last_element_index]));
                    if (in_array($emails[$i], $row_parts)) 
                    {   
                        $index = $j;
                        $email_sent_column_index = array_search('Email sent?', $firstline);
                        if(count($row_parts) < count($firstline))
                        {
                            for($z = count($row_parts); $z < count($firstline); $z++)
                                $row_parts[$z] = " ";
                        }
                        $row_parts[$email_sent_column_index] = $status["email_sent"];
                        $row_parts[$email_sent_column_index + 1] = $status["email_reason"];
                        $arr[$index] = implode(',', $row_parts)."\n";
                        file_put_contents($target_file, implode($arr));
                        break;
                    }
                }
            }
        }        
        else
            $successful_emails = [];
        echo count($successful_emails);
    }

    public function launch_all_emails_and_texts()
    {
        Csv::launch_all_emails_and_texts();
        
    }
}
