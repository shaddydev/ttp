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
                    <i class="material-icons">card_membership</i>
                  </div>
                  <h4 class="card-title">Packages</h4>
                  <div class="pull pull-right"><a href="{{url('admin/packages/create')}}" class="btn btn-fill btn-rose">Add New</a></div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th >Created At</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>


                      <tbody>
                        @if(count($packages)>0)              
                        <?php $i = 1; ?>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td id="name_{{ $package->title }} ">{{ $package->title }}</td>
                            <td  >
                            @if($package->status == '1')
                                <span class="badge badge-pill badge-success">Active</span>
                            @else
                               <span class="badge badge-pill badge-danger">Inactive</span>
                            @endif
                            </td>
                            
                            <td>{{ $package->created_at }}</td>
                            <td align="right" >
                            @if($package->status == '1')
                              <a href="{{url('admin/packages/updatestatus/'.$package->id.'/0')}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/packages/updatestatus/'.$package->id.'/1')}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/packages/update/'.$package->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                           
                            <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/packages/delete/'.$package->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                          
                          </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                    {{ $packages->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection