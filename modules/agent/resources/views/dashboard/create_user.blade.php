@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
   <div class="container-fluid">
      <div class="page-title">
         <h3>My Agents
         </h3>
         <ul>
            <li>
               <a href="/">Home
               </a> 
               <span class="arrow-icon">
               <i class="fas fa-long-arrow-alt-right">
               </i>
               </span>
            </li>
            <li>
               <span>Your Profile
               </span>
            </li>
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
               <h4 class="card-header">
                  <button class="panel-button">
                  <i class="fas fa-bars">
                  </i>
                  </button>Add Agents
               </h4>
               <div class="card-body">
                  <div class="account-details">
                     <!--profile form-->
                     <div class="account-details">
                        @include('agent::message')
                       
                        <div class="edit-profile-form">
                           @if(!empty($user))
                           <form action="{{url('distributor/submit-agent-data/').'/'.$user->id}}" method = "post" enctype = "multipart/form-data">
                          @else
                           <form action="{{url('distributor/submit-agent-data')}}" method = "post" enctype = "multipart/form-data">
                            @endif  
                              {{csrf_field()}}
                              <div class = "row">
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="uname">First Name:</label>
                                       <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" value = "{{old('fname') ?? @$user->fname}}" required>
                                       <span class="text-danger">{{ $errors->first('fname') }}</span>
                                    </div>
                                 </div>
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="pwd">Last Name:</label>
                                       <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required value = "{{old('lname') ?? @$user->lname}}">
                                       <span class="text-danger">{{ $errors->first('lname') }}</span>
                                    </div>
                                 </div>
                              </div>
                              <div class = "row">
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="uname">Email</label>
                                       <input type="email" class="form-control" id="email" placeholder="Enter Email ID " name="email" required value = "{{old('email') ?? @$user->email}}">
                                       <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                 </div>
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="pwd">Mobile Number</label>
                                       <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile Number" name="mobile" required value = "{{old('mobile') ?? @$user->mobile}}">
                                       <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    </div>
                                 </div>
                              </div>
                              <div class = "row">
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="uname">Country</label>
                                       <select  class="form-control" id="countrylist" name="country">
                                       <option value = "">Select Country</option>
                                        @if(count($countrylist)>0)              
                                          @foreach($countrylist as $key=>$country)
                                                @if($key == @$user['country'])
                                                  <option selected value="{{ $key }}">{{$country}}</option>
                                                @else
                                                 
                                                  <option value="{{ $key }}">{{$country}}</option>
                                                @endif
                                          @endforeach
                                        @endif
                                        </select>
                                    </div>
                                 </div>
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="pwd">State</label>
                                       <select class="form-control statelist"  name="state" id="statelist"  >
                                       @if(!empty(count($statelist))>0)              
                                                @foreach($statelist as $key=>$state)
                                                        @if($key == @$user['state'])
                                                          <option selected value="{{ $key }}">{{$state}}</option>
                                                        @else
                                                          
                                                          <option value="{{ $key }}">{{$state}}</option>
                                                        @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                 </div>
                              </div>
                              <div class = "row">
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="uname">City</label>
                                       <select class="form-control citylist"  name="city" id="citylist" >
                                            
                                            @if(count($citylist)>0)              
                                                @foreach($citylist as $key=>$city)
                                                      @if($key == @$user['city'])
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
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="pwd">Pincode</label>
                                       <input type = "text" name = "pincode" class = "form-control" placeholder = "Enter Postal Code " value = "{{old('pincode') ?? @$user->pincode}}">
                                       <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    </div>
                                 </div>
                              </div>
                              <div class = "row">
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="uname">Password</label>
                                       <input type = "password" name = "password" placeholder = "Enter Password" class = "form-control" >
                                       <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                 </div>
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="pwd">Confirm Password</label>
                                       <input type = "password" name = "confpass" class = "form-control" placeholder = "Confirm Password">
                                       <span class="text-danger">{{ $errors->first('confpass') }}</span>
                                    </div>
                                 </div>
                              </div>
                              <div class = "row">
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="uname">Upload Pancard Image</label>
                                       <input type = "file" name = "pancard"  class = "form-control" >
                                       @if(!empty($userdetail))
                                       <img src = "{{url('public/uploads/agents/pancard').'/'.@$userdetail['pancard']}}" width = "150px" height = "100px">
                                    @endif
                                    </div>
                                 </div>
                                 <div class = "col-md-6">
                                    <div class="form-group">
                                       <label for="pwd">Upload GST</label>
                                       <input type = "file" name = "gst" class = "form-control" >
                                       @if(!empty($userdetail))
                                       <img src = "{{url('public/uploads/agents/gst').'/'.@$userdetail['gst']}}" width = "150px" height = "100px">
                                      @endif
                                    </div>
                                 </div>
                              </div>
                              <input type="submit" class="btn btn-primary" value = "submit">
                           </form>
                        </div>
                     </div>
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