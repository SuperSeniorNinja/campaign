<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;
use Validator;
use Illuminate\Mail\Mailable;
use Session;

class EmailController extends Controller
{
    public function index(Request $request)
    {
    	if(Auth::check())
            return view('members/email');
        else
            return redirect()->route('home');
    }
    public function SendEmail(Request $request)
    {	
    	$email = new \SendGrid\Mail\Mail(); 
      $email->setFrom("ninjasuper333@gmail.com", "Example User");
      $email->setSubject("Sending with SendGrid is Fun");
      $email->addTo("topdev333@gmail.com", "Example User");
      $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
      $content = '<style type="text/css">
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
      <div class="o_body o_bg-light survey_form" style="width: 100%;margin: 0px;padding: 0px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="padding-left: 8px;padding-right: 8px;padding-top: 32px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_re o_bg-white o_px o_pb-md o_br-t" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-bottom: 24px;">
                          <div class="o_col o_col-2" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                            <div class="o_px-xs o_sans o_text o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: left;padding-left: 8px;padding-right: 8px;">
                              <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-white" href="#" style="text-decoration: none;outline: none;color: #ffffff;"><img src="/public/img/email/survey_logo_default.png" width="136" height="36" alt="SimpleApp" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
                            </div>
                          </div>
                          <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                            <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                              <table class="o_right o_xs-center" cellspacing="0" cellpadding="0" border="0" role="presentation" style="text-align: right;margin-left: auto;margin-right: 0;">
                                <tbody>
                                  <tr>
                                    <td class="o_btn-xs o_bg-primary o_br o_heading o_text-xs" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 16px;background-color: #126de5;border-radius: 4px;">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;background-color: #dbe5ea;color: #82899a;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">
                          <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td class="o_bb-primary" height="40" width="32" style="border-bottom: 1px solid #126de5;">&nbsp; </td>
                                <td rowspan="2" class="o_sans o_text o_text-secondary o_px o_py" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                                  <img src="/public/img/email/hear_survey.png" width="48" height="48" alt="" style="max-width: 48px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;">
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
                          <input type="checkbox" name="qa1"> Agree<br>
                          <input type="checkbox" name="qa1"> Disagree<br>
                          <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;"><input class="editable" value="Madison County - We Need Your Feedback" style="background-color: unset;border: none;width: 100%;    text-align: center;"></h2>
                          <p style="margin-top: 0px;margin-bottom: 0px;"><input class="editable" value="Please take this short survey." style="background-color: unset;border: none;width: 100%;    text-align: center;"></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;"><textarea class="editable"  name="qa1" style="background-color: unset;border: none;width: 100%;font-size: 16px;resize: none;">President Donald Trump is doing a good job handling the coronavirus outbreak.</textarea></h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa1_agree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa1_agree" style="display: inline-block;"><input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa1_disagree" name="qa1_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa1_disagree" style="display: inline-block;"><input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;"><textarea class="editable"  name="qa2" style="background-color: unset;border: none;width: 100%;font-size: 16px;resize: none;">Governor J.B Pritzker is doing a good job handling the coronavirus outbreak.</textarea></h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa2_agree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa2_agree" style="display: inline-block;"><input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa2_disagree" name="qa2_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa2_disagree" style="display: inline-block;"><input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;"><textarea class="editable"  name="qa3" style="background-color: unset;border: none;width: 100%;font-size: 16px;resize: none;">I am concerned that I (or someone close to me) has or will get the coronavirus.</textarea></h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa3_agree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa3_agree" style="display: inline-block;"><input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa3_disagree" name="qa3_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa3_disagree" style="display: inline-block;"><input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <h5 style="margin-top: 0px;"><textarea class="editable" name="qa4" style="background-color: unset;border: none;width: 100%;font-size: 16px;resize: none;">I am afraid that if I (or a member of my family) gets coronavirus, we won\'t be able to pay the medical bills.</textarea></h5>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa4_agree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa4_agree" style="display: inline-block;"><input class="editable" value="Agree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                          <div class="custom-control custom-radio" style="text-align: left;margin-bottom: 20px;">
                              <input type="radio" id="qa4_disagree" name="qa4_answer" class="custom-control-input_" style="width: 20px;height: 20px;display: inline-block;">
                              <label class="custom-control-label" for="qa4_disagree" style="display: inline-block;"><input class="editable" value="Disagree" style="background-color: unset;border: none;width: 100%;"></label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py-xs" align="center" style="background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 8px;padding-bottom: 8px;">
                          <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                            <tbody>
                              <tr>
                                <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #0ec06e;border-radius: 4px;">
                                  <a class="o_text-white" href="" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;">Join the Conversation</a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="padding-left: 8px;padding-right: 8px;">
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white" style="font-size: 48px;line-height: 48px;height: 48px;background-color: #ffffff;">&nbsp; </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
      </div>';
      $email->addContent(
          "text/html", $content
      );
      $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
      try {
          $response = $sendgrid->send($email);
          print $response->statusCode() . "\n";
          print_r($response->headers());
          print $response->body() . "\n";

      } catch (Exception $e) {
          echo 'Caught exception: '. $e->getMessage() ."\n";
      }
    }

    public function SendSms(Request $request)
    { 
      // Your Account SID and Auth Token from twilio.com/console
       $sid    = env( 'TWILIO_SID' );
       $token  = env( 'TWILIO_TOKEN' );
       $from = env( 'TWILIO_FROM' );
       $client = new Client( $sid, $token );
       $validator = Validator::make($request->all(), [
           'number' => 'required',
           'message' => 'required'
       ]);       

       if ( $validator->passes() ) {
            $number = $request->input('number');
            $message = $request->input('message');
            $client->messages->create(
                $number,
                [
                    "body" => $message,
                    "from" => $from
                ]
            );
            return back()->with( 'success', " messages sent!" );
       } else {
           return back()->withErrors( $validator );
       }
    }
}
