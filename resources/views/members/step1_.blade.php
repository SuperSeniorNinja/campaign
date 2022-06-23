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
            setTimeout(function() {
                $('.alert').fadeOut('fast');
                window.location.href="/step2";
            }, 3000);
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
    </style>
    <form id="survey_form" method="POST" enctype="multipart/form-data" action="{{route('save_survey')}} ">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="o_body o_bg-light survey_form" style="width: 100%;margin: 0px;padding: 0px;cursor: pointer;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 10px;">
              <tbody>
                <tr>
                  <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="padding-left: 8px;padding-right: 8px;padding-top: 32px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                      <tbody>
                        <tr>
                          <td class="o_re o_bg-white o_px o_pb-md o_br-t uploadImg" align="center">
                            <div class="uploadContent" style="background-image: url('{{ asset($survey['banner'])}}')">
                                <input type="file" name="banner" id="banner" accept=".gif, .jpg, .png, .bmp, .jpeg" required="" >
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
                          <td class="o_bg-white o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;background-color: #dbe5ea;color: #82899a;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">
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
                            <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;line-height: 39px;"><input class="editable align-center" value="{{$survey['title']}}" style="font-size: 30px;" name="title"></h2>
                            <p style="margin-top: 0px;margin-bottom: 0px;"><input class="editable align-center" value="{{$survey['description']}}" style="text-align: center;font-size: 17px;" name="description"></p>
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
                            <h5 style="margin-top: 0px;"><textarea class="editable"  name="question1">{{$survey['question1']}}</textarea></h5>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa1_agree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa1_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                            </div>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa1_disagree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
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
                            <h5 style="margin-top: 0px;"><textarea class="editable"  name="question2">{{$survey['question2']}}</textarea></h5>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa2_agree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa2_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                            </div>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa2_disagree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
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
                            <h5 style="margin-top: 0px;"><textarea class="editable"  name="question3">{{$survey['question3']}}</textarea></h5>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa3_agree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa3_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                            </div>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa3_disagree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa3_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->Disagree</label>
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
                            <h5 style="margin-top: 0px;"><textarea class="editable" name="question4">{{$survey['question4']}}</textarea></h5>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa4_agree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa4_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                            </div>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa4_disagree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa4_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->Disagree</label>
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
                            <h5 style="margin-top: 0px;"><textarea class="editable" name="question5">{{$survey['question5']}}</textarea></h5>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa5_agree" name="qa5_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa5_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                            </div>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa5_disagree" name="qa5_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa5_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->Disagree</label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="margin-bottom: 30px;">
              <tbody>
                <tr>
                  <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                    <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;box-shadow: 3px 4px #d2cbcb;">
                      <tbody>
                        <tr>
                          <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                            <h5 style="margin-top: 0px;"><textarea class="editable" name="question6">{{$survey['question6']}}</textarea></h5>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa6_agree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa6_agree" style="display: inline-block;"><!-- <input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"> -->Agree</label>
                            </div>
                            <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                                <input type="radio" id="qa6_disagree" name="qa6_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                                <label class="custom-control-label" for="qa6_disagree" style="display: inline-block;"><!-- <input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"> -->Disagree</label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
              <tbody>
                <tr>
                  <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #0ec06e;border-radius: 4px;">
                    <button class="o_text-white" type="submit" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;border: none;background-color: #0ec06e;">Save & Publish</button>
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
    </form>
    <script>
      window.onload = function(){
        //image upload
        var file = jQuery('.uploadContent input[type="file"]');
        file.on('change', function(event){
          var fileName = file.val().split( '\\' ).pop(),
                tmppath = URL.createObjectURL(event.target.files[0]);
          if( fileName ){
            jQuery(".uploadContent").css('background-image', 'url(' + tmppath + ')');
          }
        });
      }
    </script>
    <!-- <form id="survey_form" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="username form-control" name="username" value="{{ Auth::user()->username }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" class="email form-control" name="email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>User Role</label>
                                <input type="text" name="level" class="level form-control" value="{{ Auth::user()->level }}" disabled="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="password form-control" name="password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="confirm_password form-control" name="confirm_password">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form> -->
    <!-- <div class="container survey_form">
        <div class="card-body banner col-md-12 mgb-30">
            <img src="{{ asset('img/survey_header.png')}}" alt="Header image here">
        </div>
        <div class="card-body header_title col-md-12 mgb-30 align-center">
            <div class="row">
                <img src="{{ asset('img/email/hear_survey.png')}}">
            </div>
            <h2 class="o_heading o_text-dark o_mb-xxs" style="color: #242b3d;font-size: 30px;">
                <input class="editable" value="Madison County - We Need Your Feedback" style="background-color: unset;border: none;width: 100%;text-align: center;">
            </h2>
            <p><input class="editable" value="Please take this short survey." style="text-align: center;"></p>
        </div>
    </div> -->
    
@endsection         