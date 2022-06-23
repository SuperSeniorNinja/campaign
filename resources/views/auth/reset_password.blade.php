@extends('layouts.app')
@section('content')
<div class="login">
    <div class="row">
        <div class="col-md-9 col-sm-8 align-center">
            <h1 class="login_heading">OUR STRENGTH IS THE<br>SUM OF OUR PARTS.</h1>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="login__block active" id="l-forget-password">
                <div class="login__block__header">
                    <i class="zwicon-user-circle"></i>
                    Forgot Password?                    
                </div>
                <div class="login__block__body">
                    <form id="resetpass_form" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="password" name="password" class="reset_password form-control text-center" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirm_password" class="confirm_reset_password form-control text-center" placeholder="Confirm password">
                        </div>
                        <button type="submit" class="btn btn-theme-dark btn--icon-text"><i class="zwicon-lock"></i> Reset Password</button><br>
                    </form>
                </div>
            </div>
        </div>
    </div><br>
    <img src="{{ asset('img/logo.png') }}">  
</div>
@endsection

        