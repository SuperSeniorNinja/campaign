@extends('layouts.app')
@section('content')
<div class="login">
    <div class="row">
        <div class="col-md-9 col-sm-8 align-center">
            <h1 class="login_heading">OUR STRENGTH IS THE<br>SUM OF OUR PARTS.</h1>
        </div>
        <div class="col-md-3 col-sm-4">
            <!-- Login -->
            <div class="login__block active" id="l-login">
                <div class="login__block__header">
                    <i class="zwicon-user-circle"></i>
                    Please sign in.
                </div>
                <div class="login__block__body">
                    <form id="login_form" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" name="email" class="login_email form-control text-center" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="login_password form-control text-center" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-info btn--icon-text"><i class="zwicon-sign-in"></i> Sign in</button>
                        <div class="mgt-30">
                            <a data-sa-action="login-switch" data-sa-target="#l-forget-password" href="#">Forgot Password?</a>
                        </div>
                    </form>                 
                </div>
            </div>
            <!-- Forgot Password -->
            <div class="login__block" id="l-forget-password">
                <div class="login__block__header">
                    <i class="zwicon-user-circle"></i>
                    Forgot Password?                    
                </div>
                <div class="login__block__body">
                    <form id="forgotpass_form" method="POST">
                        {{ csrf_field() }}
                        <p class="mb-5">Enter your sign-in email address.</p>
                        <div class="form-group">
                            <input type="email" name="email" class="forgot_email form-control text-center" placeholder="Email address">
                        </div>
                        <button type="submit" class="btn btn-info btn--icon-text"><i class="zwicon-mail"></i> Send email</button><br>
                    </form>
                </div>
                <div class="mgb-30">
                    <a data-sa-action="login-switch" data-sa-target="#l-login" href="#">Back to <b>Sign in</b></a>
                </div>
            </div>
        </div>
    </div><br>
    <img src="{{ asset('img/logo.png') }}">  
</div>
@endsection

        