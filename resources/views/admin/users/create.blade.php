@extends('layouts.app')
@section('content')
@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! \Session::get('success') !!}
    </div>
@endif
@if (\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! \Session::get('error') !!}
    </div>
@endif
<div class="content__inner content__inner--sm wid500">
    <div class="card new-contact">
        <div class="new-contact__header">
            <h4>Add User</h4>
        </div>
        <div class="card-body">
        	<form id="add_user_form" method="POST" action="{{route('admin.users.store')}}">
        		{{ csrf_field() }}
        		<div class="row">
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>Username</label>
	                        <input type="text" class="username form-control" name="username">
	                    </div>
	                </div>
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>Email Address</label>
	                        <input type="email" class="email form-control" name="email">
	                    </div>
	                </div>
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>User Role</label>
	                        <select class="select2 level" name="level" data-placeholder="Select User Role">
	                            <option value="admin">Admin</option>
	                            <option value="user" selected="">User</option>
	                        </select>
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
		                <button type="submit" class="btn btn-success">Add User</button>
		            </div>
		        </div>
        	</form>            
        </div>
    </div>
</div>
@endsection