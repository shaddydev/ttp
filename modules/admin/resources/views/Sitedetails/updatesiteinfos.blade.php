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
                  <div class="card ">
                    <div class="card-header card-header-rose card-header-text">
                      <div class="card-text">
                        <h4 class="card-title">Site Logo</h4>
                      </div>
                    </div>
                    <div class="card-body ">
                      <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                         {!! csrf_field() !!}
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Site Logo</label>
                          <div class="col-sm-8">
                            <div class="form-group">
                              
                              <!--image-->
                              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                   @if(isset($siteinfos['0']['value']) || !empty($siteinfos['0']['value']))
                                    <img src="{{ url('/public/uploads/siteinfo/'.$siteinfos['0']['value']) }}" alt="..." width="600" height="150px">
                                    @else
                                    <img src="{{ asset('public/admin/img/image_placeholder.jpg') }}" alt="..." width="600" height="150">
                                    @endif
                                    
                                
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div class=" {{ $errors->has('sliderimage') ? 'has-error' : '' }}">
                                  <span class="btn btn-rose btn-round btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="sitelogo" id="img2" />
                                  </span>
                                  <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                  <span class="text-danger">{{ $errors->first('sliderimage') }}</span>
                                </div>
                              </div>
                              <!--end imaga-->
                            </div>
                          </div>
                        </div>
                          <div class="col-md-2">
                            <input type="submit" name="submitsitelogo" value="Update Site logom">
                          </div>
                       
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                      <div class="card-icon">
                        <i class="material-icons">mail_outline</i>
                      </div>
                      <h4 class="card-title">Site Basic Info</h4>
                    </div>
                    <div class="card-body ">
                   
                      <div class=" form-group">
                          <form method="post" action="" class="row form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                           <label class="col-md-3 col-form-label">Site Email</label>
                           <div class="col-md-6">
                            <div class="form-group {{ $errors->has('siteemail') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="siteemail" placeholder="Enter Site Email" value="{{ ($siteinfos['5']['value']) }}">
                               <span class="text-danger">{{ $errors->first('siteemail') }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button type="submit" name="updatesiteemail" value="Update site Basic Info"><i class="fa fa-lock"></i></button>
                         </div>
                        </form>
                      </div>

                      <div class=" form-group">
                          <form method="post" action="" class="row form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                          <label class="col-md-3 col-form-label">Site Query Number</label>
                          <div class="col-md-6">
                            <div class="form-group {{ $errors->has('sitequerynumber') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="sitequerynumber" placeholder="Enter Site Query Number" value="{{ ($siteinfos['1']['value']) }}">
                               <span class="text-danger">{{ $errors->first('sitequerynumber') }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button type="submit" name="updatesitequerynumber" value="Update site Basic Info"><i class="fa fa-lock"></i></button>
                         </div>
                        </form>
                      </div>

                      <div class=" form-group">
                          <form method="post" action="" class="row form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                           <label class="col-md-3 col-form-label">Site Mobile Number</label>
                          <div class="col-md-6">
                            <div class="form-group {{ $errors->has('sitemobilenumber') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="sitemobilenumber" placeholder="Enter Site Mobile Number" value="{{ ($siteinfos['2']['value']) }}">
                               <span class="text-danger">{{ $errors->first('sitemobilenumber') }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button type="submit" name="updatesitemobilenumber" value="Update site Basic Info"><i class="fa fa-lock"></i></button>
                         </div>
                        </form>
                      </div>
                      <div class=" form-group">
                          <form method="post" action="" class="row form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                           <label class="col-md-3 col-form-label">Site Address</label>
                          <div class="col-md-6">
                            <div id="locationField" class="form-group {{ $errors->has('siteaddress') ? 'has-error' : '' }}">
                             <!--  <input type="text" class="form-control" name="siteaddress" placeholder="Enter Site Address" value="{{ ($siteinfos['4']['value']) }}"> -->
                                <input id="autocomplete" class="form-control"  name="siteaddress"
                                         placeholder="Enter site address"
                                         onFocus="geolocate()"
                                         type="text" value="{{ ($siteinfos['4']['value']) }}"/>
                                
                               <span class="text-danger">{{ $errors->first('siteaddress') }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button type="submit" name="updatesiteaddress" value="Update site Basic Info"><i class="fa fa-lock"></i></button>
                         </div>
                        </form>
                      </div>

                      <div class=" form-group">
                          <form method="post" action="" class="row form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                          <label class="col-md-3 col-form-label">Site Footer Text</label>
                          <div class="col-md-6">
                            <div class="form-group {{ $errors->has('sitefootertext') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="sitefootertext" placeholder="Enter Site Footer Text" value="{{ ($siteinfos['3']['value']) }}">
                               <span class="text-danger">{{ $errors->first('sitefootertext') }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                           <button type="submit" name="updatesitefootertext" value="Update site Basic Info"><i class="fa fa-lock"></i></button>
                         </div>
                        </form>
                      </div>
                        
                      
                    </div>
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                      <div class="card-icon">
                        <i class="material-icons">contacts</i>
                      </div>
                      <h4 class="card-title">Site Social Media Links</h4>
                    </div>
                    <div class="card-body ">
                      <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                         {!! csrf_field() !!}
                        <div class="row">
                          <label class="col-md-3 col-form-label">Facebook Link</label>
                          <div class="col-md-9">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                              <input type="url" class="form-control" name="facebooklink" placeholder="Enter Facebook Link" value="{{ ($siteinfos['6']['value']) }}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label">Twitter Link</label>
                          <div class="col-md-9">
                            <div class="form-group">
                              <input type="url" class="form-control" name="twitterlink" placeholder="Enter Twitter Link" value="{{ ($siteinfos['7']['value']) }}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label">Instagram Link</label>
                          <div class="col-md-9">
                            <div class="form-group">
                              <input type="url" class="form-control" name="instagramlink" placeholder="Enter Instagram Link" value="{{ ($siteinfos['8']['value']) }}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-3 col-form-label">Pinterest Link</label>
                          <div class="col-md-9">
                            <div class="form-group">
                              <input type="url" class="form-control" name="pinterestlink" placeholder="Enter Pinterest Link" value="{{ ($siteinfos['9']['value']) }}">
                            </div>
                          </div>
                        </div>
                        <div class="form-check">
                          <input type="submit" name="updatesocialmedialinks" value="Update Social Media Links">
                        </div>
                      </form>
                    </div>
                  
                  </div>
                </div>
         

          </div>
  </div>
</div>

@endsection

