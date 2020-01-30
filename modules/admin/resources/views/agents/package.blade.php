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
                    <i class="material-icons">card_membership</i>
                  </div>
                  <h4 class="card-title">User Package Detail <b> : {{$user->user_details->unique_code}}</b></h4>
                  <div class="pull pull-right"><a href="{{url('admin/agents')}}" class="btn btn-fill btn-rose">Go back</a></div>
                </div>
                <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                 {!! csrf_field() !!}
                <div class="card-body row packages-agents">
                  @foreach($fix_services as $service)
                    <div class="card col-md-4" >
                        <i class="fa fa-{{$service->fa_class}}" style="font-size:88px;text-align:center;padding:20px 10px;" ></i>
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$service->display_title}}</h5>
                             <div class="row" >
                              <div class="col-md-12" >
                               <select class="selectpicker package-list col-md-12" id="packagelist_{{$service->id}}" data-style="btn btn-warning btn-round"  name="package[{{$service->id}}][]" title="Select Package" >
                               <option value="">Please select</option>
                                @if(count($packages)>0)              
                                  @foreach($packages as $key=>$package)
                                      @if(App\UserPackage::getUserServicePackage($user->id,$service->id)===$key)
                                       <option selected value="{{ $key }}">{{$package}}</option>
                                      @else
                                       <option value="{{ $key }}">{{$package}}</option>
                                      @endif
                                  @endforeach
                                @endif
                              </select>
                              </div>
                            </div>
                        </div>
                    </div>
                  @endforeach
                  <input class="btn btn-primary" type="submit" name="updateagentpackage">
                 <div class="mb-4"></div>
                </div>
               </form>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection