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
            @if ($error = Session::get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                  <strong>{{ $error }}</strong>
          </div>
          @endif
            <!--end flash messages-->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">card_membership </i>
            </div>
            <h4 class="card-title">Update Package Rule for <b>{{$package->package->title}}</b></h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label">Service Type</label>
                          <div class="col-sm-9">
                            <div class="form-group {{ $errors->has('fix_service_id') ? 'has-error' : '' }}">
                            <select  required class="selectpicker col-sm-12" data-style="select-with-transition" name="fix_service_id" id="fix_service_id" title="Select Service">
                                @if(count($fix_services)>0)              
                                @foreach($fix_services as $key=>$value)
                                  @if($package->fix_service_id==$key)
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                  @else 
                                    <option value="{{ $key }}">{{ $value }}</option>
                                  @endif
                                @endforeach
                                @endif
                              </select>
                              <span class="text-danger">{{ $errors->first('fix_service_id') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                 </div>

                <div class="row">
                   <div class="col-sm-6">
                        <div class="row" >
                          <label class="col-sm-3 col-form-label">Airline</label>
                          <div class="col-sm-9">
                            <div class="form-group {{ $errors->has('airline') ? 'has-error' : '' }}">
                                @if($package->fix_service_id!==1)
                                    <select disabled required class="selectpicker col-sm-12" id="airline" data-style="select-with-transition" name="airline" title="Select Airline">
                                @else 
                                    <select required class="selectpicker col-sm-12" id="airline" data-style="select-with-transition" name="airline" title="Select Airline">
                                @endif
                                @if(count($airlines)>0)              
                                @foreach($airlines as $key=>$value)
                                  @if($package->airline==$key)
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                  @else 
                                    <option value="{{ $key }}">{{ $value }}</option>
                                  @endif
                                @endforeach
                                @endif
                              </select>
                              <span class="text-danger">{{ $errors->first('airline') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

                 <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label">Commission in (%)</label>
                          <div class="col-sm-9">
                            <div class="form-group {{ $errors->has('commission') ? 'has-error' : '' }}">
                              <input type="text" value="{{$package->commission}}" required class="form-control" name="commission" placeholder="Enter Commission">
                              <span class="text-danger">{{ $errors->first('commission') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                
                 </div>

                 <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label">Commission On Price</label>
                          <div class="col-sm-9">
                            <div class="form-group {{ $errors->has('fare_type') ? 'has-error' : '' }}">
                                <select required class="selectpicker col-sm-12" data-style="select-with-transition" name="fare_type" title="Select fare type">
                                  @if($package->fare_type=='1')
                                    <option selected value="1">Basic</option>
                                    <option value="2">Basic+YQ</option>
                                  @else 
                                    <option value="1">Basic</option>
                                    <option selected value="2">Basic+YQ</option>
                                  @endif
                                </select>
                              <span class="text-danger">{{ $errors->first('fare_type') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                
                 </div>

              <input class="btn btn-primary" type="submit" name="update">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

