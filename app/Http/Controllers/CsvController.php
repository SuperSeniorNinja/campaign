<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;
use Validator;
use Session;
use App\Csv;
use App\Feedback;
use App\Survey;

class CsvController extends Controller
{
    public function index(Request $request)
    {
      if(Auth::check())
      { 
        Session::put('active_menu', "step2");
        Session::put('active_sub_menu', "csv_step");
        return view('members/step3');
      }            
      else
            return redirect()->route('home');
    }
    
    public function fileUpload(Request $request)
    { 
      if($request->hasFile('file')) {
        $request->validate([
            'file' => 'required|max:20480',
        ]);
        $fileName = Auth::user()->id.'.csv';


        $doc_path = public_path('uploads')."/users/".Auth::user()->id;
        if (!is_dir($doc_path.'/')) {
            mkdir($doc_path , 0777, true);
        }
        $request->file->move($doc_path, $fileName);
        
        //default identifiers
        $identifiers;
        $identifiers = array('Don\'t upload', 'Voter File VANID', 'First Name','Last Name','Address','City','State','Zip5','Zip4','Phone Number', 'Email', 'CD', 'SD', 'HD');
        $match_number = 0;
        $action_number = 0;
        //load csv
        $TotalData = [];
        $TotalData_index = 0;
        $csv_html = '';
        $doc_path = $doc_path.'/'.$fileName;
        $handle = fopen($doc_path, "r");
        while (($data = fgetcsv($handle)) !== FALSE) {            
            $TotalData[$TotalData_index] = $data;
            for( $i = 0; $i < count($data); $i++)
              $TotalData[$TotalData_index][$i] = $data[$i];
            $TotalData_index++; 
        }
        fclose($handle);
        $real_data = [];
        $table_header_html = '
        <table class="table-responsive table-bordered">
          <thead>
            <tr style="font-size: 17px;color: #000;">
              <th>Map Column to Identifier</th>
              <th>Status</th>
              <th style="text-align: center;">Identifier</th>
            </tr>
          </thead>
          <tbody>';
        $table_footer_html = '</tbody></table>';
        $mapped_fields_html = '';
        $action_fields_html = '';
        foreach ($TotalData as  $rowkey => $row) {
            foreach($row as $colkey => $col){
                $real_data[$colkey][$rowkey]=$col;
            }
        }
        /*echo json_encode($real_data);
        exit();

        for($j = 0; $j < count($TotalData[$j]); $j++)
          for($i = 0; $i < 5; $i++)
            $real_data[$j][$i] = $TotalData[$i][$j];*/
        if (strpos($real_data[0][0], '[Content_Types].xml') !== false) {
          echo "wrong_file";
          exit();
        }

        
        $mapped_identifier;
        $mapped_identifiers = [];
        $identifiers_select_html;
        $status_html='';
        for( $i = 0;  $i < count($real_data); $i++)
        {           
          $matched_or_action_flag = 'action';
          $temp_row_html = '';
          $temp_row_html.='<tr id="row'.$i.'"><td style="width: 50%;padding: 20px 0px;">';
          for($z = 0; $z < 5; $z++)
          { 
            if(!isset($real_data[$i][$z]))
              $real_data[$i][$z] = "-";
            $temp_row_html.='<label>'.$real_data[$i][$z].'</label><br>';
          }
          $temp_row_html.='</td>';          
          
          //check if header field is in identifiers array or not
          $selected = '';
          $identifiers_select_html = '<select name="row'.$i.'" class="row'.$i.'">';
          $identifiers_select_html.= '<option class="customvalue" value="customvalue">Custom value</option>';
          $identifiers_select_html.= '<option value="none" style="display:none;" selected>Custom value</option>';
          for($j = 0; $j < count($identifiers); $j++)
          { 
            if (stripos($identifiers[$j], $real_data[$i][0]) !== false || stripos($real_data[$i][0], $identifiers[$j]) !== false)
            {
              $matched_or_action_flag = 'mapped';
              $mapped_identifier = $identifiers[$j];
              $mapped_identifiers[$match_number] = $identifiers[$j];
              $match_number++;
              $selected = "selected";
              $identifiers_select_html.='<option value="'.$identifiers[$j].'"'.$selected.'>'.$identifiers[$j].'</option>';             
            }
            else
              $identifiers_select_html.='<option value="'.$identifiers[$j].'">'.$identifiers[$j].'</option>';
          }

          //$identifiers_select_html.='<input type="hidden" name="row'.$i.'" value="'.$mapped_identifier.'">';
          
          $identifiers_select_html.= '</select>';
          
          if($matched_or_action_flag == 'mapped')
            $status_html = '<i class="zwicon-checkmark-circle" style="color: #28d428;"></i>';
          else
            $status_html = '<i class="zwicon-exclamation-triangle" style="color: #f55305;"></i>';

          $temp_row_html.='<td style="font-size: 30px;">'.$status_html.'</td>';
          $temp_row_html.='<td style="width: 50%;text-align: center;color: #000;">'.$identifiers_select_html.'</td>';
          $temp_row_html.='</td></tr>';
          if($matched_or_action_flag == "mapped")
            $mapped_fields_html.= $temp_row_html;
          else
          {
            $action_number++;
            $action_fields_html.= $temp_row_html;
          }
        }
        if(!empty($mapped_fields_html))
          $mapped_fields_html = $table_header_html.$mapped_fields_html.$table_footer_html;
        if(!empty($action_fields_html))
          $action_fields_html = $table_header_html.$action_fields_html.$table_footer_html;

        $mapped_identifier_keys_html = '';
        if(!empty($mapped_identifiers))
        { 
          for($z = 0; $z < count($mapped_identifiers); $z++)
            $mapped_identifier_keys_html.='<a href="#" class="badge badge-secondary">'.$mapped_identifiers[$z].'</a>&nbsp;';
        }
        $csv_html.='
          <div class="row">
            <div class="col-md-12">
              <p class="mgb-30"><span class="match_number_badge">'.$match_number.'</span> column(s) are mapped and will be uploaded. Please correct any errors before continuing.</p>
              '.$mapped_identifier_keys_html.'              
            </div>
          </div>
          <div class="tab-container">
              <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#mapped_identifiers" role="tab" style="font-size: 20px;"><i class="zwicon-checkmark-circle" style="color: #28d428;font-weight: bold;"></i>  Mapped (<span class="match_number">'.$match_number.'</span>) </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#action_needed_identifiers" role="tab" style="font-size: 20px;"><i class="zwicon-exclamation-triangle" style="color: #f55305;font-weight: bold;"></i>  Action Needed (<span class="action_number">'.$action_number.'</span>)</a>
                  </li>
              </ul>
              <form id="csv_head_upload" method="POST" action="/csv_head_upload">
                <input type="hidden" name="token" value="'.base64_encode($doc_path).'">
                <div class="tab-content">                
                    <div class="tab-pane active fade show mapped_field" id="mapped_identifiers" role="tabpanel">
                      '.$mapped_fields_html.'
                    </div>
                    <div class="tab-pane fade" id="action_needed_identifiers" role="tabpanel">
                      '.$action_fields_html.'
                    </div>                
                </div>
              </form>
          </div>
            ';    
        /*for($j = 0; $j < count($TotalData[$j]); $j++)
        { 
          $temp_row_html = '';
          $matched_or_action_flag = 'action';
          $temp_row_html.='<tr><td style="width: 50%;padding: 20px 0px;">';
          for($i = 0; $i < count($TotalData); $i++)        
          {
            $real_data[$j][$i] = $TotalData[$i][$j];
            if(!empty($TotalData[$i][$j]))
            { 
              $temp_row_html.='<label>'.$TotalData[$i][$j].'</label><br>';
            }
          }
          $temp_row_html.='</td>';
          $temp_row_html.='<td style="font-size: 30px;color: #28d428;"><i class="zwicon-checkmark-circle"></i></td>';
          $temp_row_html.='<td style="width: 25%;text-align: center;">'.$identifiers_select_html.'</td>';
          $temp_row_html.='<td style="width: 25%;">descriptions here</td>';
          $temp_row_html.='</td></tr>';
        }*/
        /*for($i = 0; $i < count($TotalData); $i++)
        {
          $csv_html.='<ul>';
          for($j = 0; $j < count($TotalData[$i]); $j++)
          {
            $csv_html.='
              <li>'.$TotalData[$i][$j].'</li>
            ';
          }
          $csv_html.='<ul>';
        }*/
        //$csv_html.= json_encode($real_data);
        /*$csv_html.=$table_footer_html;
        echo $csv_html;
        echo json_encode($real_data);
        exit();*/

        echo $csv_html;
        exit();
        return back()
            ->with('success',"here");
    }       
   
    }

    public function csv_head_upload(Request $request)
    { 
      //sort form submit data
      $headers = $request->all();
      $path = base64_decode($request['token']);
      unset($headers['token']);
      $key;
      $header_values = array();
      $only_mapped_identifiers = [];
      for($i = 0; $i < count($headers); $i++)
      { 
        $key = "row".$i;
        $header_values[$i] = $headers[$key];
        if($header_values[$i] != "none")
          $only_mapped_identifiers[] = $i;
      }
      if (!in_array("Phone Number", $header_values)) {
          echo "phone_not_found";
      }
      else
      { 
        if (!in_array("Email", $header_values)) 
          echo "email_not_found";
        else
        {
          //load .csv and update headers
          $arr = file($path);
          $num_rows = count($arr) - 1;
          $arr[0] = implode(',', $header_values)."\n";
          file_put_contents($path, implode($arr));
          
          //save csv data to db
          $doc_path = public_path('uploads')."/users/".Auth::user()->id;
          $outputfile = $doc_path.'/'.Auth::user()->id.'-filtered.csv';
          $output = fopen($outputfile, "w");
          $doc_path = $doc_path.'/'.Auth::user()->id.'.csv'; 
          $handle = fopen($doc_path, "r");        

          while (($data = fgetcsv($handle)) !== FALSE){
            $outputData = array();  
              //$outputData = array($data[0], $data[1], $data[4], $data[5], $data[6]);
            for($i = 0; $i < count($only_mappesd_identifiers); $i++)
            { 
              $key = $only_mapped_identifiers[$i];
              if(!isset($data[$key]))
                $data[$key] = '';
              array_push($outputData,$data[$key]);            
            }
            fputcsv($output,$outputData);
          }
          fclose($handle);
          fclose($output);

          unlink($doc_path);
          rename($outputfile,$doc_path);

          //save old feedbacks.csv by renaming
    
          $target_file = public_path('uploads')."/users/".Auth::user()->id.'/'.Auth::user()->id.'-feedbacks.csv';
          if(is_file($target_file))
          { 
            $temp_name= public_path('uploads')."/users/".Auth::user()->id.'/'.date("Y-m-d").'-feedbacks.csv';
            rename($target_file,$temp_name);
          }
          
          $header = null;

          $success_data = 0;
          $error_data = 0;

          $email_array = [];
          $phone_array = [];
          $serialized_data_array = [];
          $array_index = 0;

          $previous_csvs = Csv::find_csv_by_userid(Auth::user()->id);
          if($previous_csvs !="noexist")
          {
            //update previously uploaded audience data status 
            $set_previous_csv_data = Csv::update_status(Auth::user()->id);
          }
          //update previous feedback status OLD
          $survey = Survey::find_survey_by_userid(Auth::user()->id);
          $result = Feedback::update_status($survey);

          $doc_path1 = public_path('uploads')."/users/".Auth::user()->id.'/'.Auth::user()->id.'.csv';
          $handle1 = fopen($doc_path1, "r");
          while (($getData = fgetcsv($handle1)) !== FALSE)
          {
            if(!$header){
            $header = $getData;
              continue;
            }
            $temp_data = array_combine($header, $getData);
            foreach ($temp_data as $key => $value) {
            $temp_data[$key] = $value;
            }        
            //var_dump($temp_data);exit();
            $result = Csv::Save_csv(Auth::user()->id, $temp_data['Email'], $temp_data['Phone Number'], serialize($temp_data));
            $success_data++;
            // $email_array[$array_index] = $temp_data['Email'];
            // $phone_array[$array_index] = $temp_data['Phone Number'];
            // $serialized_data_array[$array_index] = serialize($temp_data);
          }
          
          fclose($handle1);
          echo $num_rows.'|'.$success_data;
        }
        
      }
      
    }
}