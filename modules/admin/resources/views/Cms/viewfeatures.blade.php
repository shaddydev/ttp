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
            @if ($message = Session::get('warning'))
                <div class="alert alert-warning">
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
                    <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Features</h4>
                  <div class="pull pull-right"><a href="{{url('admin/featuress/addfeatures')}}" class="btn btn-fill btn-rose">Add features</a></div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Logo</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>


                      <tbody>
                         @if(count($features)>0)              
                        <?php $i = 1; ?>
                        @foreach($features as $feature)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><img width="120" height="80" src="{{ url('/public/uploads/features/'.$feature['logo']) }}"></td>               
                            <td>{{ $feature['title'] }}</td>                 
                            <td>{{ $feature['description'] }}</td> 
                            <td class="td-actions text-right">
                            <button type="button" rel="tooltip" class="btn btn-info btn-link" data-original-title="" title="">
                              <i class="material-icons">person</i>
                            </button>
                           
                            <a href="{{url('admin/featuress/editfeatures/'.$feature['id'])}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                           <!--  <button type="button" rel="tooltip" class="" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                            </button> -->
                            <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/features/deletefeature/'.$feature['id'])}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                           <!--  <button type="button" rel="tooltip" class="btn btn-danger btn-link" data-original-title="" title="">
                              <i class="material-icons">close</i>
                            </button> -->
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