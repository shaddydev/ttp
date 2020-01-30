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
            <h4 class="card-title">Add User</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="">
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
                              <input type="text" required class="form-control" name="phone" placeholder="Enter Mobile Number">
                              <span class="text-danger">{{ $errors->first('phone') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                   <!-- Country-->
                    <div class="col-sm-6">
                      <div class="row">
                       <label class="col-sm-2 col-form-label">Country</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                          
                            <select class="selectpicker countrylist col-sm-12" id="countrylist" required data-style="select-with-transition"  name="country" title="Select Country" >
                              @if(count($countrylist)>0)              
                              @foreach($countrylist as $key=>$country)
                                <option value="{{ $key }}">{{$country}}</option>
                              @endforeach
                              @endif
                            </select>
                            <span class="text-danger">{{ $errors->first('country') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- State-->
                  <div class="col-sm-6">
                    <div class="row">
                    <label class="col-sm-2 col-form-label">State</label>
                      <div class="col-sm-10">
                        <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                          <select required class="selectpicker statelist col-sm-12" data-style="select-with-transition" name="state" id="statelist" title="Select State" >
                             <option value="0">Select state</option>
                          </select>
                          <span class="text-danger">{{ $errors->first('state') }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                <!-- City-->
                  <div class="col-sm-6">
                    <div class="row">
                     <label class="col-sm-2 col-form-label">City</label>
                      <div class="col-sm-10">
                        <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                          <select required class="selectpicker citylist col-sm-12" data-style="select-with-transition" name="city" id="citylist" title="Select City" >
                              <option value="0">Please select</option>
                          </select>
                          <span class="text-danger">{{ $errors->first('city') }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- Full Address-->
                  <div class="col-sm-6">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Full Address</label>
                        <div class="col-sm-10">
                          <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <input required type="text" class="form-control" name="address" placeholder="Enter your full address">
                            <span class="text-danger">{{ $errors->first('address') }}</span>
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
                    <!-- Pin Code-->
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Pin Code</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('pincode') ? 'has-error' : '' }}">
                              <input required type="text" class="form-control" name="pincode" placeholder="Enter your pin code">
                              <span class="text-danger">{{ $errors->first('pincode') }}</span>
                            </div>
                          </div>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Wallet (cash)</label>
                          <div class="col-sm-10">
                            <div class="form-group">
                              <input min="0" type="number" class="form-control" name="cash" placeholder="Enter amount">
                            </div>
                          </div>
                      </div>
                    </div>
                 
                </div>
                <input type="submit" class="btn btn-primary" name="adduser">
              </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

