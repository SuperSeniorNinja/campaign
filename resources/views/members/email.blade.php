@extends("layouts.app")
@section('content')
  <form action="{{route('send_sms')}}" method='POST'>
    @csrf
    @if($errors->any())
        <ul>
         @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
         @endforeach
    @endif

    @if( session( 'success' ) )
         {{ session( 'success' ) }}
    @endif
    <label>Phone numbers (seperate with a comma [,])</label>
    <input type="text" name="number" class="form-control input-mask" data-mask="000-00-0000000" placeholder="eg: 000-00-0000000" autocomplete="off" maxlength="14">
    <div class="form-group">
      <label>Message</label>
      <textarea class="form-control textarea-autosize text-counter" placeholder="Message here..." name='message'></textarea>
        <div class="text-count-wrapper">
          <div class="text-count-message" style="display: inline;">Remaining: 
            <span class="text-count">200</span>
          </div>
          <div class="text-count-overflow-wrapper" style="display: none;">              
          </div>
        </div>
    </div>
    <button type='submit' class="btn btn-theme-dark btn--icon-text"><i class="zwicon-mail"></i> Send</button>
  </form>
@endsection