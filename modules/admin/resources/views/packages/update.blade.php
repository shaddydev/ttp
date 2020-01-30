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
              <i class="material-icons">card_membership </i>
            </div>
            <h4 class="card-title">Update Package</h4>
            <div class="pull pull-right"><a href="{{url('admin/package-detail/create/'.$package->id)}}" class="btn btn-fill btn-rose">Add New Rule</a></div>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Package Title</label>
                           <div class="col-sm-8">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" value="{{$package->title}}" name="title" required placeholder="Title">
                             <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                          </div>
                           <div class="col-sm-2">
                            <input type="submit" class="text-white btn btn-primary" name="update" value="update" >
                          </div>
                        </div>
                        
                    </div>
                 </div>
            </form>
            <div class="mb-4" ></div>
            <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Service Type</th>
                          <th>Airline</th>
                          <th>Commission(%)</th>
                          <th >Status</th>
                          <th >Applied On</th>
                          <th >Created At</th>
                          <th >Actions</th>
                        </tr>
                      </thead>


                      <tbody>
                          @foreach($package->details as $key=>$detail)
                          <tr>
                            <td>{{ $key+1 }}</td>
                            <td >{{ App\PackageDetails::serviceName($detail->fix_service_id) }}</td>
                            @if($detail->airline!=='' && $detail->airline!==null )
                            <td >{{ App\PackageDetails::airline($detail->airline) }}</td>
                            @else
                            <td >-</td>
                            @endif
                            <td >{{ $detail->commission }}</td>
                            <td>
                            @if($detail->status == '1')
                                <span class="badge badge-pill badge-success">Active</span>
                            @else
                               <span class="badge badge-pill badge-danger">Inactive</span>
                            @endif
                            </td>

                            <td>
                            @if($detail->fare_type == '1')
                                <span class="badge  badge-secondary">Basic</span>
                            @else
                               <span class="badge  badge-dark">Basic+YQ</span>
                            @endif
                            </td>

                            <td>{{ $detail->created_at }}</td>
                            <td>

                            @if($detail->status == '1')
                              <a href="{{url('admin/package-detail/updatestatus/'.$detail->id.'/0')}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/package-detail/updatestatus/'.$detail->id.'/1')}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/package-detail/update/'.$detail->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                           
                            <a href="{{url('admin/package-detail/delete/'.$detail->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                          
                          </td>
                        </tr>
                        @endforeach
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

