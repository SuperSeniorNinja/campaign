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
<div class="content__inner content__inner--sm">
    <div class="card new-contact">
        <div class="new-contact__header">
            <h4>Edit User</h4>
        </div>
        <div class="card-body">
        	<form id="edit_user_form" method="POST" action="{{route('admin.users.update', $user)}}">
        		{{ csrf_field() }}
        		{{ method_field('PUT') }}
        		<div class="row">
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>Username</label>
	                        <input type="text" class="username form-control" name="username" value="{{ $user->username}}">
	                    </div>
	                </div>
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>Email Address</label>
	                        <input type="email" class="email form-control" name="email" value="{{ $user->email }}">
	                    </div>
	                </div>
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>User Role</label>
	                        <select class="select2 level form" name="level" data-placeholder="Select User Role">
	                            <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
	                            <option value="user" {{ $user->level == 'user' ? 'selected' : '' }}>User</option>
	                        </select>
	                    </div>
	                </div>
	                <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Subject</label>
                          <input type="text" class="e_subject form-control" name="e_subject" value="{{ $user->e_subject }}" required="">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Subject</label><br>
                          <p>The Email Subject is the first text recipients see when an email reaches their inbox and needs to be attention-grabbing.</p>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Sender ( email )</label>
                          <input type="email" class="e_sender form-control" name="e_sender" value="{{ $user->e_sender }}" required="">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Sender ( email )</label><br>
                          <p>The Email Sender ( email ) is what your recipients will see.</p>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Body</label>
                          <textarea type="text" name="e_body" class="e_body form-control" placeholder="Email body text here..." required="" rows="5">{{ $user->e_body }}</textarea>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Body</label><br>
                          <p>The Email Body is main and long text message what you want to tell audience via email.</p>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>SMS Body</label>
                          <textarea type="text" name="s_body" class="s_body form-control" placeholder="SMS body text here..." required="" rows="5">{{ $user->s_body }}</textarea>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>SMS Body</label><br>
                          <p>The SMS Body is main and long text message what you want to tell audience via SMS.</p>
                      </div>
                  </div>
		            <div class="col-md-12 text-center">
		                <button type="submit" class="btn btn-success">Update</button>
		            </div>
		        </div>
        	</form>            
        </div>
    </div>
</div>
@endsection