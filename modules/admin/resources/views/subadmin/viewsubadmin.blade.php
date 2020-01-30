@extends('admin::layouts.admin')
@section('admin::content')

<div class="content">
        <div class="container-fluid">
          <!--flash message-->
          @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b>{{ $message }} </b></span>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b>{{ $message }} </b></span>
                </div>
            @endif
            <!--end flash messages-->
            <?php //echo "<pre>";print_r($users);exit;?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Sub Admin</h4>
                  <div class="pull pull-right"><a href="{{url('admin/subadmin/add')}}" class="btn btn-fill btn-rose">Add Sub Admin</a></div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Wallet Balance</th>
                          <th>Status</th>
                          <th class="text-right">Registered</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>

                      <tbody>
                        @if(count($users)>0)							
                        <?php $i = 1; ?>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td id="name_{{ $user->fname }} ">{{ $user->fname }}&nbsp;{{ $user->lname }}</td>      					
                            <td>{{ $user->email }}</td>									
                            <td>{{ $user->mobile }}</td>
                            @if($user->role)
                            <td>{{$user->role->name}}</td>
                            @else
                              <td></td>
                            @endif
                            <td>
                            @if($user->status == '1')
                                <span class="badge badge-pill badge-success">Active</span>
                            @else
                               <span class="badge badge-pill badge-danger">Inactive</span>
                            @endif
                            </td>
                            <td>{{ $user->created_at }}</td>	
                            <td class="td-actions text-right">
                             @if($user->status == '1')
                              <a href="{{url('admin/subadmin/updatestatus/'.$user->id.'/'.$user->status)}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/subadmin/updatestatus/'.$user->id.'/'.$user->status)}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/subadmin/editsubadmin/'.$user->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                            <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/subadmin/delete/'.$user->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                    {{ $users->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection