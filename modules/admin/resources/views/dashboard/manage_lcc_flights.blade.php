@extends('admin::layouts.admin')
@section('admin::content')

<div class="content">
        <div class="container-fluid">
          <!--flash message-->
          <div class="response" ></div>
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
                     // $status = app('request')->input('status');
                    ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">flight</i>
                  </div>
                  <h4 class="card-title">Manage LCC</h4>
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
                      
                       <!--  <select class="selectpicker status col-sm-3" id="status" data-style="select-with-transition"  name="status" title="Select Status" >
                          <option value="">None</option>
                          <option value="0">InActive</option>
                          <option value="1">Active</option>
                           
                        </select> -->
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
                          <th class="text-right">Is LCC</th>
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
                            <td align="right" >

                             <div class="togglebutton">
                                    <label>
                                    @if($airline->has_lcc==1)
                                        <input class="lcc-toggle" table="airlines" data-id="{{$airline->id}}" value="{{$airline->id}}" name="api-trigger" type="checkbox" checked="1">
                                    @else
                                        <input class="lcc-toggle" table="airlines" data-id="{{$airline->id}}" value="{{$airline->id}}"  name="api-trigger" type="checkbox">
                                    @endif
                                    <span class="toggle"></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                    {{ $airlines->appends(['airlinename' => $airlinename, 'airlinecode' => $airlinecode])->links() }}

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection



