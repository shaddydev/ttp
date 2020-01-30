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
            <h4 class="card-title">Add Textual Page</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Page Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('pagename') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="pagename" placeholder="Enter page name">
                             <span class="text-danger">{{ $errors->first('pagename') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                    <!--last name-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Page Title</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('pagetitle') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="pagetitle" placeholder="Enter page title">
                           <span class="text-danger">{{ $errors->first('pagetitle') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              
              <div class="row">
                  <!-- emailid-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Page Description</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('pagedescription') ? 'has-error' : '' }}">
                            <textarea  class="form-control" name="pagedescription" placeholder="Enter page description"></textarea>
                           <span class="text-danger">{{ $errors->first('pagedescription') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--countrycodeand mobilenumber-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Page Image</label>
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
                                      <input type="file" name="pageimage" id="img2" />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    <span class="text-danger">{{ $errors->first('pageimage') }}</span>
                                  </div>
                              </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Seo Title</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('seotitle') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="seotitle" placeholder="Enter seo title">
                             <span class="text-danger">{{ $errors->first('seotitle') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                    <!--last name-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Seo Keyword</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('seokeyword') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="seokeyword" placeholder="Enter seo keyword">
                           <span class="text-danger">{{ $errors->first('seokeyword') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              
              <div class="row">
                  <!-- emailid-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Seo Description</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('seodescription') ? 'has-error' : '' }}">
                            <textarea class="form-control" name="seodescription" placeholder="Enter seo description"></textarea>
                           <span class="text-danger">{{ $errors->first('seodescription') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- slug-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Slug</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter slug">
                          
                           <input type="hidden" name="slugvalue" id="slugvalue">
                            <span class="text-danger">{{ $errors->first('slugvalue') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>

                <input type="submit" class="btn btn-primary" name="addtextualpage">
              </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

