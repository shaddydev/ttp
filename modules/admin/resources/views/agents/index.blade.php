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
                      $agentcode = app('request')->input('agentcode');
                      $agentname = app('request')->input('agentname');
                      $usermobilenumber = app('request')->input('usermobilenumber');
                      $status = app('request')->input('status');
                      $filterdate = app('request')->input('filterdate');
                    ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Agent/distributor</h4>
                  <div class="pull pull-right"><a href="{{url('admin/agents/add')}}" class="btn btn-fill btn-rose">Add New</a></div>
                  </div>
                  <div class="adding filters">
                    <form method="get" class="form-horizontal" action="">
                      <div class="form-group col-sm-12 row">

                        <input type="text" name="agentcode" placeholder="Code" data-style="select-with-transition" class="form-control agentcode col-sm-2" value="{{$agentcode}}" />
                     
                        <input type="text" name="agentname" placeholder="Agency Name" data-style="select-with-transition" class="form-control agentname col-sm-2" value="{{$agentname}}" />
                      
                        <input type="text" name="usermobilenumber" placeholder="Enter Mobile Number" data-style="select-with-transition" class="form-control usermoblenumber col-sm-2" value="{{$usermobilenumber}}" />
                            
                        <input autocomplete="off" name="filterdate" class="form-control col-sm-2" id="filterdate" placeholder="Filter by Created Date" value="{{$filterdate}}" >

                        <select class="selectpicker status col-sm-2" id="status" data-style="select-with-transition"  name="status" title="Select Status" value="{{$status}}" >
                          <option value="">None</option>
                          <option value="0">InActive</option>
                          <option value="1">Active</option>
                        </select>

                         <input type="submit" class="btn btn-sm btn-primary" name="addfilter">
                      </div>
                    </form>
                  </div>
                 
                
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Code</th>
                          <th>Agency</th>
                          <th>Mobile</th>
                          <th>Status</th>
                          <th>Wallet(credit)</th>
                          <th>Wallet(cash)</th>
                          <th>Pending Amount</th>
                          <th>Agent/Distributor</th>
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
                            <td id="name_{{ $user->fname }} "><a href = "{{url('admin/agent/transactions/'.$user->id)}}" target  = "_blank">{{ $user->user_details->unique_code }}</a></td>                 
                            <td>{{ $user->user_details->agentname }}</td>                 
                            <td>{{ $user->mobile }}</td>  
                            <td>
                            @if($user->status == '1')
                              <span class="badge badge-pill badge-success">Active</span>
                            @else
                              <span class="badge badge-pill badge-danger">Inactive</span>
                            @endif
                            </td>
                            @if($user->user_details)
                              <td>{{$user->user_details->credit}}</td>
                            @else
                              <td></td>
                            @endif
                            @if($user->user_details)
                              <td>{{$user->user_details->cash}}</td>
                            @else
                              <td></td>
                            @endif
                            
                            <td>
                              {{$user->user_details->pending}}
                              {{ $user->user_details->advance != 0 ? ('advance:'.$user->user_details->advance ) : ''}}
                            </td>
                           
                            <td>
                            @if($user->role->name == 'agent')
                                <span class="badge badge-pill badge-info">Agent</span>
                            @elseif($user->role->name == 'distributor')
                               <span class="badge badge-pill badge-warning">Distributor</span>
                            @endif
                            </td>
                            <td>{{ $user->created_at }}</td>
                            <td class="td-actions text-right">
                            
                            @if($user->role->name == 'agent')
                              <a href="{{url('admin/agents/package-detail/'.$user->id)}}" class="btn btn-warning btn-link">
                              <i class="material-icons">card_membership</i></a>
                            @endif
                            
                            @if($user->role->name == 'distributor')
                              <a  rel="tooltip" href="{{url('admin/agents/distributor-agents/'.$user->id)}}" class="btn btn-info btn-link" data-original-title="" title="">
                                <i class="material-icons">person</i>
                              </a>
                            @endif
                            @if($user->status == '1')
                              <a href="{{url('admin/agents/updatestatus/'.$user->id.'/'.$user->status)}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/agents/updatestatus/'.$user->id.'/'.$user->status)}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/agents/editagent/'.$user->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                           
                            <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/agents/deleteagents/'.$user->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                            <!-- Modal Trigger -->
                            <a href =  "javaScript:void(0)"  class="btn btn-info btnvalue" data-toggle="modal" data-target="#myModal" data-user = "{{$user->id}}">Update Payment</a>

                          </td>
                        </tr>
                       
                        @endforeach
                        @endif
                        
                    </tbody>
                    </table>
                    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Modify Wallet</h4>
        </div>
        <div class="modal-body">
        <form method  = "post" action  = "{{url('admin/transfermoney')}}">
          {{csrf_field()}}
            <div class = "row">
              <div class = "col-md-12"> 
               
                <label class = ""> Wallet </label>
                  <select class = "form-control" name = "account_type">
                    <option value = "credit">Credit</option>
                    <option value = "cash">cash</option>
                  <select>
              </div>
              <div class = "col-md-12">
                <label>Amount</label>
                <input type = "hidden" name = "usersid">
                <input type = "text" name = "amount" class = "form-control" placeholder = "enter Amount" required>
                </div>
                <div class = "col-md-12">
                  <textarea name = "note" class = "form-control" placeholder = "Enter Remark Note"></textarea>
                </div>
              <div class = "col-md-12">
                <input type = "submit" name = "submit" value  = "Subtract" class = "btn btn-danger pull-right">
                <input type = "submit" name = "submit" value  = "Add" class = "btn btn-primary pull-right">
              
              </div>
              </div>
                                
        </form>
        </div>
        <div class="modal-footer">
         
        </div>
      </div>
      
    </div>
  </div>
                     {{ $users->appends(['agentcode' => $agentcode, 'agentname' => $agentname,'status' =>$status,'filterdate' =>$filterdate ])->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


@endsection
