@extends("front.app")
@section('content1')
<style type="text/css">
	body
	{
		background-color: #fff !important;
	}
	.image
	{
		width: 160px;
	    margin: 0 auto;
	    margin-bottom: 30px;
	} 
	img
	{
		max-width: 100%;    
	}
	.content
	{
		display: none;
	}
	.thankyou
	{
		position: fixed; 
		top: 40%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
</style>
	<div class="col-md-12 align-center thankyou">
		<div class="image align-center">
	        <img src="{{ asset('img/success.gif') }}">
	    </div>
		<h3>Thank you for taking our survey!</h3>
		<h5>Your feedback was successully submitted.</h5>
	</div>
@endsection