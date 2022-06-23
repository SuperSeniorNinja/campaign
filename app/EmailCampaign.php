<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use DB;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
class EmailCampaign extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    static function SendForgetPassword($email_address)
    {   
        //create a new token to be sent to the user. 
        DB::table('password_resets')->insert([
            'email' => $email_address,
            'token' => Str::random(60)
        ]);

        $tokenData = DB::table('password_resets')
        ->where('email', $email_address)->first();
        $token = $tokenData->token;

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("ninjasuper333@gmail.com", config('app.name'));
        $email->setSubject("Reset Password");
        $email->addTo($email_address, config('app.name'));
        $image_path = getenv("APP_URL").'/public/img/';
        $reset_link = getenv("APP_URL").'/reset-password/'.$token;
        $message = '
          <body class="o_body o_bg-light" style="width: 100%;margin: 0px;padding: 0px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #dbe5ea;">
          <!-- preview-text -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_hide" align="center" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Email Summary (Hidden)</td>
              </tr>
            </tbody>
          </table>
          <!-- header-white-link -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-top: 32px;">
                  <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_re o_bg-white o_px o_pb-md o_br-t" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-bottom: 24px;">
                          <!--[if mso]><table cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td width="200" align="left" valign="top" style="padding:0px 8px;"><![endif]-->
                          <div class="o_col o_col-2" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                            <div class="o_px-xs o_sans o_text o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: left;padding-left: 8px;padding-right: 8px;">
                              <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-primary" href="'.getenv("APP_URL").'" style="text-decoration: none;outline: none;color: #126de5;"><img src="'.$image_path.'logo.png" width="136" height="36" alt="'.config('app.name').'" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
                            </div>
                          </div>
                          <!--[if mso]></td><td width="400" align="right" valign="top" style="padding:0px 8px;"><![endif]-->
                          <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                            <div style="font-size: 22px; line-height: 22px; height: 22px;">&nbsp; </div>
                            <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                              <table class="o_right o_xs-center" cellspacing="0" cellpadding="0" border="0" role="presentation" style="text-align: right;margin-left: auto;margin-right: 0;">
                                <tbody>
                                  <tr>
                                    <td class="o_btn-b o_heading o_text-xs" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 8px;">                                      
                                      <a class="o_text-light" href="getenv("APP_URL")" style="text-decoration: none;outline: none;color: #82899a;display: block;padding: 7px 8px;font-weight: bold;"><span style="mso-text-raise: 6px;display: inline;color: #82899a;">'.$email_address.'</span> <img src="'.getenv("APP_URL").'/public/img/email/person-24-light.png" width="24" height="24" alt="" style="max-width: 24px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!--[if mso]></td></tr></table><![endif]-->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if mso]></td></tr></table><![endif]-->
                </td>
              </tr>
            </tbody>
          </table>
          <!-- hero-icon-lines -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                  <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-ultra_light o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;background-color: #ebf5fa;color: #82899a;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">
                          <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td class="o_bb-primary" height="40" width="32" style="border-bottom: 1px solid #126de5;">&nbsp; </td>
                                <td rowspan="2" class="o_sans o_text o_text-secondary o_px o_py" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">                                  
                                  <img src="'.$image_path.'email/vpn_key-48-primary.png" width="48" height="48" alt="" style="max-width: 48px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;">
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
                          <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;">Forgot Your Password?</h2>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if mso]></td></tr></table><![endif]-->
                </td>
              </tr>
            </tbody>
          </table>
          <!-- spacer -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                  <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white" style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;">&nbsp; </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if mso]></td></tr></table><![endif]-->
                </td>
              </tr>
            </tbody>
          </table>
          <!-- content -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                  <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                          <p style="margin-top: 0px;margin-bottom: 0px;">Click the "Reset Password" button to reset password.</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if mso]></td></tr></table><![endif]-->
                </td>
              </tr>
            </tbody>
          </table>
          <!-- button-primary -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                  <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white o_px-md o_py-xs" align="center" style="background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 8px;padding-bottom: 8px;">
                          <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                            <tbody>
                              <tr>
                                <td width="300" class="o_btn o_bg-primary o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #126de5;border-radius: 4px;">
                                  <a class="o_text-white" href="'.$reset_link.'" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;">Reset My Password</a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if mso]></td></tr></table><![endif]-->
                </td>
              </tr>
            </tbody>
          </table>
          <!-- spacer-lg -->
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                  <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
                  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td class="o_bg-white" style="font-size: 48px;line-height: 48px;height: 48px;background-color: #ffffff;">&nbsp; </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if mso]></td></tr></table><![endif]-->
                </td>
              </tr>
            </tbody>
          </table>            
            </body>
          ';
        $email->addContent(
            "text/html", $message
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $response = $sendgrid->send($email);
        if (strpos($response->statusCode(), '20') !== false)
            echo "success";
        else
            echo "failure";
    }

    static function Send_survey_email($Email, $subject, $body, $sender, $link, $banner, $description)
    { 
      $link = $link.'/'.base64_encode("Email").'/'.base64_encode($Email);
        $banner_path = config('app.url').'/public'.$banner;
        $success_emails = [];
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("ninjasuper333@gmail.com", $sender);
        $email->setSubject($subject);
        $email->addTo($Email, $sender);
        $email->addContent("text/plain", $body);
        $content = '
          <head>
              <style type="text/css">
                  html,
                  body {
                    margin: 0 auto !important;
                    padding: 0 !important;
                    height: 100% !important;
                    width: 100% !important;
                    background-color: #F6F7F9 !important;
                 }
                  * {
                      -ms-text-size-adjust: 100%;
                      -webkit-text-size-adjust: 100%;
                  }
                  div[style*="margin: 16px 0"] {
                      margin: 0 !important;
                  }
                  table,
                  td {
                      mso-table-lspace: 0pt !important;
                      mso-table-rspace: 0pt !important;
                  }
                  table {
                      border-spacing: 0 !important;
                      table-layout: fixed !important;
                      margin: 0 auto !important;
                  }
                  img {
                      line-height: 100%;
                      outline: none;
                      text-decoration: none;
                      /* Uses a smoother rendering method when resizing images in IE. */
                      -ms-interpolation-mode: bicubic;
                      /* Remove border when inside `a` element in IE 8/9/10. */
                      border: 0;
                      /* Sets a maximum width relative to the parent and auto scales the height */
                      max-width: 100%;
                      height: auto;
                      /* Remove the gap between images and the bottom of their containers */
                      vertical-align: middle;
                  }
                  .yshortcuts a {
                      border-bottom: none !important;
                  }
                  a[x-apple-data-detectors] {
                      color: inherit !important;
                      text-decoration: none !important;
                      font-size: inherit !important;
                      font-family: inherit !important;
                      font-weight: inherit !important;
                      line-height: inherit !important;
                  }
                  @media screen and (min-width: 600px) {
                      .ios-responsive-grid {
                          display: -webkit-box !important;
                          display: -webkit-flex !important;
                          display: -moz-box !important;
                          display: -ms-flexbox !important;
                          display: flex !important;
                      }
                      /* Alternative method. Not needed if already using the .ios-responsive-grid flex workaround. */
                      /* .ios-responsive-grid__unit class would need to be added to the inline-block <div> grid units  */
                      .ios-responsive-grid__unit  {
                          float: left;
                      }
                  } 
                  body 
                  { 
                  -webkit-font-smoothing: antialiased; 
                  -moz-osx-font-smoothing: grayscale; 
                  }
                  li {
                      text-indent: -1em;
                  }
                  .button__td,
                  .button__a {
                      transition: all 100ms ease;
                  }
                  .button__td:hover,
                  .button__a:hover {
                      background: #185de7 !important;
                  }
                  @media screen and (max-width: 599px) {
                      .tw-body { padding: 8px 8px 0 !important; }
                      .tw-card-header,
                      .tw-card-banner,
                      .tw-card-body,
                      .tw-card-footer { padding-left: 15px !important; padding-right: 15px !important; }
                      .tw-card-banner { padding-top: 20px !important; padding-bottom: 10px !important; }
                      .tw-card-body-xsmall { padding: 10px !important; }
                      .tw-header-cta { display: none !important; }
                      .tw-h1 { font-size: 22px !important; line height: 30px !important; }
                      .tw-signoff,
                      .tw-footnotes { margin-top: 30px !important; 
                  }
                  .mobile-hidden {
                      display: none !important;
                  }
                  .mobile-d-block {
                      display: block !important;
                  }
                  .mobile-w-full {
                      width: 100% !important;
                  }

                  .mobile-h-auto {
                      height: auto !important;
                  }
                  .mobile-m-h-auto {
                      margin: 0 auto !important;
                  }
                  .mobile-p-0 {
                      padding: 0 !important;
                  }

                  .mobile-p-h-0 {
                      padding-right: 0 !important;
                      padding-left: 0 !important;
                  }
                  .mobile-p-t-0 {
                      padding-top: 0 !important;
                  }
                  .mobile-text-start {
                      text-align: left !important;
                  }
                  .mobile-text-end {
                      text-align: right !important;
                  }
                  .mobile-img-fluid {
                      max-width: 100% !important;
                      width: 100% !important;
                      height: auto !important;
                  }
              }
              </style>
          </head>
          <body style="background: #ffffff; height: 100% !important; margin: 0 auto !important; padding: 0 !important; width: 100% !important; ">  
              <table cellpadding="0" cellspacing="0" style="background: #F7F8FA; border: 0; border-radius: 0; width: 100%; ">
                  <tbody>
                      <tr>
                          <td align="center" class="tw-body" style="padding: 15px 15px 0;">
                              <table cellpadding="0" cellspacing="0" style="background: #F7F8FA; border: 0; border-radius: 0; ">
                                  <tbody>
                                      <tr>
                                          <td align="center" class="" style="width: 600px;">  
                                              <table cellpadding="0" cellspacing="0" style="background: #FFFFFF; border: 0; border-radius: 4px; width: 100%; overflow: hidden;">
                                                  <tbody>
                                                      <tr>
                                                          <td align="center" class="" style="padding: 0;">
                                                              
                                                              <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%; ">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td class="tw-card-banner" style="padding: 30px 35px; text-align: center; ">
                                                                              <img class="  " src="'.$banner_path.'" style="border: 0; height: auto;  max-width: 100%; vertical-align: middle; max-height: 175px" width="550" alt="'.$banner_path.'">
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                              <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%; ">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td class="tw-card-body" style="padding: 20px 35px; text-align: left; color: #6F6F6F; font-family: sans-serif; border-top: 0;">
                                                                              <h1 class="tw-h1" style="font-size: 36px; font-weight: normal; mso-line-height-rule: exactly; line-height: 38px; margin: 20px 0; color: #474747; font-size: 24px; font-weight: bold; mso-line-height-rule: exactly; line-height: 32px; margin: 0 0 20px; ">We Need Your Feedback!</h1>
                                                                              <p class="" style="margin: 20px 0; font-size: 16px; mso-line-height-rule: exactly; line-height: 24px; margin: 20px 0; ">We want to make sure that we understand <span style="color: #474747; font-weight: bold;">the needs and opinions</span> of residents.  Your feedback on this short survey will help us do that.</p>
                                                                              <p class="" style="margin: 20px 0; font-size: 16px; mso-line-height-rule: exactly; line-height: 24px; margin: 20px 0; ">'.$body.'</p>
                                                                              <div class="" style="border-top: 0; font-size: 1px; mso-line-height-rule: exactly; line-height: 1px; max-height: 0; margin: 20px 0; overflow: hidden;">​</div>
                                                                              <table cellpadding="0" cellspacing="0" style="border: 0; width: 100%;">
                                                                                  <tbody>
                                                                                      <tr>
                                                                                          <td>
                                                                                              <table class="button mobile-w-full" align="center" cellspacing="0" cellpadding="0" style="border: 0; margin: 0; margin-left: auto !important; margin-right: auto !important; width: 100%;">
                                                                                                  <tbody>
                                                                                                      <tr>
                                                                                                          <td class="button__td " style="background: #316FEA; border-radius: 4px; text-align:center;">
                                                                                                              <a href="'.$link.'" class="button__a" target="_blank" style="background-color: #17a2b8; border-radius: 4px; color: #FFFFFF; display: block; font-family: sans-serif; font-size: 18px; font-weight: bold; mso-height-rule: exactly; line-height: 1.1; padding: 14px 18px; text-decoration: none; text-transform: none; border: 0;">Tell Us What You Think →</a>
                                                                                                          </td>
                                                                                                      </tr>
                                                                                                  </tbody>
                                                                                              </table>
                                                                                          </td>
                                                                                      </tr>
                                                                                  </tbody>
                                                                              </table>
                                                                              <div class="" style="border-top: 0; font-size: 1px; mso-line-height-rule: exactly; line-height: 1px; max-height: 0; margin: 20px 0; overflow: hidden;">​</div>
                                                                              <p class="" style="margin: 20px 0; font-size: 16px; mso-line-height-rule: exactly; line-height: 24px; margin: 20px 0; ">The survey is short and can be completed on any device. Thank you very much for your help!</p>
                                                                          </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                              <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%; ">
                                                  <tbody>
                                                      <tr>
                                                          <td class="" style="padding: 25px 0; text-align: center; color: #9A9A9A; font-family: sans-serif; font-size: 13px; mso-line-height-rule: exactly; line-height: 20px;">
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
          </body>';
        /*$content = '
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
            <body class="o_body o_bg-light" style="width: 100%;margin: 0px;padding: 0px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #dbe5ea;">  
                <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                  <tbody>
                    <tr>
                      <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                          <tbody>
                            <tr>
                              <td class="o_bg-primary o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-white" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;background-color: #97b8da;color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">                                
                                <h2 class="o_heading o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;font-size: 30px;line-height: 39px;">'.$subject.'</h2>                                
                                </p>
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
                      <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                          <tbody>
                            <tr>
                              <td class="o_bg-white" style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;">&nbsp; </td>
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
                      <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                          <tbody>
                            <tr>
                              <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                                <p style="margin-top: 0px;margin-bottom: 0px;">'.$body.'</p>
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
                      <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                          <tbody>
                            <tr>
                              <td class="o_bg-white o_px-md o_py-xs" align="center" style="background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 8px;padding-bottom: 8px;">
                                <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                  <tbody>
                                    <tr>
                                      <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #0ec06e;border-radius: 4px;">
                                        <a class="o_text-white" href="'.$link.'" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;">Take a survey</a>
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
                      <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                          <tbody>
                            <tr>
                              <td class="o_bg-white" style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;">&nbsp; </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>    
            </body>';*/
        $email->addContent(
          "text/html", $content
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
          $response = $sendgrid->send($email);
          return $Email;
        } catch (\SendGrid\Exception $e) {
          $error_msg = "Error [ ".$e->getCode()." ] ".$e->getMessage();
          return "failure:".$error_msg;
        }
    }

    static function Send_survey_sms($phone, $body, $link)
    {       
      // Your Account SID and Auth Token from twilio.com/console
      $sid    = env( 'TWILIO_SID' );
      $token  = env( 'TWILIO_TOKEN' );
      $from = env( 'TWILIO_FROM' );
      $client = new Client( $sid, $token );
      $link = $link.'/'.base64_encode("SMS").'/'.base64_encode($phone);
      $successful_phones;
      /*for($j = 0; $j < count($phones); $j++)
      { 
        $link = $link.'/'.base64_encode("SMS").'/'.base64_encode($phones[$j]);
        $phone = preg_replace( '/[^0-9]/', '', $phones[$j]);
        if(strlen($phone) == 10)
            $phone = "1".$phone;       
        if(!empty($phone))
        {   
          try {
            $message = $client->messages->create(
                $phone,
                [
                    "body" => $body.PHP_EOL.$link,
                    "from" => $from
                ]
            );
            $successful_phones[] = $phone;
            //return $phone;
          } catch (TwilioException $e) {
             //return "failure";
            print($e->getMessage());
          }  
          
        } 
      }
      return count($successful_phones);*/
      try {
        $body = $body.PHP_EOL.$link.PHP_EOL.'Text STOP to opt out';
        $message = $client->messages->create(
            $phone,
            [
                "body" => $body,
                "from" => $from
            ]
        );
        return $phone;
      } catch (TwilioException $e) {
        $error_msg = "Error [ ".$e->getCode()." ] ".$e->getMessage();
        return "failure:".$error_msg;
        //print($e->getMessage());
      } 
    }
}
