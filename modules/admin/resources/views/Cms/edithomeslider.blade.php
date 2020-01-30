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
                          <label class="col-sm-2 col-form-label">Slider Image</label>
                            <div class="col-sm-10">
                              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                  <div class="fileinput-new thumbnail">
                                    @if(isset($homesliderinfo['0']['image']) || !empty($homesliderinfo['0']['image']))
                                    <img src="{{ url('/public/uploads/homeslider/'.$homesliderinfo['0']['image']) }}" alt="..." width="600" height="150px">
                                    @else
                                    <img src="{{ asset('public/admin/img/image_placeholder.jpg') }}" alt="..." width="600" height="150">
                                    @endif
                                    
                                  </div>
                                  <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                  <div>
                                    <span class="btn btn-rose btn-round btn-file">
                                      <span class="fileinput-new">Select image</span>
                                      <span class="fileinput-exists">Change</span>
                                      <input type="file" name="sliderimage" id="img2" />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                  </div>
                              </div>
                            </div>

                        </div>
                    </div>
                    <!--last name-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Slider Url</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="url" placeholder="Enter url" value="{{ ($homesliderinfo['0']['url']) }}">
                           <span class="text-danger">{{ $errors->first('url') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              
    
                
                

                <input type="submit" name="edithomeslider">
              </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

