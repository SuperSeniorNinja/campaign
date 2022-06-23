@extends("layouts.app")
@section('content')
    <!-- <div class="card">
        <div class="card-body">
            <h4>Upload a CSV</h4>
            <h6>Drag or drop a .csv to upload and use.</h6>
            <form class="dropzone" id="dropzone-upload"></form>
        </div>
    </div> -->
    <script type="text/javascript">
      /*setTimeout(function() {
          $('.step1_check').show();
      }, 0);*/
    </script>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! Session::get('success') !!}
        </div>
    @endif
  <div id="smartwizard">
    <ul>
         <li data-order="1"><a href="#step-1">Step 1<br /><small>Prepare Your Audience Data</small></a></li>
         <li data-order="2"><a href="#step-2">Step 2<br /><small>Add Your Audience Data</small></a></li>
         <li data-order="3"><a href="#step-3">Step 3<br /><small>Preview & Map identifiers </small></a></li>
         <li data-order="4"><a href="#step-4">Step 4<br /><small><!-- Upload Your Audience Data -->Finish</small></a></li>
         <!-- <li data-order="5"><a href="#step-5">Step 5<br /><small>Finish</small></a></li> -->
    </ul>
    <div class="mt-4" style="min-height: auto;">
        <div id="step-1">
          <div class="card">
            <div class="heading">
                <h4>Prepare Your Audience Data</h4>                
            </div>            
            <div class="row">
                <div class="col-md-8">
                  <p class="mgb-30">Your customer list is a .CSV file that contains your audience data. Identifiers in your audience list are to used to maintain consistency between state and national lists.</p>
                  <div class="form-group mgb-30">
                    <h5>Relevant Identifiers:</h5><br>
                    <div class="mgb-30">
                      <a href="#" class="badge badge-secondary">Voter File VANID</a>
                      <a href="#" class="badge badge-secondary">First Name</a>
                      <a href="#" class="badge badge-secondary">Last Name</a>
                      <a href="#" class="badge badge-secondary">Address</a>
                      <a href="#" class="badge badge-secondary">City</a>
                      <a href="#" class="badge badge-secondary">State</a>                      
                    </div>
                    <div class="mgb-30">
                      <a href="#" class="badge badge-secondary">Zip5</a>
                      <a href="#" class="badge badge-secondary">Zip4</a>
                      <a href="#" class="badge badge-secondary">Phone Number</a>
                      <a href="#" class="badge badge-secondary">Email</a>
                      <a href="#" class="badge badge-secondary">CD</a>
                      <a href="#" class="badge badge-secondary">SD</a>
                      <a href="#" class="badge badge-secondary">HD</a>
                    </div>                    
                  </div>
                  <div class="mgb-30">
                    <a href="{{ asset('uploads/sample.csv') }}" class="download_list_template alink" download><i class="zwicon-download"></i> Download List Template</a>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="image align-center">
                    <img src="{{ asset('img/big-lock.png') }}">
                  </div>
                  <div class="form-group">
                    <h4 class="align-center">Your Audience Data is Hashed</h4>
                    <p>When your audience data is uploaded, we use a cryptographic security method known as
                      hashing which turns the data into randomized code and cannot be reversed.</p>
                  </div>
                </div>          
            </div>
          </div>
        </div>
        <div id="step-2">
          <div class="card">
            <div class="heading">
                <h4>Add Your Audience Data</h4>
            </div>            
            <div class="row">
              <div class="col-md-12">
                <p class="mgb-30">Before uploading your list, make sure you have enough identifiers in the correct format. The file must be a .csv file.</p>
                <div class="mgb-30">
                  <a href="#" class="download_list_template alink"><i class="zwicon-download"></i> Download List Template</a>
                </div>
                <div class="form-group">
                  <h6>Add a list in CSV format.</h6>
                  <form class="dropzone" id="dropzone-upload" >
                    {{ csrf_field() }}
                  </form>
                </div>
              </div>       
            </div>
          </div>
        </div>
        <div id="step-3" class="">
          <div class="card">
            <div class="card-body">
                <div class="heading">
                    <h4>Preview and map identifiers</h4>
                    <p class="mgb-30">Map your data to upload it. Your data will be hashed before it's uploaded.</p>            
                </div>
                <div class="preview_body">
                </div>                
            </div>
          </div>
        </div>
        <!-- <div id="step-4" class="">
          <div class="card">
            <div class="card-body">
              <div class="image align-center">
                <img src="{{ asset('img/upload_icon.png') }}">
              </div>
              <div class="form-group align-center mgb-30">
                <h4 class="align-center">Upload in progress</h4>
                <div class="progress">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 40%" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p>Your audience list is currently being hashed. Waiting...</p>
              </div>
              <div class="form-group align-center">
                <h3 class="mgb-30 percent"></h3>
                <div class="align-center">
                  <label><b class="num_rows"></b> rows uploaded.</label>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <div id="step-4" class="">
          <div class="card">
            <div class="card-body">
              <div class="image align-center">
                <img src="{{ asset('img/success.gif') }}">
              </div>
              <div class="form-group align-center mgb-30">
                <h4 class="align-center">Your audience list has been successfully hashed and uploaded.</h4>
                <label><b class="num_rows"></b> rows uploaded.</label>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection