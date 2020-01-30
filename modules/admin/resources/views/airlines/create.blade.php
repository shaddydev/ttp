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
              <i class="material-icons">flight</i>
            </div>
            <h4 class="card-title">Add New Airline</h4>
            <div class="pull pull-right"><a href="{{url('admin/airlines')}}" class="btn btn-fill btn-rose">Go Back</a></div>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-5">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Airline Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" value="{{old('name')}}" name="name" required placeholder="Name">
                             <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Airline Code</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" value="{{old('code')}}" name="code" required placeholder="Code">
                             <span class="text-danger">{{ $errors->first('code') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Logo</label>
                                <div class="col-sm-9">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                        <img src="{{ asset('public/admin/img/image_placeholder.jpg') }}" alt="..." width="50px" height="50px">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                        <span class="btn btn-rose btn-round btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="logo" id="img1" />
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                                        <i class="fa fa-times"></i> Remove</a>
                                        </div>
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

