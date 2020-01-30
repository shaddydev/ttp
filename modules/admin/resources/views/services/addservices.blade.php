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
            <!--end flash messages-->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">account_box </i>
            </div>
            <h4 class="card-title">Add Service</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                  <div class="fileinput-new thumbnail">
                                    <img src="{{ asset('public/admin/img/image_placeholder.jpg') }}" alt="..." width="200px" height="200px">
                                  </div>
                                  <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                  <div class=" {{ $errors->has('Serviceimage') ? 'has-error' : '' }}">
                                    <span class="btn btn-rose btn-round btn-file">
                                      <span class="fileinput-new">Select image</span>
                                      <span class="fileinput-exists">Change</span>
                                      <input type="file" name="Serviceimage" id="img2" />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    <span class="text-danger">{{ $errors->first('Serviceimage') }}</span>
                                  </div>
                              </div>
                            </div>

                        </div>
                    </div>
                    <!--last name-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="title" placeholder="Enter your title">
                           <span class="text-danger">{{ $errors->first('title') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              
              <div class="row">
                  <!-- emailid-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('desc') ? 'has-error' : '' }}">
                            <textarea class="form-control" name="desc" placeholder="Enter your description"> </textarea>
                           <span class="text-danger">{{ $errors->first('desc') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--countrycodeand mobilenumber-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Short Description</label>
                            <div class="col-sm-10">
                              <div class="form-group {{ $errors->has('shortdesc') ? 'has-error' : '' }}">
                                <textarea class="form-control" name="shortdesc" placeholder="Enter your short description"></textarea>
                                <span class="text-danger">{{ $errors->first('shortdesc') }}</span>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                

                <input type="submit" name="addservice">
              </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

