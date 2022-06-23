@extends('layouts.app')
@section('content')
<section class="error">
    <div class="error__inner">
        <h1>404</h1>
        <h2>Not Found</h2>
        <p class="mgb-30">The page you are looking for does not exist.</p>
        <a href="javascript:history.back()">Go <b>Back</b></a>
    </div>
</section>
@endsection