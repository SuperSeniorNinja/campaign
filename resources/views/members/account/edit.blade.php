@extends('layouts.app')
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
    		console.log("here");
		    $('.alert').fadeOut('fast');
		}, 30000);
    </script>
@endif
<div class="content__inner content__inner--sm wid500">
    <div class="card new-contact">
        <div class="new-contact__header">
            <h4>My profile</h4>
        </div>
        <div class="card-body">
        	<form id="edit_user_form" method="POST" action="{{route('userupdate', Auth::user())}}">
        		{{ csrf_field() }}
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
        	</form>            
        </div>
    </div>
</div>
@endsection