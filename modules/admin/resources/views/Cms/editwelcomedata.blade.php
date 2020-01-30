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
            <h4 class="card-title">Update Welcome</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="{{ url('admin/welcomedata') }}" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Welcome Title</label>
                            <div class="col-sm-10">
                               <div class="form-group {{ $errors->has('weltitle') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" name="weltitle" placeholder="Enter Welcome Title" value="{{ ($welcomeinfo['0']['welcome_title']) }}">
                               <span class="text-danger">{{ $errors->first('weltitle') }}</span>
                              </div>
                            </div>

                        </div>
                    </div>
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Welcome Message</label>
                            <div class="col-sm-10">
                               <div class="form-group {{ $errors->has('welmsg') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" name="welmsg" placeholder="Enter Welcome Message" value="{{ ($welcomeinfo['0']['welcome_message']) }}">
                               <span class="text-danger">{{ $errors->first('welmsg') }}</span>
                              </div>
                            </div>

                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <!--last name-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Welcome Description</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('weldesc') ? 'has-error' : '' }}">
                            <textarea name="weldesc" class="form-control">{{ ($welcomeinfo['0']['welcome_description'])}}</textarea>
                           <span class="text-danger">{{ $errors->first('weldesc') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Welcome Short Description</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('welshortdesc') ? 'has-error' : '' }}">
                            <textarea name="welshortdesc" class="form-control">{{ ($welcomeinfo['0']['welcome_short_description'])}}</textarea>
                           <span class="text-danger">{{ $errors->first('welshortdesc') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              
     
                

                <input type="submit" name="editwelcomedata">
              </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

