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
                  <h4 class="card-title">Service Charge Managemnt</h4>
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
                               <label class="col-sm-6 col-form-label">Service Charge (Flat)</label>
                               <div class="col-md-6" >
                                    <input type="text" class="form-control" value="{{$service->service_charge}}" placeholder="Service charge" name="charges[{{$service->id}}][]" >
                               </div>
                            </div>
                        </div>
                    </div>
                  @endforeach
                  <input class="btn btn-primary" type="submit" name="servicecharge">
                 <div class="mb-4"></div>
                </div>
               </form>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection