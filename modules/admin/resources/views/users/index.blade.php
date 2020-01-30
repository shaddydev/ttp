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
             <?php
                      $username = app('request')->input('usersnames');
                      $useremail = app('request')->input('useremail');
                      $usermobilenumber = app('request')->input('usermobilenumber');
                      $status = app('request')->input('status');
                      $filterdate = app('request')->input('filterdate');
                      $filterwallet = app('request')->input('filterwallet');
                    ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Users</h4>
                  <div class="pull pull-right"><a href="{{url('admin/users/add')}}" class="btn btn-fill btn-rose">Add Users</a></div>
                  </div>
                  <div class="adding filters">
                    <form method="get" class="form-horizontal" action="">
                      <div class="form-group row">
                        <select class="selectpicker usersname col-sm-2" id="usersnames" data-style="select-with-transition"  name="usersnames" title="Select UserName" >
                          <option value="">None</option>
                          @if(count($usersforfilter)>0)              
                            @foreach($usersforfilter as $userfilter)
                            
                            @if($username == $userfilter->fname)
                              <option value="{{ $userfilter->fname }}" selected="selected">{{ $userfilter->fname }}&nbsp;{{ $userfilter->lname }}</option>
                              @else
                              <option value="{{ $userfilter->fname }}">{{ $userfilter->fname }}&nbsp;{{ $userfilter->lname }}</option>
                            @endif

                            @endforeach
                          @endif 
                        </select>
                     
                        <select class="selectpicker useremail col-sm-2" id="useremail" data-style="select-with-transition"  name="useremail" title="Select UserEmail" >
                          <option value="">None</option>
                          @if(count($usersforfilter)>0)              
                            @foreach($usersforfilter as $userfilter)
                              @if($useremail == $userfilter->email)
                               <option value="{{ $userfilter->email }}" selected="selected">{{ $userfilter->email }}</option>
                                @else
                               <option value="{{ $userfilter->email }}">{{ $userfilter->email }}</option>
                              @endif
                            
                            @endforeach
                          @endif 
                        </select>
                      
                        <input type="text" name="usermobilenumber" placeholder="Enter Mobile Number" data-style="select-with-transition" class="form-control usermoblenumber col-sm-2" value="" />

                         <input type="text" name="filterwallet" placeholder="Enter Wallet Balance" data-style="select-with-transition" class="form-control userwalletbal col-sm-2" value="" />
                            
                        <input autocomplete="off" name="filterdate" class="form-control col-sm-2" id="filterdate" placeholder="Filter by Created  Date">


                        <select class="selectpicker status col-sm-2" id="status" data-style="select-with-transition"  name="status" title="Select Status" >
                          <option value="">None</option>
                          <option value="0">InActive</option>
                          <option value="1">Active</option>
                           
                        </select>
                        <input type="submit" class="btn btn-sm btn-primary " name="addfilter">
                          
                      </div>
                    </form>
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
                            @if($user->user_details)
                              <td>{{$user->user_details->cash}}</td>
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
                              <a href="{{url('admin/users/updatestatus/'.$user->id.'/'.$user->status)}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/users/updatestatus/'.$user->id.'/'.$user->status)}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/users/editusers/'.$user->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                            <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/users/deleteusers/'.$user->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                   <!--   {{ $users->links() }} -->
                    
                    {{ $users->appends(['usersnames' => $username, 'useremail' => $useremail, 'usermobilenumber'=> $usermobilenumber, 'status' =>$status, 'filterwallet' =>$filterwallet, 'filterdate' =>$filterdate ])->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection