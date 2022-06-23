@extends('layouts.app')
@section('content')
<section class="error">
    <div class="error__inner">
        <h1>403</h1>
        <h2>No Permission to Access</h2>
        <p class="mgb-30">Only Administrators can access to this page.</p>
        <a href="javascript:history.back()">Go <b>Back</b></a>
    </div>
</section>
@endsection