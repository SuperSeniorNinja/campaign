@extends('layouts.app')
@section('content')
  @if (\Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
          {!! \Session::get('success') !!}
      </div>
      <script type="text/javascript">
            setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 3000);
        </script>
  @endif
  <div class="content__inner">
      <div class="card">
          <div class="card-body">
              <h4 class="card-title">Reports</h4>
              <div class="table-responsive data-table">
                  <table id="data-table" class="reports_table styled_table table table-hover">
                      <thead>
                      <tr>
                          <th>ID</th>
                          <th>Username</th>
                          <th>Sent Emails</th>
                          <th>Sent SMS</th>
                          <th>Responses</th>
                          <th>Survey Link</th>
                          <th>Feedback</th>
                          <th class="text-center">Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      	@for ($i =0; $i < count($reports); $i++)
					        <tr>
	                            <td class="align-middle">{{$reports[$i]["id"]}}</td>
	                            <td class="align-middle">{{$reports[$i]["username"]}}</td>
	                            <td class="align-middle">{{$reports[$i]["sent_emails"]}}</td>
	                            <td class="align-middle">{{$reports[$i]["sent_sms"]}}</td>
	                            <td class="align-middle feedback_available_td">{{$reports[$i]["num_responses"]}}</td>
	                            <td class="align-middle"><a class="alink" href="<?php if($reports[$i]['publish_link'] != 'noexist' ) echo $reports[$i]['publish_link']; else echo ""; ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php if($reports[$i]['publish_link'] == 'noexist' ) echo "This user has not completed a survey yet."; ?>">@php if($reports[$i]['publish_link'] != 'noexist' ) echo $reports[$i]['publish_link']; else echo "Not available."; @endphp</a></td>	                            
	                            <td class="align-middle"><a class="alink" href="<?php if($reports[$i]['feedback_link'] != 'noexist' ) echo $reports[$i]['feedback_link']; else echo ""; ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php if($reports[$i]['feedback_link'] == 'noexist' ) echo "This user has not any responses yet or feedback file is temporarily not avilable"; ?>" download>@php if($reports[$i]['feedback_link'] != 'noexist' ) echo "Download feedback"; else echo "Not available"; @endphp</a></td>
	                            <td class="text-center m_actions align-middle">
	                            	<a type="button" target="_blank" href="<?php if($reports[$i]['publish_link'] != 'noexist' ) echo '/admin/edit_survey/'.$reports[$i]["id"]; else echo ""; ?>" class="btn btn--icon btn-primary" title="Edit {{$reports[$i]['username']}}'s survey questions" data-toggle="tooltip" data-placement="top" data-original-title="Edit {{$reports[$i]['username']}}'s survey questions" data-id="{{$reports[$i]['id']}}" style="color: #fff;" <?php if($reports[$i]['publish_link'] == 'noexist' ) echo "disabled";?>><i class="zwicon-pencil"></i></a>
		                            <a type="button" class="btn btn-danger btn--icon delete_report" title="Delete report" data-toggle="tooltip" data-placement="top" data-original-title="Delete report" data-id="{{$reports[$i]['id']}}" style="color: #fff;"><i class="zwicon-delete"></i>
	                                  <form action="{{route('admin.delete_feedback', $reports[$i]['id'])}}" name="{{$reports[$i]['id']}}" method="POST" class="report{{$reports[$i]['id']}}">
	                                    {{ csrf_field() }}                     
	                                  </form>
	                                </a>
	                            </td>
                            </tr>
					    @endfor
              
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
@endsection