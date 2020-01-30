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
            <h4 class="card-title">Add New Agent/Distributor</h4>
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
                            <select required class="selectpicker countrylist" id="countrylist" data-style="select-with-transition"  name="country" title="Select Country" >
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
                          <select class="selectpicker statelist" data-style="select-with-transition" name="state" id="statelist" title="Select State" >
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
                          <select class="selectpicker citylist" data-style="select-with-transition" name="city" id="citylist" title="Select City" >
                              <option value="0">Select city</option>
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
                            <input type="text" class="form-control" name="address" placeholder="Enter your full address">
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
                              <input type="text" class="form-control" name="pincode" placeholder="Enter your pin code">
                              <span class="text-danger">{{ $errors->first('pincode') }}</span>
                            </div>
                          </div>
                      </div>
                    </div>
                    <!-- Request for-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Request For</label>
                           <div class="col-sm-10">
                             <div class="form-group {{ $errors->has('requestfor') ? 'has-error' : '' }}">
                                <select class="selectpicker" data-style="select-with-transition" name="requestfor" title="Request for" >
                                    <option value="2">Agent</option>
                                    <option value="4">Distributor</option>
                                </select>
                              <span class="text-danger">{{ $errors->first('requestfor') }}</span>
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
                              <input type="password" class="form-control" name="password" placeholder="Enter your Password">
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
                              <input type="password" class="form-control" name="confpass" placeholder="Enter your confirm Password">
                              <span class="text-danger">{{ $errors->first('confpass') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <!-- Agent Name-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Agency Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('agentname') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="agentname" placeholder="Enter agent name">
                              <span class="text-danger">{{ $errors->first('agentname') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
                  <!-- Agent Address-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Agency Address</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('agentaddress') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" name="agentaddress" placeholder="Enter agent address">
                                <span class="text-danger">{{ $errors->first('agentaddress') }}</span>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <!-- Agent Name-->
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
                  <!-- Agent Address-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Wallet (credit)</label>
                          <div class="col-sm-10">
                            <div class="form-group">
                              <input min="0" type="number" class="form-control" name="credit" placeholder="Enter amount">
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
               


                <div class="row">
                  <!-- Agent Name-->
                  <div class="col-sm-6">
                      <div class="row">
                        <label class="col-sm-2 col-form-label">Corporate service charge</label>
                          <div class="col-sm-10">
                            <div class="form-group">
                              <input min="0" type="number" class="form-control" name="service_charge" placeholder="Enter amount">
                            </div>
                          </div>
                      </div>
                  </div>
                  <!-- Agent Address-->
                 
                </div>


                <div class="row">
                    <!-- Agent Name-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Pan Card</label>
                            <div class="col-sm-10">
                              
                                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                      <img src="{{ asset('public/admin/img/image_placeholder.jpg') }}" alt="..." width="200px" height="200px">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                      <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="pancard" id="img1" />
                                      </span>
                                      <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <!-- Agent Address-->
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">GST Attachments</label>
                            <div class="col-sm-10">
                              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                  <div class="fileinput-new thumbnail">
                                    <img src="{{ asset('public/admin/img/image_placeholder.jpg') }}" alt="..." width="200px" height="200px">
                                  </div>
                                  <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                  <div>
                                    <span class="btn btn-rose btn-round btn-file">
                                      <span class="fileinput-new">Select image</span>
                                      <span class="fileinput-exists">Change</span>
                                      <input type="file" name="gst" id="img2" />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
              <input class="btn btn-primary" type="submit" name="addagent">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

