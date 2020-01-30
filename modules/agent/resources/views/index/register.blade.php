@extends('layouts.app')

@section('content')

            <section class="page-title-wrapper">
                <div class="container-fluid">
                    <div class="page-title">
                        <h3>Agent/Distributor Registration</h3>
                        <ul>
                            <li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
                            <li><span>Registration</span></li>
                        </ul>
                    </div>
                </div>
            </section>
         <section class="login-page-form">
            <div class="container-fluid">
               <div class="form-main">
                <div class="form-inner-register">
                   @include('agent::message')
                    <form class="form-horizontal" method="POST" action="{{ url('agent/register') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6  form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
                                <label for="fname" class="control-label">First Name</label>

                                <div class="form-group">
                                    <input id="fname" type="text" class="form-control" name="fname" value="{{ old('fname') }}"  autofocus>
                                    <span class="text-danger">{{ $errors->first('fname') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6  form-group{{ $errors->has('lname') ? ' has-error' : '' }}">
                                <label for="lname" class="control-label">Last Name</label>

                                <div class="form-group">
                                    <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}"  autofocus>
                                    <span class="text-danger">{{ $errors->first('lname') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6  form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <div class="form-group">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >
                                    <input id="role" type="hidden"  name="role" value="agent">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6  form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>

                                <div class="form-group">
                                    <input id="password" type="password" class="form-control" name="password" >
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                                
                            </div>

                            <div class="col-md-6  form-group">
                                <label for="password-confirm" class="control-label">Confirm Password</label>
                                <div class="form-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
									<label for="mobile-number" >Mobile Number</label>
									<div class="input-group">
                                        <span class="input-group-btn">
                                            <select id="mobile-number" name="countrycode" value="{{ old('countrycode') }}" class="btn">
                                            @if(count($mobile_countrycode)>0)              
                                            @foreach($mobile_countrycode as $mobcode)
                                              <option value="{{ $mobcode->Countrycode }}">+{{ $mobcode->Countrycode }}</option>
                                            @endforeach
                                            @endif
                                            </select>
                                        </span>
                                        <input type="text" value="{{ old('phone') }}" class="form-control" name="phone" placeholder="Enter Mobile Number">
                                        </div>
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
								</div>

                            

                            <div class="col-md-6 form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                               <label for="countrylist" class="control-label">Country</label>
                                <div class="form-group">
                                    <select class="selectpicker countrylist form-control" id="countrylist" data-style="select-with-transition" value="{{ old('country') }}" data-show-subtext="true" data-live-search="true"  name="country" title="Select Country" >
                                    @if(count($countrylist)>0)              
                                    @foreach($countrylist as $key=>$country)
                                        <option value="{{ $key }}">{{$country}}</option>
                                    @endforeach
                                    @endif
                                    </select> <span class="text-danger">{{ $errors->first('country') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                            <label for="statelist" class="control-label">State</label>
                                <div class="form-group">
                                    <select class="selectpicker statelist form-control" value="{{ old('state') }}" data-show-subtext="true" data-live-search="true" data-style="select-with-transition" name="state" id="statelist" title="Select State" >
                                      </select><span class="text-danger">{{ $errors->first('state') }}</span>
                                </div>
                            </div>

                            
                            <div class="col-md-6 form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                <label for="citylist" class="control-label">City</label>
                                <div class="form-group">
                                    <select class="selectpicker citylist form-control" value="{{ old('city') }}" data-show-subtext="true" data-live-search="true" data-style="select-with-transition" name="city" id="citylist" title="Select City" >
                                  </select>
                                  <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                <label for="password-confirm" class="control-label">Full Address</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{ old('address') }}" name="address" placeholder="Enter your full address">
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('pincode') ? 'has-error' : '' }}">
                                <label for="password-confirm" class="control-label">Pin Code</label>
                                <div class="form-group">
                                   <input type="text" class="form-control" name="pincode" placeholder="Enter your pin code">
                                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                             <label for="password-confirm" class="control-label">Request For</label>
                                    <div class="form-group {{ $errors->has('requestfor') ? 'has-error' : '' }}">
                                        <select class="selectpicker form-control" data-style="select-with-transition" name="requestfor" title="Request for" >
                                            <option selected value="2">Agent</option>
                                            <option value="4">Distributor</option>
                                            <option value="3">Corporate User</option>
                                        </select>
                                    <span class="text-danger">{{ $errors->first('requestfor') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6  form-group">
                                <label for="agentname" class="control-label">Agency Name</label>
                                <div class="form-group">
                                    <input id="agentname" type="text" class="form-control" name="agentname" >
                                    <span class="text-danger">{{ $errors->first('agentname') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6  form-group">
                                <label for="agentaddress" class="control-label">Agency Address</label>
                                <div class="form-group">
                                    <input id="agentaddress" type="text" class="form-control" name="agentaddress" >
                                    <span class="text-danger">{{ $errors->first('agentaddress') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6  form-group">
                                <label for="agentname" class="control-label">Pan Card Attachment</label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="pancard" id="img1" />
                                    <span class="text-danger">{{ $errors->first('pancard') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6  form-group">
                                <label for="agentaddress" class="control-label">GST Attachment</label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="gst" id="img2" />
                                    <span class="text-danger">{{ $errors->first('gst') }}</span>
                                </div>
                            </div>

                            
                            <div class="col-md-6 form-group {{ $errors->has('reviewandaccept') ? 'has-error' : '' }}">
                                <label for="password-confirm" class="control-label">Accept Terms </label>
                                <div class="form-group">
                                    <select class="selectpicker form-control"  name="reviewandaccept" data-style="select-with-transition"  >
                                      <option value="">Please select</option>
                                      <option value="1">Yes</option>
                                      <option value="">No</option>
                                    </select>
                                </div>
                                <span class="text-danger">{{ $errors->first('reviewandaccept') }}</span>
                            </div>

                            <div class="col-md-6  form-group">
                            </div>

                            <div class="col-md-6  form-group">
                                <div class="col-md-offset-4">
                                   <input type="submit" name="agentreg" class="btn btn-primary" value="Register">
                                </div>
                            </div>

                        </div>
                        <ul class="inline-list">
								    <li>Already Register? <a href="{{ url('agent/login') }}">Login</a></li>
						</ul>
                    </form>
                  </div>
               </div>
            </div>
         </section>
@endsection