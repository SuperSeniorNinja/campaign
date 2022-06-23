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
  <div class="content__inner">
      <div class="card">
          <div class="card-body">
              <h4 class="card-title">Users</h4>
              <div class="table-responsive data-table">
                  <table id="data-table" class="users_table table table-hover styled_table">
                      <thead>
                      <tr>
                          <th>ID</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Feedback Status</th>
                          <th>Created at</th>
                          <th class="text-center">Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user)
                          <tr>
                            <td class="align-middle">{{ $user->id}}</td>
                            <td class="align-middle">{{$user->username}}</td>
                            <td class="align-middle">{{$user->email}}</td>
                            <td class="align-middle"><span class="badge {{ $user->level == 'admin' ? 'bg-green' : 'bg-cyan' }}">{{$user->level}}</span></td>
                            <td class="align-middle feedback_available_td"><span class="badge {{ $user->feedback_available == 'active' ? 'badge-success' : 'badge-danger' }}">{{$user->feedback_available}}</span></td>
                            <td class="align-middle">{{$user->created_at}}</td>
                            <td class="text-center m_actions align-middle">
                              <div>
                                <div class="feedback_available_flag_div">
                                  <div class="toggle-switch toggle-switch--green">
                                    <input type="checkbox" class="toggle-switch__checkbox feedback_available_flag" data-id="{{ $user->id}}" data-value="{{ $user->feedback_available }}" data-toggle="tooltip" data-placement="top" data-original-title="{{ $user->feedback_available == 'active' ? 'Turn off campaign' : 'Turn on campaign' }}" {{ $user->feedback_available == 'active' ? 'checked' : '' }}>
                                    <i class="toggle-switch__helper"></i>
                                  </div>
                                </div>                                
                                <a type="button" href="{{route('admin.users.edit', $user)}}" class="btn btn-success btn--icon" title="Edit" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="Edit" data-id="{{ $user->id}}"><i class="zwicon-pencil"></i></a>
                                <a type="button" class="btn btn-danger btn--icon delete_user" title="Delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="{{ $user->id}}" style="color: #fff;"><i class="zwicon-delete"></i>
                                  <form action="{{route('admin.users.destroy', $user)}}" name="{{ $user->id}}" method="POST" class="user{{ $user->id}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}                        
                                  </form>
                                </a>                                
                              </div>                              
                            </td>
                          </tr>
                        @endforeach                      
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
@endsection