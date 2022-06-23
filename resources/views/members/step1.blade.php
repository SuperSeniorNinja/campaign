@extends("layouts.app")
@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! \Session::get('success') !!}
        </div>
        <script type="text/javascript">
            window.location.href="/step2";

            /*setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 3000);*/
        </script>
    @endif
    @if (\Session::has('msg'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! \Session::get('msg') !!}
        </div>
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
        #piechart div div
        {
          margin: 0 auto;
        }
    </style>
    <div class="tab-container" style="padding: 20px;max-width: 800px;margin: 0 auto;">
      <ul class="nav nav-tabs" role="tablist" style="margin-left: 8px;margin-right: 8px;">
          <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#survey" role="tab" style="font-size: 20px;color: #000;"><i class="zwicon-search" style="color: #28d428;font-weight: bold;"></i> Survey (Questions) </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#response" role="tab" style="font-size: 20px;color: #000;"><i class="zwicon-broadcast" style="color: #28d428;font-weight: bold;"></i> Responses ({{ $response }})</a>

          </li>
      </ul>
      <div class="tab-content">                
        <div class="tab-pane active fade show mapped_field" id="survey" role="tabpanel">
          @if(isset($survey))
          <form id="survey_form" method="POST" enctype="multipart/form-data" action="{{route('save_survey')}} ">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="o_body o_bg-light survey_form" style="width: 100%;margin: 0px;padding: 0px;cursor: pointer;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
                  <tbody>
                    <tr>
                      <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                          <tbody>
                            <tr>
                              <td class="o_re o_bg-white o_px o_pb-md o_br-t uploadImg" align="center">
                                <!-- <div class="col-md-12" style="padding: 5px 0px;background-color: #dbe5ea;">
                                  <h4>Upload your organization’s logo here</h4>  
                                </div> -->
                                <?php 
                                  if(!isset($survey['banner']) || empty($survey['banner']))
                                    $path = "/img/survey_header.png";
                                  else
                                    $path = $survey['banner'];
                                ?>                                
                                <div class="uploadContent" style="background-image: url('{{ asset($path)}}')">
                                  <!-- @if($survey['banner'] == "/img/survey_header.png")
                                    <input type="file" name="banner" id="banner" accept=".gif, .jpg, .png, .bmp, .jpeg" required="" >
                                  @else
                                    <input type="hidden" name="banner" value="{{$survey['banner']}}">
                                  @endif -->
                                  <!-- <input type="file" name="banner" id="banner" accept=".gif, .jpg, .png, .bmp, .jpeg" value="{{$survey['banner']}}" > -->
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
                                <h4 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;line-height: 39px;">{{$survey['title']}}<input class="align-center" value="{{$survey['title']}}" name="title" type="hidden">
                                  @if (empty($survey['title']))
                                    Hello. Please complete up to two custom survey questions below.
                                  @endif
                                </h4>

                                <!-- <p style="margin-top: 0px;margin-bottom: 0px;"><input class="editable align-center" value="{{$survey['description']}}" style="text-align: center;font-size: 17px;" name="description"></p> -->
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
                      <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;" style="margin-bottom: 10px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                          <tbody>
                            <tr>
                              <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                                <!-- <h4 style="margin-top: 0px;"><textarea class="editable"  name="question1">{{$survey['question1']}}</textarea></h4> -->
                                <input type="hidden" name="question1" value="{{$survey['question1']}}">
                                <h5  style="margin-top: 0px;text-align: left;font-weight: normal;margin-bottom: 30px;">{{$survey['question1']}}</h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa1_agree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa1_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa1_disagree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa1_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->Disagree</label>
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
                                <!-- <h5 style="margin-top: 0px;"><textarea class="editable"  name="question2">{{$survey['question2']}}</textarea></h5> -->
                                <input type="hidden" name="question2" value="{{$survey['question2']}}">
                                <h5 style="margin-top: 0px;text-align: left;font-weight: normal;margin-bottom: 30px;">{{$survey['question2']}}</h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa2_agree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa2_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa2_disagree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa2_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->Disagree</label>
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
                                <!-- <h5 style="margin-top: 0px;"><textarea class="editable"  name="question3">{{$survey['question3']}}</textarea></h5> -->
                                <input type="hidden" name="question3" value="{{$survey['question3']}}">
                                <h5 style="margin-top: 0px;text-align: left;font-weight: normal;margin-bottom: 30px;">{{$survey['question3']}}</h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa3_agree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa3_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Yes</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa3_disagree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa3_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->No</label>
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
                                <!-- <h5 style="margin-top: 0px;"><textarea class="editable" name="question4">{{$survey['question4']}}</textarea></h5> -->
                                <input type="hidden" name="question4" value="{{$survey['question4']}}">
                                <h5 style="margin-top: 0px;text-align: left;font-weight: normal;margin-bottom: 30px;">{{$survey['question4']}}</h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa4_agree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa4_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Yes</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa4_disagree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa4_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->No</label>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
                @if(!empty($survey['question5']))
                <table width="100%" class="question5" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
                  <tbody>
                    <tr>
                      <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                          <tbody>
                            <tr>
                              <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                                <!-- <h5 style="margin-top: 0px;"><textarea class="editable" name="question5" placeholder="Add your custom question here">{{$survey['question5']}}</textarea></h5> -->
                                <input type="hidden" name="question5" value="{{$survey['question5']}}">
                                <h5 style="margin-top: 0px;text-align: left;font-weight: normal;margin-bottom: 30px;">{{$survey['question5']}}</h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa5_agree" name="qa5_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa5_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Yes</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa5_disagree" name="qa5_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa5_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->No</label>
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
                <!-- @if($survey['question6'] !="removed")
                <table width="100%" class="question6" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 30px;">
                  <tbody>
                    <tr>
                      <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                          <tbody>
                            <tr>
                              <span class="badge badge-danger remove_c_qa" data-id="question6"  style="float: right;padding: 5px;"><i class="zwicon-delete" style="font-size:20px;" data-toggle="tooltip" data-placement="top" data-original-title="Remove"></i></span>
                              <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                                <h5 style="margin-top: 0px;"><textarea class="editable" name="question6" placeholder="Add your custom question here">{{$survey['question6']}}</textarea></h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa6_agree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa6_agree" style="display: inline-block;">Agree</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa6_disagree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
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
                <!-- @if($survey['question7'] !="removed")
                <table width="100%" class="question7" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 30px;">
                  <tbody>
                    <tr>
                      <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                          <tbody>
                            <tr>
                              <span class="badge badge-danger remove_c_qa" data-id="question7"  style="float: right;padding: 5px;"><i class="zwicon-delete" style="font-size:20px;" data-toggle="tooltip" data-placement="top" data-original-title="Remove"></i></span>
                              <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                                <h5 style="margin-top: 0px;"><textarea class="editable" name="question7" placeholder="Add your custom question here">{{$survey['question7']}}</textarea></h5>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa6_agree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
                                    <label class="custom-control-label" for="qa6_agree" style="display: inline-block;">Agree</label>
                                </div>
                                <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                    <input type="radio" id="qa6_disagree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;" disabled="">
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
                <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                  <tbody>
                    <tr>
                      <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #0ec06e;border-radius: 4px;">
                        <button class="o_text-white" type="submit" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;border: none;background-color: #0ec06e;">Save and Continue</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </form>
          @else
            <h5>This user has not got a survey yet.</h5>
          @endif
        </div>
        <div class="tab-pane fade" id="response" role="tabpanel">
          @if(isset($feedbacks) && Auth::user()->feedback_available == "active")
            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
              <tbody>
                <tr>
                  <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;" style="margin-bottom: 10px;">
                    <div style="height:400px; overflow:auto;background-color: #fff;padding: 0px 20px;box-shadow: 3px 4px #d2cbcb;">
                      <table class="o_block" width="100%" width="300" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;line-height: 40px;">
                        <tbody style="max-height: 400px;overflow: hidden;">
                          <tr style="border-bottom: 1px solid #bebebe;">
                            <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-top: 16px;padding-bottom: 16px;">
                              <h5 style="margin-top: 0px;">Who has responded?</h5>                          
                            </td>
                          </tr>
                          @foreach ($feedbacks as $row)
                            <tr style="color: #000;">
                              <td style="font-size: 15px;">{{ $row['email'] }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>                  
                  </td>
                </tr>
               </tbody>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
              <tbody>
                <tr>
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question1']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart1"></div>
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
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question2']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart2"></div>
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
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question3']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart3"></div>
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
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question4']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart4"></div>
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
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question5']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart5"></div>
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
            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
              <tbody>
                <tr>
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question6']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart6"></div>
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
            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
              <tbody>
                <tr>
                  <td class="o_bg-light o_px-xs" align="center" style="padding: 0px 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="border-radius: 4px;max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;background-color: #fff;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <h5 style="margin-top: 0px;">{{$survey['question7']}}</h5>
                          </td>                        
                        </tr>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 20px;padding-right: 20px;padding-top: 16px;padding-bottom: 16px;text-align: left;">
                            <div id="piechart7"></div>
                          </td>                        
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
               </tbody>
            </table>
            @endif -->
          @else
            @if(!isset($feedbacks))
              <h5>You have not got any responses yet.</h5>
            @else
              <h5>Admin did not approve your responses yet.</h5>
            @endif
          @endif
        </div>                
      </div>
  </div>
  <script src="{{ asset('vendors/googlechart/chart.js') }}"></script> 
    <script type="text/javascript">
      window.onload = function(){
        var file = jQuery('.uploadContent input[type="file"]');
        file.on('change', function(event){
            console.log("changed");
          var fileName = file.val().split( '\\' ).pop(),
                tmppath = URL.createObjectURL(event.target.files[0]);
          if( fileName ){
            jQuery(".uploadContent").css('background-image', 'url(' + tmppath + ')');
          }
        });
      }

    </script>
    @if(isset($feedbacks))
    <script>      
      var qa1_agree = <?php echo $qa1_agree; ?>;
      var qa1_disagree = <?php echo $qa1_disagree; ?>;
      var qa2_agree = <?php echo $qa2_agree; ?>;
      var qa2_disagree = <?php echo $qa2_disagree; ?>;
      var qa3_agree = <?php echo $qa3_agree; ?>;
      var qa3_disagree = <?php echo $qa3_disagree; ?>;
      var qa4_agree = <?php echo $qa4_agree; ?>;
      var qa4_disagree = <?php echo $qa4_disagree; ?>;
      var qa5_agree = <?php echo $qa5_agree; ?>;
      var qa5_disagree = <?php echo $qa5_disagree; ?>;
      var qa6_agree = <?php echo $qa6_agree; ?>;
      var qa6_disagree = <?php echo $qa6_disagree; ?>;
      var qa7_agree = <?php echo $qa7_agree; ?>;
      var qa7_disagree = <?php echo $qa7_disagree; ?>;

      // Load google charts
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      // Draw the chart and set the chart values
      function drawChart() {
        for(var i = 1; i < 3; i++)
        { 
          var agree_temp = "qa"+ i + "_agree";
          var disagree_temp = "qa"+ i + "_disagree";
          var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Agree', eval(agree_temp)],
            ['Disagree', eval(disagree_temp)]
          ]);
          // Optional; add a title and set the width and height of the chart
          var options = {'title':'', 'width': 550, 'height':200, is3D: true, pieSliceText : 'value'};
          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(document.getElementById('piechart'+ i));
          chart.draw(data, options);
        }
        for(var i = 3; i < 7; i++)
        { 
          var yes_temp = "qa"+ i + "_agree";
          var no_temp = "qa"+ i + "_disagree";
          var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Yes', eval(yes_temp)],
            ['No', eval(no_temp)]
          ]);
          // Optional; add a title and set the width and height of the chart
          var options = {'title':'', 'width': 550, 'height':200, is3D: true, pieSliceText : 'value'};
          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(document.getElementById('piechart'+ i));
          chart.draw(data, options);
        }
      }
    </script>
    @endif
@endsection         