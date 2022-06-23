<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm')->name('home');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('forget_pass', 'Auth\LoginController@forget_pass');


Route::get('reset-password/{token}', 'Auth\LoginController@showPasswordResetForm');
Route::post('reset-password/{token}', 'Auth\LoginController@resetPassword');
Route::get('password/reset/{token}', 'Auth\LoginController@show_reset_form');
Route::get('500', 'Admin\UserController@show_permission_error')->name('permission_error');

/*step1 :Survey*/
Route::get('step1', 'SurveyController@index')->name('step1');
Route::post('save_survey', 'SurveyController@save_survey')->name('save_survey');
Route::get(base64_encode("survey").'/{id}', 'SurveyController@show_survey')->name('show_survey');
Route::get(base64_encode("survey").'/{id}/{from}/{sender}', 'SurveyController@show_survey_submit_form')->name('show_survey_submit_form');
/*Route::get(base64_encode("survey").'/{id}?'.base64_encode("emails").'={email}&'.base64_encode("sms").'={sms}', 'SurveyController@show_survey')->name('show_survey');*/
Route::post('Submit_feedback', 'Admin\FeedbackController@Submit_feedback')->name("Submit_feedback");

/*step2 : Email/sms configuration*/
//Route::get('step2', 'SetupController@index')->name('step2');
Route::post('save_config', 'SetupController@Save_config')->name("save_config");

/*step3 : csv upload and matching with identifiers*/
Route::get('step2', 'CsvController@index')->name('step2');
Route::post('csv.upload', 'CsvController@fileUpload')->name('csv.upload');
Route::post('csv_head_upload', 'CsvController@csv_head_upload')->name('csv_head_upload');

/*Step4 : Launch*/
Route::get('step3', 'LaunchController@index')->name('step3');
Route::post('launch_survey', 'LaunchController@launch_survey')->name('launch_survey');
Route::post('launch_all_emails', 'LaunchController@launch_all_emails')->name('launch_all_emails');
Route::get('launch_all_emails_and_texts', 'LaunchController@launch_all_emails_and_texts')->name('launch_all_emails_and_texts');
Route::post('p2p_text', 'LaunchController@p2p_text')->name('p2p_text');


Route::get('email', 'EmailController@SendEmail')->name('email');
Route::get('thankyou', 'Admin\FeedbackController@show_thankyou')->name('thankyou');

Route::get('setting', 'UserController@myprofile')->name('myprofile');
Route::post('userupdate', 'UserController@update')->name('userupdate');
//Route::get('setting', 'Admin\UserController@myprofile')->name('myprofile');
Route::group(['middleware' => 'is.admin'], function () {
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function(){
		Route::resource('users', 'UserController', [
		    'except' => ['show']
		]);
		Route::post('update_feedback_available_status', 'UserController@Update_feedback_available_status')->name('update_feedback_available_status');
		Route::get('/survey', 'SurveyController@index')->name('survey');
		Route::get('/reports', 'ReportController@index')->name('reports');
		Route::get('edit_survey/{id}', 'FeedbackController@Show_feedbacks_for_each_user')->name('show_feedbacks_for_each_user');
		Route::post('delete_feedback/{id}', 'ReportController@delete_feedback')->name('delete_feedback');
		/*Route::resource('feedbacks', 'FeedbackController', [
		    'except' => ['show']
		]);*/

	});	
});