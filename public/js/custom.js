$(document).ready(function(){
	//Show users Login form validation helpers 
	$(".login input").keyup(function(event){
		var input_name = event.currentTarget.name;
		var input_value = $("input[name=" + input_name + "]").val();
		if(input_name == "email")
		{	
			if(validateEmail(input_value) && input_value !='')
			{	
				$(".login_email").removeClass("is-invalid");
				$(".login_email").addClass("is-valid");
			}
			else
			{	
				if($("#login_form .invalid-feedback").length > 0)
					$("#login_form .invalid-feedback").remove();
				$(".login_email").removeClass("is-valid");
				$(".login_email").addClass("is-invalid");
				$(".login_email").parent().append('<div class="invalid-feedback">Please input a valid email address.</div>');
			}
		}
		if(input_name == "password")
		{	
			if(validatePassword(input_value) && input_value !='')
			{	
				$(".login_password").removeClass("is-invalid");
				$(".login_password").addClass("is-valid");
			}
			else
			{	
				if($("#login_form .invalid-feedback").length > 0)
					$("#login_form .invalid-feedback").remove();
				$(".login_password").removeClass("is-valid");
				$(".login_password").addClass("is-invalid");
				$(".login_password").parent().append('<div class="invalid-feedback">Password shuold include 6 to 20 letters with one numeric digit, one uppercase and one lowercase.</div>');
			}
		}
	});
	
	//Login Form Submit
	$("#login_form").submit(function(e){
		e.preventDefault();
		var form_data = $(this).serialize();
		var valdiation_result = $("#login_form .is-invalid").length;
		//Form has validation error before submitting
		if($(".login_email").val().length == 0 || $(".login_password").val().length == 0)
		{
			if ($(".login_email").val().length == 0)
				ShowNotification(`Please input your email address.`, "Form validation error", "error");
			if ($(".login_password").val().length == 0)
				ShowNotification(`Please input your password.`, "Form validation error", "error");
		}
		else
		{
			if(valdiation_result > 0)
				ShowNotification(`Please fix errors to sign in.`, "Form validation error", "error");
			else
			{	
				$.ajax({
		            url : '/login',
		            type : 'POST',
		            data : form_data,
		            success : function(response) {
		            	if(response == 'success-user')
		            	{
		            		//ShowNotification(`Your sign-in success.`, "Sign-in success", "success");
		            		window.location.href = "/step1";
		            	}
		            	else
		            	{	
		            		if(response == "success-admin")
		            			window.location.href = "/admin/survey";
		            		else
		            		{
		            			if(response == 'noexist')
					                ShowNotification(`User does not exist.`, "Wrong Email", "error");
					            else
					            {	
					                ShowNotification(`Passwords do not match.`, "Wrong Password", "error");
					            }
		            		}		            		
		            	}			            
		            }                   
		        });
			}
		}		
	});

	//forget password form validation
	$("#forgotpass_form input").keyup(function(event){
		var input_name = event.currentTarget.name;
		var input_value = $(".forgot_email").val();
		if(input_name == "email")
		{	
			if(validateEmail(input_value) && input_value !='')
			{	
				$(".forgot_email").removeClass("is-invalid");
				$(".forgot_email").addClass("is-valid");
			}
			else
			{	
				if($("#forgotpass_form .invalid-feedback").length > 0)
					$("#forgotpass_form .invalid-feedback").remove();
				$(".forgot_email").removeClass("is-valid");
				$(".forgot_email").addClass("is-invalid");
				$(".forgot_email").parent().append('<div class="invalid-feedback">Please input a valid email address.</div>');
			}
		}
	});
	//Forgot password Form Submit
	$("#forgotpass_form").submit(function(e){
		e.preventDefault();
		var email = $(".forgot_email").val();
		var valdiation_result = $("#forgotpass_form .is-invalid").length;
		if($(".forgot_email").val().length == 0 || valdiation_result > 0)
		{
			if(valdiation_result > 0)
				ShowNotification(`Please fix errors to send forget password request.`, "Form validation error", "error");
			else
				ShowNotification(`Please input your email address.`, "Form validation error", "error");
		}
		else
		{	
			$(".page-loader").show();
			$.ajax({
	            url : '/forget_pass',
	            type : 'POST',
	            data : {'email' : email},
	            success : function(response) {
	            	$(".page-loader").hide();
	            	if(response == 'success')
	            	{		            		
	            		ShowNotification(`Reset Password Email sent.`, "Success", "success");	            		
	            		$("#l-forget-password a").click();
	            		//window.location.href = "/step1";
	            	}
	            	else
	            	{	if(response == 'noexist')
	            			ShowNotification('"' + email + '"' + " does not exist.", "Error", "error");
	            		else
	            			ShowNotification(`Unexpected error happened. Please try again later.`, "Error", "error");
	            	}			            
	            }                   
	        });
		}
	})

	//reset password form validation
	$("#resetpass_form input").keyup(function(event){
		var input_name = event.currentTarget.name;
		var input_value = $("input[name=" + input_name + "]").val();
		if(input_name == "password")
		{	
			if(validatePassword(input_value) && input_value !='')
			{	
				$("#resetpass_form .reset_password").removeClass("is-invalid");
				$("#resetpass_form .reset_password").addClass("is-valid");
			}
			else
			{	
				if($("#resetpass_form .invalid-feedback").length > 0)
					$("#resetpass_form .invalid-feedback").remove();
				$("#resetpass_form .reset_password").removeClass("is-valid");
				$("#resetpass_form .reset_password").addClass("is-invalid");
				$("#resetpass_form .reset_password").parent().append('<div class="invalid-feedback">Password shuold include 6 to 20 letters with one numeric digit, one uppercase and one lowercase.</div>');
			}
		}
		if(input_name == "confirm_password")
		{	
			if(input_value == $("#resetpass_form .reset_password").val() && input_value !='')
			{	
				$("#resetpass_form .confirm_reset_password").removeClass("is-invalid");
				$("#resetpass_form .confirm_reset_password").addClass("is-valid");
			}
			else
			{	
				if($("#resetpass_form .invalid-feedback").length > 0)
					$("#resetpass_form .invalid-feedback").remove();
				$("#resetpass_form .confirm_reset_password").removeClass("is-valid");
				$("#resetpass_form .confirm_reset_password").addClass("is-invalid");
				$("#resetpass_form .confirm_reset_password").parent().append('<div class="invalid-feedback">Password does not match.</div>');
			}
		}
	});
	/*Edit User Page*/
	//Show users Edit User form validation helpers 
	$("#edit_user_form input").keyup(function(event){		
		var input_name = event.currentTarget.name;
		var input_value = $("input[name=" + input_name + "]").val();
		if(input_name == "email")
		{	
			if(validateEmail(input_value) && input_value !='')
			{	
				$("#edit_user_form .email").removeClass("is-invalid");
				$("#edit_user_form .email").addClass("is-valid");
			}
			else
			{	
				if($("#edit_user_form .invalid-feedback").length > 0)
					$("#edit_user_form .invalid-feedback").remove();
				$("#edit_user_form .email").removeClass("is-valid");
				$("#edit_user_form .email").addClass("is-invalid");
				$("#edit_user_form .email").parent().append('<div class="invalid-feedback">Please input a valid email address.</div>');
			}
		}
		if(input_name == "password")
		{	
			if(validatePassword(input_value) && input_value !='')
			{	
				$("#edit_user_form .password").removeClass("is-invalid");
				$("#edit_user_form .password").addClass("is-valid");
			}
			else
			{	
				if($("#edit_user_form .invalid-feedback").length > 0)
					$("#edit_user_form .invalid-feedback").remove();
				$("#edit_user_form .password").removeClass("is-valid");
				$("#edit_user_form .password").addClass("is-invalid");
				$("#edit_user_form .password").parent().append('<div class="invalid-feedback">Password shuold include 6 to 20 letters with one numeric digit, one uppercase and one lowercase.</div>');
			}
		}
		if(input_name == "confirm_password")
		{	
			if(input_value == $("#edit_user_form .password").val() && input_value !='')
			{	
				$("#edit_user_form .confirm_password").removeClass("is-invalid");
				$("#edit_user_form .confirm_password").addClass("is-valid");
			}
			else
			{	
				if($("#edit_user_form .invalid-feedback").length > 0)
					$("#edit_user_form .invalid-feedback").remove();
				$("#edit_user_form .confirm_password").removeClass("is-valid");
				$("#edit_user_form .confirm_password").addClass("is-invalid");
				$("#edit_user_form .confirm_password").parent().append('<div class="invalid-feedback">Password does not match.</div>');
			}
		}
	});

	//Edit User Form Submit
	$("#edit_user_form").submit(function(e){	
		var valdiation_result = $(".is-invalid").length;
		//Form has validation error before submitting
		if($("#edit_user_form .email").val().length == 0 || $("#edit_user_form .password").val().length == 0 || $("#edit_user_form .username").val().length == 0 || valdiation_result > 0 || $("#edit_user_form .confirm_password").val().length == 0)
		{	
			e.preventDefault();
			if(valdiation_result > 0)
				ShowNotification(`Please fix errors to sign in.`, "Form validation error", "error");
			else
			{
				if ($("#edit_user_form .email").val().length == 0)
					ShowNotification(`Please input your email address.`, "Form validation error", "error");
				if ($("#edit_user_form .password").val().length == 0)
					ShowNotification(`Please input your password.`, "Form validation error", "error");
				if ($("#edit_user_form .username").val().length == 0)
					ShowNotification(`Please input your username.`, "Form validation error", "error");
				if ($("#edit_user_form .confirm_password").val().length == 0)
					ShowNotification(`Please input your confirm password.`, "Form validation error", "error");
			}
			
		}	
	});

	//Delete User
	$(".users_table").on("click", ".delete_user", function () {
		var data_id = $(this).data("id");
		console.log(data_id);
		Swal.fire({
		  title: '<h2 id="swal2-title" style="font-size:20px;">Are you sure?<h2>',
		  text: "",
		  /*background: 'rgb(0, 0, 0)',*/
		  type: 'question',
		  showCancelButton: true,
    	  /*confirmButtonColor: "#dc3545",    	  
		  cancelButtonColor: "#5a6268",*/
		  confirmButtonText: 'Delete it',
		  cancelButtonText: "Cancel"
		}).then((result) => {
		  if (result.value) {
		    $(".user" + data_id).submit();
		  }
		});
	});

	//Add User
	//Show users Add User form validation helpers 
	$("#add_user_form input").keyup(function(event){
		var input_name = event.currentTarget.name;
		var input_value = $("input[name=" + input_name + "]").val();
		if(input_name == "email")
		{	
			if(validateEmail(input_value) && input_value !='')
			{	
				$("#add_user_form .email").removeClass("is-invalid");
				$("#add_user_form .email").addClass("is-valid");
			}
			else
			{	
				if($("#add_user_form .invalid-feedback").length > 0)
					$("#add_user_form .invalid-feedback").remove();
				$("#add_user_form .email").removeClass("is-valid");
				$("#add_user_form .email").addClass("is-invalid");
				$("#add_user_form .email").parent().append('<div class="invalid-feedback">Please input a valid email address.</div>');
			}
		}
		if(input_name == "password")
		{	
			if(validatePassword(input_value) && input_value !='')
			{	
				$("#add_user_form .password").removeClass("is-invalid");
				$("#add_user_form .password").addClass("is-valid");
			}
			else
			{	
				if($("#add_user_form .invalid-feedback").length > 0)
					$("#add_user_form .invalid-feedback").remove();
				$("#add_user_form .password").removeClass("is-valid");
				$("#add_user_form .password").addClass("is-invalid");
				$("#add_user_form .password").parent().append('<div class="invalid-feedback">Password shuold include 6 to 20 letters with one numeric digit, one uppercase and one lowercase.</div>');
			}
		}
		if(input_name == "confirm_password")
		{	
			if(input_value == $("#add_user_form .password").val() && input_value !='')
			{	
				$("#add_user_form .confirm_password").removeClass("is-invalid");
				$("#add_user_form .confirm_password").addClass("is-valid");
			}
			else
			{	
				if($("#add_user_form .invalid-feedback").length > 0)
					$("#add_user_form .invalid-feedback").remove();
				$("#add_user_form .confirm_password").removeClass("is-valid");
				$("#add_user_form .confirm_password").addClass("is-invalid");
				$("#add_user_form .confirm_password").parent().append('<div class="invalid-feedback">Password does not match.</div>');
			}
		}
	});

	//Add User Form Submit
	$("#add_user_form").submit(function(e){	
		var valdiation_result = $(".is-invalid").length;
		//Form has validation error before submitting
		if($("#add_user_form .email").val().length == 0 || $("#add_user_form .password").val().length == 0 || $("#add_user_form .username").val().length == 0 || valdiation_result > 0 || $("#add_user_form .confirm_password").val().length == 0)
		{	
			e.preventDefault();
			if(valdiation_result > 0)
				ShowNotification(`Please fix errors to sign in.`, "Form validation error", "error");
			else
			{
				if ($("#add_user_form .email").val().length == 0)
					ShowNotification(`Please input your email address.`, "Form validation error", "error");
				if ($("#add_user_form .password").val().length == 0)
					ShowNotification(`Please input your password.`, "Form validation error", "error");
				if ($("#add_user_form .confirm_password").val().length == 0)
					ShowNotification(`Please input your confirm password.`, "Form validation error", "error");
				if ($("#add_user_form .username").val().length == 0)
					ShowNotification(`Please input your username.`, "Form validation error", "error");
			}
			
		}	
	});

	//menu active show operations
	$(".sidebar .scrollbar .navigation li a").click(function(e){
		$(".sidebar .scrollbar .navigation .navigation__active").removeClass('navigation__active');
		$(".navigation__sub ul .navigation__active").removeClass('navigation__active');
		$(this).parent().addClass("navigation__active");
		//$(".navigation__sub ul").hide();
		/*alert($(this).attr('href'));
		e.preventDefault();
		var href = $(this).attr('href');    		
		if(href != undefined) {
				e.preventDefault();
		        $(".content").load($(this).attr('href'));
		    }	*/
	});
	//csv menu sync with steps on header of body
	$("#smartwizard ul li").click(function(){
		csv_submenu();
	});

	$("#smartwizard .btn-toolbar button").click(function(){
		csv_submenu();
	});

	//survey form
	$(".survey_form .editable").click(function(){
		$(".survey_form .being_edited").removeClass('being_edited');
		$(".survey_form .editing_block").removeClass('editing_block');
		$(this).addClass("being_edited");
		$(this).parent().parent().parent().parent().parent().addClass("editing_block");
	});
	
	/*$("#survey_form button").click(function(e){
		e.preventDefault();
		var data = $("#survey_form").serialize();
		console.log(data);
	});*/
	//Submit survey form validation
	$("#submit_survey input").keyup(function(event){		
		var input_name = event.currentTarget.name;
		var input_value = $("input[name=" + input_name + "]").val();
		if(input_name == "email")
		{	
			if(validateEmail(input_value) && input_value !='')
			{	
				$("#submit_survey .email").removeClass("is-invalid");
				$("#submit_survey .email").addClass("is-valid");
			}
			else
			{	
				if($("#submit_survey .invalid-feedback").length > 0)
					$("#submit_survey .invalid-feedback").remove();
				$("#submit_survey .email").removeClass("is-valid");
				$("#submit_survey .email").addClass("is-invalid");
				$("#submit_survey .email").parent().append('<div class="invalid-feedback">Please input a valid email address.</div>');
			}
		}
	});

	//Save email/sms config form validation
	$("#save_config_form input").keyup(function(event){		
		var input_name = event.currentTarget.name;
		var input_value = $("input[name=" + input_name + "]").val();
		if(input_name == "e_sender")
		{	
			if(validateEmail(input_value) && input_value !='')
			{	
				$("#save_config_form .e_sender").removeClass("is-invalid");
				$("#save_config_form .e_sender").addClass("is-valid");
			}
			else
			{	
				if($("#save_config_form .invalid-feedback").length > 0)
					$("#save_config_form .invalid-feedback").remove();
				$("#save_config_form .e_sender").removeClass("is-valid");
				$("#save_config_form .e_sender").addClass("is-invalid");
				$("#save_config_form .e_sender").parent().append('<div class="invalid-feedback">Please input a valid email address.</div>');
			}
		}
	});

	//user feedback available flag
	$(".users_table").on("change", ".feedback_available_flag", function () {
		var user_id = $(this).data("id");
		var feedback_available = $(this).data("value");
		if(feedback_available == "inactive")
		{
			feedback_available = "active";
			$(this).parent().parent().parent().parent().parent().find(".feedback_available_td").find("span").removeClass("badge-danger");
			$(this).parent().parent().parent().parent().parent().find(".feedback_available_td").find("span").addClass("badge-success");
			$(this).attr("data-original-title", "Deactivate feedbacks");
		}
		else
		{
			feedback_available = "inactive";
			$(this).parent().parent().parent().parent().parent().find(".feedback_available_td").find("span").removeClass("badge-success");
			$(this).parent().parent().parent().parent().parent().find(".feedback_available_td").find("span").addClass("badge-danger");
			$(this).attr("data-original-title", "Activate feedbacks");
		}
		$(this).parent().parent().parent().parent().parent().find(".feedback_available_td").find("span").text(feedback_available);
		$(this).data('value', feedback_available);
		$.ajax({
            url : '/admin/update_feedback_available_status',
            type : 'POST',
            data : {'id' : user_id, 'feedback_available': feedback_available},
            success : function(response) {
            	if(response == 'success')
            	{		            		
            		ShowNotification('Feedback available flag was set "<b>' + feedback_available + '"</b>', "Success", "success");
            	}		            
            }                   
        });
	});
	//remove custom questions in step1
	$('.remove_c_qa').click(function(){	
		$(this).tooltip('hide');	
        var classname = $(this).data("id");
        $("." + classname).remove();
        var input = '<input name="'+classname+'" value="removed" type="hidden">';
        $("#survey_form").append(input);        
    });
	//Delete report
	$(".reports_table").on("click", ".delete_report", function () {	
		var data_id = $(this).data("id");
		Swal.fire({
		  title: '<h2 id="swal2-title" style="font-size:20px;">Are you sure?<h2>',
		  text: "",
		  /*background: 'rgb(0, 0, 0)',*/
		  type: 'question',
		  showCancelButton: true,
    	  /*confirmButtonColor: "#dc3545",    	  
		  cancelButtonColor: "#5a6268",*/
		  confirmButtonText: 'Delete it',
		  cancelButtonText: "Cancel"
		}).then((result) => {
		  if (result.value) {
		    $(".report" + data_id).submit();
		  }
		});
	});

	//Survey submit
	$("#send_survey button").unbind('click').click(function(){
		var submit_type = $(this).data("type");
		$('.alert').fadeOut('fast');
        $("#send_survey").hide();
        $(".submit_btn_div").hide();
		if(submit_type == "email")
		{			
	        $(".card-body").append('<div class="row survey_result"><div class="col-md-12"><div class="image align-center"><img src="/img/success.gif" style="width: 160px;margin: 0 auto;margin-bottom: 30px;"></div><div class="form-group align-center"><label class="survey_success_msg">Survey was successfully submitted.</label><br><br><a class="alink backtostep3 align-center" onclick="goback();">Go Back</a></div></div></div>');
	        $('.step3_check').show();
	        //send ajax
	        $.ajax({
	            url : '/launch_survey',
	            type : 'POST',
	            success : function(response) {
		            var result = response.split("|");
	            	var phone = result[0];
	            	var email = result[1];            	      	
	            	var text = 'We have sent <b>' + phone + '</b> phone numbers via text and <b>' + email + '</b> emails.';
	            	$(".survey_success_msg").html(text);
	            	/*$("#send_survey").on("click", ".survey_result_go_back", function () {
	            		console.log("clicked");
	            		$(".survey_result").hide();
	            		$("#send_survey").show();
	            		$(".submit_btn_div").show();
	            	})*/
	            }                   
	        });
		}
		else
		{	
			//$(".launch_div").css('max-width', "800px");
			$(".p2ptext_area").show();
			var phone;
			var phone_id;
			$(".p2ptext_area").unbind('click').on("click", ".send_all_emails", function () {
				var dom = $(this);
				dom[0].disabled = true;
		        dom[0].innerText = "Sending All Emails...";
				$.ajax({
		            url : '/launch_all_emails',
		            type : 'POST',
		            success : function(response) {
		            	console.log(response);
		            	ShowNotification('We have sent <b> ' + response + ' </b> emails successfully.', "Success", "success");
		            	dom[0].innerText = "Sent "+ response +" Emails";
			            /*var result = response.split("|");
		            	var phone = result[0];
		            	var email = result[1];            	      	
		            	var text = 'We have sent <b>' + phone + '</b> phone numbers via text and <b>' + email + '</b> emails.';
		            	$(".survey_success_msg").html(text);*/
		            }                   
		        });
			});
			$("#data-table3").unbind('click').on("click", ".p2p_text", function () {	
				var dom = $(this);
				console.log(dom);
				phone = $(this).data("phone").toString();
				phone_id = $(this).data("id").toString();				
				if(phone.length < 11 || phone.substring(0,1) != "1")
					phone = "1" + phone;
				console.log(phone);
				$.ajax({
		            url : '/p2p_text',
		            type : 'POST',
		            data : {'phone' : phone, 'id' : phone_id},
		            success : function(response) {
		            	console.log(response);
		            	if(response == "success")
		            	{	
		            		dom[0].disabled = true;
		            		dom[0].innerText = "Sent";
		            		ShowNotification('SMS was sent to <b> ' + phone + ' </b> successfully.', "Success", "success");
		            	}
		            	else
		            	{	
		            		var error = response.substr(8, response.length);
		            		console.log(error);
		            		ShowNotification(error, "Error", "error");
		            	}
		            }                   
		        });
			});			
		}
	});

});

function csv_submenu()
{
	var step_num = $("#smartwizard ul .active").data("order");
	$(".csv .navigation__active").removeClass("navigation__active");
	$(".csv_" + step_num).addClass("navigation__active");
}
/*start of validation functions*/
function validateEmail(email) 
{
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePassword(pass)
{ 
	var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
	if(pass.match(passw))
		return true;
}
/*end of validation functions*/

/*toastr notification*/
function ShowNotification(message, title, type) {
  toastr.options = {
      closeButton: true,
      debug: false,
      progressBar: true,
      positionClass: 'toast-top-right',
      onclick: null,
      showEasing: 'swing',
      hideEasing: 'linear',
      delay: 5000,
      closeEasing: 'linear'
  };
  $('#toastrOptions').text(`Command: toastr[${type}](${message},${title})\n\ntoastr.options = `
      + JSON.stringify(toastr.options, null, 2)
  );
  var $toast = toastr[type](message, title);
}

/*multistep-form*/
if($("#smartwizard").length > 0)
	$('#smartwizard').smartWizard({
		selected: 0,
	    theme: 'arrows',
		autoAdjustHeight:true,
		transitionEffect:'fade',
		showStepURLhash: false,
	});
