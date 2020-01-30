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

            <!--end flash messages--> 
               <?php
                      $airlinename = app('request')->input('airlinename');
                      $airlinecode = app('request')->input('airlinecode');
                      $status = app('request')->input('status');
                    ?>

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
                    <i class="material-icons">flight</i>
                  </div>
                  <h4 class="card-title">Airlines</h4>
                  <div class="pull pull-right"><a href="{{url('admin/airlines/create')}}" class="btn btn-fill btn-rose">Add New</a></div>
                </div>
                  <div class="adding filters">
                      <form method="get" class="form-horizontal" action="">
                        <div class="form-group row">
                          <select class="selectpicker airlinename col-sm-3" id="airlinename" data-style="select-with-transition"  name="airlinename" title="Select Airline Name" >
                            <option value="">None</option>
                            @if(count($allairlines)>0)              
                              @foreach($allairlines as $airline)
                              
                              @if($airlinename == $airline->name)
                                <option value="{{ $airline->name }}" selected="selected">{{ $airline->name }}</option>
                                @else
                                <option value="{{ $airline->name }}">{{ $airline->name }}</option>
                              @endif

                              @endforeach
                            @endif 
                          </select>
                       
                          <select class="selectpicker airlinecode col-sm-3" id="airlinecode" data-style="select-with-transition"  name="airlinecode" title="Select AirLine Code" >
                            <option value="">None</option>
                            @if(count($allairlines)>0)              
                              @foreach($allairlines as $airline)
                                @if($airlinecode == $airline->code)
                                 <option value="{{ $airline->code }}" selected="selected">{{ $airline->code }}</option>
                                  @else
                                 <option value="{{ $airline->code }}">{{ $airline->code }}</option>
                                @endif
                              
                              @endforeach
                            @endif 
                          </select>
                        
                          <select class="selectpicker status col-sm-3" id="status" data-style="select-with-transition"  name="status" title="Select Status" >
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
                          <th>Image</th>
                          <th>Name</th>
                          <th>Airline Code</th>
                          <th>Status</th>
                          <th >Created At</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($airlines)>0)              
                        <?php $i = 1; ?>
                        @foreach($airlines as $airline)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><img src="/public/images/airlines/{{$airline->code}}.gif" alt="{{ $airline->name }}" /></td>
                            <td id="name_{{ $airline->name }} ">{{ $airline->name }}</td>
                            <td>{{ $airline->code }}</td>
                            <td  >
                            @if($airline->status == '1')
                                <span class="badge badge-pill badge-success">Active</span>
                            @else
                               <span class="badge badge-pill badge-danger">Inactive</span>
                            @endif
                            </td>
                            <td>{{ $airline->created_at }}</td>
                            <td align="right" >
                            @if($airline->status == '1')
                              <a href="{{url('admin/airlines/update-status/'.$airline->id.'/0')}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/airlines/update-status/'.$airline->id.'/1')}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/airlines/update/'.$airline->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                           
                            <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{url('admin/airlines/delete/'.$airline->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                          
                          </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                    {{ $airlines->appends(['airlinename' => $airlinename, 'airlinecode' => $airlinecode, 'status' =>$status ])->links() }}
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection

