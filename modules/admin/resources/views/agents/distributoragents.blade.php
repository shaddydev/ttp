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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Agents Assosiated with distributor : <b>{{$userDetal['unique_code']}}</b></h4>
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
                          <th>Status</th>
                          <th>Agent/distributor</th>
                          <th class="text-right">Registered</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>


                      <tbody>
                        @if(count($user->children)>0)              
                        <?php $i = 1; ?>
                        @foreach($user->children as $child)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td id="name_{{ $child->fname }} ">{{ $child->fname }}&nbsp;{{ $child->lname }}</td>                 
                            <td>{{ $child->email }}</td>                 
                            <td>{{ $child->mobile }}</td>  
                            <td>
                            @if($child->status == '1')
                                <span class="badge badge-pill badge-success">Active</span>
                            @else
                               <span class="badge badge-pill badge-danger">Inactive</span>
                            @endif
                            </td>
                            <td>
                            @if($child->role->name == 'agent')
                                <span class="badge badge-pill badge-info">Agent</span>
                            @elseif($child->role->name == 'distributor')
                               <span class="badge badge-pill badge-warning">distributor</span>
                            @endif
                            </td>
                            <td>{{ $child->created_at }}</td>
                            <td class="td-actions text-right">
                            @if($child->role->name == 'distributor')
                              <a  rel="tooltip" href="{{url('admin/agents/distributor-agents/'.$child->id)}}" class="btn btn-info btn-link" data-original-title="" title="">
                                <i class="material-icons">person</i>
                              </a>
                            @endif
                            <a href="{{url('admin/agents/editagent/'.$child->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                            <a href="{{url('admin/agents/deletedistributoragent/'.$user->id.'/'.$child->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection