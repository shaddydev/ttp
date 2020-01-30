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
            <?php //echo '<pre>';print_r($userdata); exit;?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">account_box </i>
            </div>
            <h4 class="card-title">Update User - <b>{{$userdata->fname}} {{$userdata->lname}}</b></h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="{{url('admin/submit-subadmin-detail/'.$userdata['id'])}}">
              {!! csrf_field() !!}
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">First Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                              <input type="text" required class="form-control" name="fname" value="{{$userdata['fname']}}" placeholder="Enter your first name">
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
                            <input type="text" required class="form-control" value="{{$userdata['lname']}}" name="lname" placeholder="Enter your last name">
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
                            <input type="text" required class="form-control" value="{{$userdata['email']}}" name="email" placeholder="Enter your email">
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
                               <select required  class="selectpicker col-sm-12" data-style="select-with-transition" name="countrycode" title="Select CountryCode">
                                @if(count($mobile_countrycode)>0)              
                                @foreach($mobile_countrycode as $mobcode)
                                  @if($mobcode->Countrycode == $userdata['countrycode'])
                                     <option selected value="{{ $mobcode->Countrycode }}">{{ $mobcode->Countrycode }}</option>
                                  @else
                                     <option value="{{ $mobcode->Countrycode }}">{{ $mobcode->Countrycode }}</option>
                                  @endif
                                @endforeach
                                @endif
                              </select>
                              <span class="text-danger">{{ $errors->first('countrycode') }}</span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                              <input required type="text" class="form-control" value="{{$userdata['mobile']}}" name="mobile" placeholder="Enter Mobile Number">
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
                              <input  type="password" class="form-control" name="password" placeholder="Enter your Password" value = "">
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
                              <input  type="password" class="form-control" name="confpass" placeholder="Enter your confirm Password" value = "">
                              <span class="text-danger">{{ $errors->first('confpass') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                    <input type="submit" class="btn btn-primary" name="edituser">
                </div>
                
                      
                        
                  </form>
               </div>
           </div>
         </div>
    </div>
  </div>
</div>

@endsection

