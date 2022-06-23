@extends("layouts.app")
@section('content')
    <script type="text/javascript">
      setTimeout(function() {
        document.querySelector('.step1_check').style.visibility="visible";
        document.querySelector('.step2_check').style.visibility="visible";
        document.querySelector(".backtostep3").addEventListener('click', function(event) {
          $('.p2ptext_area').hide();
          $('#send_survey').show();
          $('.submit_btn_div').show();
          /*document.querySelector('.p2ptext_area').style.visibility="hidden";
          document.querySelector('#send_survey').style.visibility="visible";
          document.querySelector('.submit_btn_div').style.visibility="visible";*/
        })  
      }, 0);
      function goback()
      {
        $(".survey_result").hide();
        $("#send_survey").show();
        $(".submit_btn_div").show();
      }
    </script>
  @if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! \Session::get('success') !!}
    </div>
    <!-- <script type="text/javascript">
      setTimeout(function() {
        $('.alert').fadeOut('fast');
        $("#send_survey").hide();
        $(".card-body").append('<div class="row"><div class="col-md-12"><div class="image align-center"><img src="{{ asset("img/success.gif") }}" style="width: 160px;margin: 0 auto;margin-bottom: 30px;"></div><div class="form-group align-center"><label>{!! Session::get('success') !!}</label></div></div></div>');
        $(".submit_btn_div").hide();
        $('.step3_check').show();
    }, 0);      
    </script> -->
  @endif
  <div class="content__inner content__inner--sm launch_div">
    <div class="card new-contact">
        <div class="card-body send_survey">
          @if($status == "success")
            <form id="send_survey" method="POST" action="{{route('launch_survey')}}">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group align-center">
                      <label>We will send your survey to <b>{{ $s_count }}</b> phone numbers via text and <b>{{ $e_count }}</b> emails.</label>
                  </div>
                </div>
                <div class="col-md-12 align-center mgb-30">
                  <label>You can share this survey on social media using this:&nbsp;&nbsp;<br>
                  <a href="{{ $publish_link }}" class="alink">{{ $publish_link }}</a><br>
                  Please note any results will not be connected to your uploaded audience data.</label>
                </div>
                <div class="col-md-12 text-center submit_btn_div">
                    <button type="button" class="btn btn-success" data-type="email">Send All Emails and Texts</button>
                    <button type="button" class="btn btn-success" data-type="sms">Send Emails and P2P text</button>
                </div>
              </div>              
            </form>
          @else
            <div class="row">
              <div class="col-md-12">
                <div class="form-group align-center">
                    <label class="mgb-30">You have no audience data ( .csv ) available to submit a survey</label>
                    <a href="{{ route('step2')}}" class="alink">Go back to upload audience data</a>
                </div>
              </div>
            </div>
          @endif
          @if($status == "success")
          <div class="p2ptext_area">
            @if($s_count > 0)
              <h3 class="align-center">Send Emails and P2P text</h3><br>
              <div class="align-center mgb-30">
                <button type="button" class="btn btn-success send_all_emails">Send All Emails</button>
              </div>
              <div class="table-responsive data-table mgb-30">
                <table id="data-table3" class="p2p_table table styled_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Phone Number</th>
                        <th class="text-center">Action</th>
                        <?php
                          if(count($phones) > 1)
                          {?>
                            <th>ID</th>
                            <th>Phone Number</th>
                            <th class="text-center">Action</th>
                          <?php }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $index = 1;
                      if(count($phones) > 1)
                      {
                        $add_interval = 2;
                        for($i = 0; $i < count($phones) - 1; $i=$i+$add_interval) { $j = $i + $add_interval - 1;?>
                        <tr>
                          <td class="align-middle"><?php echo $index;  $index++; ?></td>
                          <td class="align-middle"><?php echo $phones[$i]['phone'];?></td>
                          <td class="text-center m_actions align-middle">
                            <div>
                              <button type="button" class="btn btn-info p2p_text" 
                              data-phone="<?php echo $phones[$i]['phone'];?>" 
                              data-id="<?php echo $phones[$i]['id']; ?>" 
                              <?php if($phones[$i]['sms_sent'] == "Sent") echo "disabled";?>><?php if($phones[$i]['sms_sent'] == "Sent") echo "Sent"; else echo "Send";?></button>                                
                            </div>                              
                          </td>
                          <td class="align-middle"><?php echo $index;  $index++; ?></td>
                          <td class="align-middle"><?php echo $phones[$j]['phone'];?></td>
                          <td class="text-center m_actions align-middle">
                            <div>
                              <button type="button" class="btn btn-info p2p_text" 
                              data-phone="<?php echo $phones[$j]['phone'];?>" 
                              data-id="<?php echo $phones[$j]['id']; ?>" 
                              <?php if($phones[$j]['sms_sent'] == "Sent") echo "disabled";?>><?php if($phones[$j]['sms_sent'] == "Sent") echo "Sent"; else echo "Send";?></button>                                
                            </div>                              
                          </td>
                        </tr>
                      <?php }
                      }
                      else
                      {
                        $add_interval = 1;
                        for($i = 0; $i < count($phones); $i=$i+$add_interval) { $j = $i + $add_interval - 1;?>
                        <tr>
                          <td class="align-middle"><?php echo $index;  $index++; ?></td>
                          <td class="align-middle"><?php echo $phones[$i]['phone'];?></td>
                          <td class="text-center m_actions align-middle">
                            <div>
                              <button type="button" class="btn btn-info p2p_text" 
                              data-phone="<?php echo $phones[$i]['phone'];?>" 
                              data-id="<?php echo $phones[$i]['id']; ?>" 
                              <?php if($phones[$i]['sms_sent'] == "Sent") echo "disabled";?>><?php if($phones[$i]['sms_sent'] == "Sent") echo "Sent"; else echo "Send";?></button>                                
                            </div>                              
                          </td>                          
                        </tr>
                      <?php }                      
                      }?> 
                               
                    </tbody>
                </table>
              </div>
              <div class="align-center">
                <a class="alink backtostep3">Go Back</a>
              </div>
            @else
              <h3 class="align-center mgb-30">You have no phone numbers available to send P2P text.</h3><br>
              <div class="align-center">
                <a class="alink backtostep3">Go Back</a>
              </div>              
            @endif
          </div>
          @endif
      </div>
    </div>
</div>
@endsection