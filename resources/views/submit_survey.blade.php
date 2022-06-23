@extends("front.app")
@section('content')
  @if (\Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show align-center">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
          {!! \Session::get('success') !!}
      </div>
      <script type="text/javascript">
          setTimeout(function() {
              $('.alert').fadeOut('fast');
          }, 5000);
      </script>
  @endif
  <style type="text/css">
      a { text-decoration: none; outline: none; }
      @media (max-width: 649px) {
          .o_col-full { max-width: 100% !important; }
          .o_col-half { max-width: 50% !important; }
          .o_hide-lg { display: inline-block !important; font-size: inherit !important; max-height: none !important; line-height: inherit !important; overflow: visible !important; width: auto !important; visibility: visible !important; }
          .o_hide-xs, .o_hide-xs.o_col_i { display: none !important; font-size: 0 !important; max-height: 0 !important; width: 0 !important; line-height: 0 !important; overflow: hidden !important; visibility: hidden !important; height: 0 !important; }
          .o_xs-center { text-align: center !important; }
          .o_xs-left { text-align: left !important; }
          .o_xs-right { text-align: left !important; }
          table.o_xs-left { margin-left: 0 !important; margin-right: auto !important; float: none !important; }
          table.o_xs-right { margin-left: auto !important; margin-right: 0 !important; float: none !important; }
          table.o_xs-center { margin-left: auto !important; margin-right: auto !important; float: none !important; }
          h1.o_heading { font-size: 32px !important; line-height: 41px !important; }
          h2.o_heading { font-size: 26px !important; line-height: 37px !important; }
          h3.o_heading { font-size: 20px !important; line-height: 30px !important; }
          .o_xs-py-md { padding-top: 24px !important; padding-bottom: 24px !important; }
          .o_xs-pt-xs { padding-top: 8px !important; }
          .o_xs-pb-xs { padding-bottom: 8px !important; }
      }
      td h5
      {
        font-weight: normal;
        text-align: left;
        font-size: 17px;
        margin-bottom: 30px;
      }
      .content
      {
        padding: 0px !important;
      }
      #email::placeholder
      {
        color: #000;
      }
      /*#email
      {
        border: none;
        border-bottom: 1px solid #000;
      }*/
  </style>
  <form id="submit_survey" method="POST" action="{{route('Submit_feedback')}} ">
      {{ csrf_field() }}
      <input type="hidden" name="survey_id" value="{{$survey['id']}}">
      <div class="o_body o_bg-light survey_form" style="width: 100%;margin: 0px;padding: 0px;cursor: pointer;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="padding-left: 8px;padding-right: 8px;padding-top: 32px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_re o_bg-white o_px o_pb-md o_br-t uploadImg" align="center">
                          <?php 
                                  if(!isset($survey['banner']) || empty($survey['banner']))
                                    $path = "/img/survey_header.png";
                                  else
                                    $path = $survey['banner'];
                                ?>                                
                            <div class="uploadContent" style="background-image: url('{{ asset($path)}}')">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;background-color: #dbe5ea;color: #82899a;padding-left: 24px;padding-right: 24px;padding-bottom: 10px;">
                          <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td class="o_bb-primary" height="40" width="32" style="border-bottom: 1px solid #126de5;">&nbsp; </td>
                                <td rowspan="2" class="o_sans o_text o_text-secondary o_px o_py" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                                  <img src="{{ asset('img/email/hear_survey.png')}}" width="48" height="48" alt="" style="max-width: 48px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;">
                                </td>
                                <td class="o_bb-primary" height="40" width="32" style="border-bottom: 1px solid #126de5;">&nbsp; </td>
                              </tr>
                              <tr>
                                <td height="40">&nbsp; </td>
                                <td height="40">&nbsp; </td>
                              </tr>
                              <tr>
                                <td style="font-size: 8px; line-height: 8px; height: 8px;">&nbsp; </td>
                                <td style="font-size: 8px; line-height: 8px; height: 8px;">&nbsp; </td>
                              </tr>
                            </tbody>
                          </table>
                          <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;line-height: 39px;">Please answer our survey questions below.</h2>
                          <!-- <p style="margin-top: 0px;margin-bottom: 0px;">{{$survey['description']}}</p> -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" id="from" name="from" class="form-control from" value="{{$from}}">
          <input type="hidden" id="sender" name="sender" class="form-control sender" value="{{$sender}}">
          <!-- <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;" style="margin-bottom: 10px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 17px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 20px;padding-bottom: 20px;">
                          <h5 style="margin-top: 0px;">Email address</h5>
                          <div class="form-group" style="margin-bottom: 0px;">
                            <input type="email" id="email" name="email" class="form-control email" style="width: 100%;" placeholder="Valid email address" required="">
                          </div>                          
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
             </tbody>
          </table> -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;" style="margin-bottom: 10px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question1']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa1_agree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Agree" required="">
                              <label class="custom-control-label" for="qa1_agree" style="display: inline-block;">Agree</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa1_disagree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Disagree">
                              <label class="custom-control-label" for="qa1_disagree" style="display: inline-block;">Disagree</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
             </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto; box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question2']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa2_agree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Agree" required="">
                              <label class="custom-control-label" for="qa2_agree" style="display: inline-block;">Agree</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa2_disagree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Disagree">
                              <label class="custom-control-label" for="qa2_disagree" style="display: inline-block;">Disagree</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
             </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>            
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question3']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa3_agree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Yes" required="">
                              <label class="custom-control-label" for="qa3_agree" style="display: inline-block;">Yes</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa3_disagree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="No">
                              <label class="custom-control-label" for="qa3_disagree" style="display: inline-block;">No</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
             </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question4']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa4_agree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Yes" required="">
                              <label class="custom-control-label" for="qa4_agree" style="display: inline-block;">Yes</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa4_disagree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="No">
                              <label class="custom-control-label" for="qa4_disagree" style="display: inline-block;">No</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          @if($survey['question5'] !="removed" && !empty($survey['question5']))
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question5']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa5_agree" name="qa5_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Yes" required="">
                              <label class="custom-control-label" for="qa5_agree" style="display: inline-block;">Yes</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa5_disagree" name="qa5_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="No">
                              <label class="custom-control-label" for="qa5_disagree" style="display: inline-block;">No</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          @endif
          <!-- @if($survey['question6'] !="removed" && !empty($survey['question6']))
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 30px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question6']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa6_agree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Agree" required="">
                              <label class="custom-control-label" for="qa6_agree" style="display: inline-block;">Agree</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa6_disagree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Disagree">
                              <label class="custom-control-label" for="qa6_disagree" style="display: inline-block;">Disagree</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          @endif -->
          <!-- @if($survey['question7'] !="removed" && !empty($survey['question7']))
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 30px;">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;">{{$survey['question7']}}</h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa7_agree" name="qa7_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Agree" required="">
                              <label class="custom-control-label" for="qa7_agree" style="display: inline-block;">Agree</label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa7_disagree" name="qa7_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" value="Disagree">
                              <label class="custom-control-label" for="qa7_disagree" style="display: inline-block;">Disagree</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          @endif -->
          <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation" class="mgb-30">
            <tbody>
              <tr>
                <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #0ec06e;border-radius: 4px;">
                  <button class="o_text-white" type="submit" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;border: none;background-color: #0ec06e;">Submit a survey</button>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
  </form>
  @endsection