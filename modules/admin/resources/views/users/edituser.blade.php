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
            <h4 class="card-title">Update User - <b>{{$userdata->fname}} {{$userdata->lname}}</b></h4>
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
                              <input required type="text" class="form-control" value="{{$userdata['mobile']}}" name="phone" placeholder="Enter Mobile Number">
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
                            
                            <select required class="selectpicker countrylist col-sm-12" id="countrylist" data-style="select-with-transition"  name="country" title="Select Country" >
                              @if(count($countrylist)>0)              
                                @foreach($countrylist as $key=>$country)
                                      @if($key == $userdata['country'])
                                        <option selected value="{{ $key }}">{{$country}}</option>
                                      @else
                                        <option value="{{ $key }}">{{$country}}</option>
                                      @endif
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
                          @if(count($statelist)>0)              
                              @foreach($statelist as $key=>$state)
                                      @if($key == $userdata['state'])
                                        <option selected value="{{ $key }}">{{$state}}</option>
                                      @else
                                        <option value="{{ $key }}">{{$state}}</option>
                                      @endif
                              @endforeach
                          @endif
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
                              @if(count($citylist)>0)              
                                @foreach($citylist as $key=>$city)
                                      @if($key == $userdata['city'])
                                        <option selected value="{{ $key }}">{{$city}}</option>
                                      @else
                                        <option value="{{ $key }}">{{$city}}</option>
                                      @endif
                                @endforeach
                              @endif
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
                            <input required type="text" value="{{$userdata['fulladdress']}}" class="form-control" name="address" placeholder="Enter your full address">
                            <span class="text-danger">{{ $errors->first('address') }}</span>
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
                              <input required type="text" class="form-control" name="pincode" value="{{$userdata['pincode']}}" placeholder="Enter your pin code">
                              <span class="text-danger">{{ $errors->first('pincode') }}</span>
                            </div>
                          </div>
                      </div>
                    </div>

                    @if($userdata->user_details)
                    <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Wallet (cash)</label>
                          <div class="col-sm-10">
                            <div class="form-group">
                               <input min="0" type="number" class="form-control" name="cash" value="{{$userdata->user_details->cash}}" placeholder="Amount">
                            </div>
                          </div>
                      </div>
                    </div>
                    @endif

                </div>


                <div class="row">
                <div class="col-sm-6">
                    <input type="submit" class="btn btn-primary" name="edituser">
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
                                            <input  type="password" class="form-control" name="newpassword" >
                                        </div>
                                  </div>

                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>Confirm New Password</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input  type="password" class="form-control" name="confpass">
                                        </div>
                                  </div>
                                  <input type="hidden" name="agentid" value="{{($userdata['id'])}}">
                                  <button type="button" class="updatepassword btn btn-primary btn-block" name="updatepassword" value="Update Password">Update Password</button><div class="agentpasswordupdatediv">
                                </div>
                               </form>
                              </div>
                             <div class="modal-footer">
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

