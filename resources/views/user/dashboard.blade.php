@extends('layouts.app')

@section('content')
            
            <section class="user-title-wrapper">
                <div class="container-fluid">
                    <div class="page-title">
                        <h3>Dashboard</h3>
                        <ul>
                            <li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
                            <li><span>Dashboard</span></li>
                        </ul>
                    </div>
                </div>
            </section>


      <section class="user-panel">
      <div class="container-fluid">

      <!-- Bootstrap row -->
      <div class="row" id="body-row">


        <!--sidebar-->
        @include('agent::layouts.sidebar')

        <!--content-->
          <div class="col">
        
        <div class="card">
            <h4 class="card-header"><button class="panel-button"><i class="fas fa-bars"></i></button> My Account</h4>
            <div class="card-body">
               <div class="account-details">
               	<div class="profile-title"><h3>My Profile</h3></div>
               	<div class="profile-main">
               		<div class="profile-inner">
               			<div class="profile-left"><div class="profile-icon"><i class="fas fa-user"></i></div></div>
               			<div class="profile-right">
               				<div class="profile-right-detail">
               					<h4>{{ Auth::user()->fname }}  {{ Auth::user()->lname }}</h4>
               					<p><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</p>
               					<p><i class="fa fa-phone"></i> {{'(+ '.Auth::user()->countrycode.') '}}{{ Auth::user()->mobile }}</p>
               				</div><div id="profileupateddiv"></div>
               				<div class="profile-left-btn">
               					<a href="#" class="profile-editbtn" id="edit_btn">Edit <i class="fas fa-pen"></i></a>
               				</div>
               			</div>
               		</div>
               	</div>
                <!--profile form-->
                      <div class="account-details">
                <!-- <div class="profile-title"><h3>Edit Profile</h3></div> -->
                <div class="edit-profile-form">
                    <form id="agentprofile">
                    <div class="row form-group">
                      <div class="col-md-3"><label>User Name:</label></div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-2">
                            <select class="form-control" name="gender">
                              @if(Auth::user()->gender == 1)
                                <option value="0">Select Gender</option>
                                <option value="1" selected="selected">Mr.</option>
                                <option value="2">Ms.</option>
                            @elseif(Auth::user()->gender == 2)
                              <option value="0">Select Gender</option>
                                <option value="1">Mr.</option>
                                <option value="2" selected="selected">Ms.</option>
                              @else
                                <option value="0" selected="selected">Select Gender</option>
                                <option value="1">Mr.</option>
                                <option value="2">Ms.</option>
                              @endif
                          </select>
                        </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control" name="fname" placeholder="First name" value="{{  Auth::user()->fname }}">
                          </div>
                          <div class="col-md-5"><input type="text" class="form-control" name="lname" placeholder="{{  Auth::user()->lname  }}"  value="{{  Auth::user()->lname  }}"></div>
                        </div>
                      </div>
                    </div>

                    <div class="row form-group">
                      <div class="col-md-3"><label>Email:</label></div>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{ Auth::user()->email }}">
                      </div>
                    </div>
<div class="row form-group">
                      <div class="col-md-3"><label>Update Password:</label></div>
                      <div class="col-md-9">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myPasswordchange">Password Change</button>
                         <!-- Modal -->
                
                  <!-- updated password -->
                  <div class="agentpasswordupdatediv"></div>
                      </div>
                    </div>
                    <div class="row form-group">
                      <div class="col-md-3"><label>Phone:</label></div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-3">
                            <select class="selectpicker form-control" data-style="select-with-transition" name="countrycode" title="Select CountryCode">
                                      @if(count($mobile_countrycode)>0)              
                                      @foreach($mobile_countrycode as $mobcode)
                                        @if(Auth::user()->countrycode == $mobcode->Countrycode)
                                          <option value="{{ $mobcode->Countrycode }}" selected="selected">+ {{ $mobcode->Countrycode }}</option>
                                        @else
                                          <option value="{{ $mobcode->Countrycode }}">+ {{ $mobcode->Countrycode }}</option>
                                        @endif
                                        
                                      @endforeach
                                      @endif
                                    </select>
                          </div>
                          <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Phone Number"  name="phonenumber" value="{{ Auth::user()->mobile }}">
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    

                    <div class="row form-group address-space">
                      <div class="col-md-3"><label>Address:</label></div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-6 ">
                            <select class="selectpicker countrylist form-control" id="countrylist" data-style="select-with-transition"  name="country" title="Select Country" >
                                    @if(count($countrylist)>0)              
                                    @foreach($countrylist as $country)
                                      @if(Auth::user()->country == $country->country_id)
                                        <option value="{{ $country->country_id }}" selected="selected">{{ $country->country_name }}</option>
                                      @else
                                        <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                                      @endif
                                      
                                    @endforeach
                                    @endif
                                  </select>
                          </div>
                          <div class="col-md-6">
                            <select class="selectpicker statelist form-control" data-style="select-with-transition" name="state" id="statelist" title="Select State" >
                                   <option value="0">Select state</option>
                                    @if(count($statelist)>0)              
                                    @foreach($statelist as $state)
                                      @if(Auth::user()->state == $state->state_id)
                                        <option value="{{ $state->state_id }}" selected="selected">{{ $state->state_name }}</option>
                                      @else
                                        <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>
                                      @endif
                                      
                                    @endforeach
                                    @endif
                                </select>
                          </div>
                          <div class="col-md-6">
                            <select class="selectpicker statelist form-control" data-style="select-with-transition" name="city" id="statelist" title="Select State" >
                                    <option value="0">Select state</option>
                                    @if(count($citylist)>0)              
                                      @foreach($citylist as $city)
                                        @if(Auth::user()->city == $city->city_id)
                                          <option value="{{ $city->city_id }}" selected="selected">{{ $city->city_name }}</option>
                                        @else
                                          <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                                        @endif
                                        
                                      @endforeach
                                      @endif
                                  </select>
                          </div>
                          <div class="col-md-6"><input type="text" class="form-control" placeholder="Enter Pincode" name="pincode" value="{{ Auth::user()->pincode }}"></div>
                          <div class="col-md-12">
                            <textarea rows="4" placeholder="Enter Address" name="fulladdress" class="form-control">{{ Auth::user()->fulladdress }}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <button type="Submit" id="agentprofileinfo" class="form-submit">
                        Submit</button>
                      </div>
                            <div class="modal fade" id="myPasswordchange" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              
                              <h4 class="modal-title">Password Change</h4>

                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <form >
                                 
                                <div class="row form-group">
                                  <div class="col-md-6">
                                    <label>Old Password</label>
                                  </div>
                                  <div class="col-md-6">
                                    <input type="password" class="form-control" name="oldpassword">
                                  </div>
                                </div>

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
                                <button type="button" class="form-control updatepassword" name="updatepassword" value="Update Password">Update Password</button><div class="agentpasswordupdatediv"></div>
                              </form>
                            </div>
                            <div class="modal-footer">
                            
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
               </div>
                <!-- edit profile comp form-->
               </div>

                <div class="account-details">
               	<div class="profile-title"><h3>Gst Details</h3></div>
               	<div class="profile-main">
               		<div class="profile-inner">
               			<div class="profile-left"><div class="profile-icon"><i class="fas fa-file-invoice"></i></div></div>
               			<div class="profile-right">
               				<div class="profile-right-detail">
               					<h4>Gst Number</h4>
               					<p>Add Gst Details</p>
               				</div>
               				<div class="profile-left-btn">
               					<a href="#" class="profile-editbtn" id="edit_btn1">Add <i class="fas fa-plus"></i></a>
               				</div>
               			</div>
               		</div>
                  <!--gst form-->
                            <div class="content" >
                    <form>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="gst-form">
                            <div class="row form-group">
                              <div class="col-md-5"><label>GST Number:</label></div>
                              <div class="col-md-7"><input type="text" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-5"><label>Email Id:</label></div>
                              <div class="col-md-7"><input type="text" class="form-control"></div>
                            </div>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="gst-form">
                            <div class="row form-group">
                              <div class="col-md-5"><label>Company Name:</label></div>
                              <div class="col-md-7"><input type="text" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-5"><label>Mobile Number</label></div>
                              <div class="col-md-7"><div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <select>
                                      <option>+91</option>
                                      <option>(+355)</option>
                                      
                                    </select>
                                  </div>
                                </div>
                                <input type="text" placeholder="First Name" class="form-control">
                              </div></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 text-right"><button class="gst-btn">Add GST</button></div>
                      </div>
                    </form>
                  </div>

                    <!-- end gst form-->
               	</div>
               </div>


            </div>
        </div>
       


    </div>
    <!-- end content-->
</div>
</div>
</section>
		</div>
		
@endsection

