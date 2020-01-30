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
              <i class="material-icons">account_box </i>
            </div>
            <h4 class="card-title">Add Sub Admin</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="{{url('admin/submit-subadmin-detail')}}">
              {!! csrf_field() !!}
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">First Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="fname" required placeholder="Enter your first name">
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
                            <input type="text" class="form-control" name="lname" required placeholder="Enter your last name">
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
                            <input type="text" class="form-control" name="email" required placeholder="Enter your email">
                           <span class="text-danger">{{ $errors->first('email') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--countrycodeand mobilenumber-->
                    <div class="col-sm-6">
                        <div class="row">
                         <label class="col-sm-2 col-form-label">Mobile</label>
                          <div class="col-sm-4">
                            <div class="form-group {{ $errors->has('countrycode') ? 'has-error' : '' }}">
                               <select  required class="selectpicker col-sm-12" data-style="select-with-transition" name="countrycode" title="Select CountryCode">
                                @if(count($mobile_countrycode)>0)              
                                @foreach($mobile_countrycode as $mobcode)
                                  <option value="{{ $mobcode->Countrycode }}">{{ $mobcode->Countrycode }}</option>
                                @endforeach
                                @endif
                              </select>
                              <span class="text-danger">{{ $errors->first('countrycode') }}</span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                              <input type="text" required class="form-control" name="mobile" placeholder="Enter Mobile Number">
                              <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <!-- Password-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Password</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                              <input required type="password" class="form-control" name="password" placeholder="Enter your Password">
                              <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
                  <!-- Confirm Password-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Confirm Password</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('confpass') ? 'has-error' : '' }}">
                              <input required type="password" class="form-control" name="confpass" placeholder="Enter your confirm Password">
                              <span class="text-danger">{{ $errors->first('confpass') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <!-- Password-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Role</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                              <select class = "form-control" name = "role_id">
                                <option value = "">Choose Role</option>
                                @forelse($roles as $role)
                                <option value = "{{$role->id}}">{{$role->name}}</option>
                                @empty
                                @endforelse
                              </select>
                              <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
               
                 
                </div>
                <input type="submit" class="btn btn-primary pull-right" name="adduser">
              </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

