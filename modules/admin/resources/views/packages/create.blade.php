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
            <h4 class="card-title">Add New Package</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Package Title</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="title" required placeholder="Title">
                             <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                
                 </div>
              <input class="btn btn-primary" type="submit" name="create">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

