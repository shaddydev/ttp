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
            <h4 class="card-title">Update profile</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
             
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">First Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="fname" placeholder="Enter your first name" value="{{($admin->fname)}}" >
                             <span class="text-danger">{{ $errors->first('fname') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                    <!--last name-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('lname') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="lname" placeholder="Enter your last name" value="{{($admin->lname)}}" >
                           <span class="text-danger">{{ $errors->first('lname') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              
              <div class="row">
                  <!-- emailid-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Email Address</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <input type="text" class="form-control" name="email" placeholder="Enter your email" value="{{($admin->email)}}" >
                           <span class="text-danger">{{ $errors->first('email') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Agent Name-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Profile Image</label>
                            <div class="col-sm-10">
                                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                      @if($admin->profile_pic==null)
                                       <img src="{{ asset('public/admin/img/default-avatar.png') }}" alt="..." width="200px" height="250px">
                                      @else
                                       <img src="{{ asset('public/uploads/users/profile')}}/{{$admin->profile_pic}}" alt="..." width="200px" height="250px">
                                      @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                      <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="profilePic" id="img1" />
                                      </span>
                                      <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div class="row" >
                 <div class="col-sm-6">
                    <input class="btn btn-primary" type="submit" name="addagent">
                 </div>
                <div class="col-sm-6">
                 
                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myPassword">Update Password</button>
                    <!-- Modal -->
                      <div class="modal fade" id="myPassword" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Update Password</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>New Password</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" name="newpassword" >
                                        </div>
                                  </div>

                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>Confirm New Password</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" name="confpass">
                                        </div>
                                  </div>
                                  <input type="hidden" name="agentid" value="{{($admin->id) }}">
                                  <button type="button" class="updatepassword btn btn-primary btn-block" name="updatepassword" value="Update Password">Update Password</button><div class="agentpasswordupdatediv">
                                </div>
                              </form>
                              </div>
                              <div class="modal-footer">
                            </div>
                           </div>
                          </div>
                         </div>
                       </div>
                      </div>
               </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

