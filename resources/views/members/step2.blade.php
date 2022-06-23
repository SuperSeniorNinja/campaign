@extends("layouts.app")
@section('content')
  @if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! \Session::get('success') !!}
    </div>
    <script type="text/javascript">
      window.location.href="/step3";
      /*setTimeout(function() {        
          $('.alert').fadeOut('fast');
          window.location.href="/step3";
      }, 3000);*/
    </script>
  @endif
  <div class="content__inner content__inner--sm">
    <div class="card new-contact">
        <div class="new-contact__header">
            <h3>Setup Email/SMS Configuration</h3>
        </div>
        <div class="card-body">
          <form id="save_config_form" method="POST" action="{{route('save_config')}}">
            {{ csrf_field() }}
            <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email Subject</label>
                          <input type="text" class="e_subject form-control" name="e_subject" value="{{ Auth::user()->e_subject }}" required="">
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
                          <input type="email" class="e_sender form-control" name="e_sender" value="{{ Auth::user()->e_sender }}" required="">
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
                          <textarea type="text" name="e_body" class="e_body form-control" placeholder="Email body text here..." required="" rows="5">{{ Auth::user()->e_body }}</textarea>
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
                          <textarea type="text" name="s_body" class="s_body form-control" placeholder="SMS body text here..." required="" rows="5">{{ Auth::user()->s_body }}</textarea>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>SMS Body</label><br>
                          <p>The SMS Body is main and long text message what you want to tell audience via SMS.</p>
                      </div>
                  </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success">Save and Continue</button>
                </div>
            </div>
          </form>            
        </div>
    </div>
</div>
@endsection