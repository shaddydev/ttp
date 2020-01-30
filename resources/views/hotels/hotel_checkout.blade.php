@extends('layouts.app')
@section('content')
<section class="booking" ng-controller="CheckoutController">

<div class="container-fluid">
  <form name="travellerForm" method="POST" novalidate ng-submit="payNow(travellerForm.$valid);">
  {{ csrf_field() }}
   <div class="row">
 
      <div class="col-md-9">
         <div class="review-div">
            <div class="box-title"><i class="fas fa-search-plus"></i>  Review Your Booking</div>
            <div class="change"><a href="flights.html">Change Hotel</a></div>
         </div>
         <div class="booking-content">
            <div class="sector-detail">
               <div class="row">
                  <!-- <div class="text-sm-center col-sm-4 col-lg-4 text-xs-left">
                     <div class="hotel-pic">
                         <picture>
                           <source media="(min-width: 650px)" srcset="https://image.shutterstock.com/image-photo/red-apple-on-white-background-600w-158989157.jpg">
                           <source media="(min-width: 465px)" srcset="https://image.shutterstock.com/image-photo/red-apple-on-white-background-600w-158989157.jpg">
                           <img src="https://image.shutterstock.com/image-photo/red-apple-on-white-background-600w-158989157.jpg" class="img-fluid" alt="Hotel Room" >
                        </picture> 
                     </div>
                  </div> -->
                  <div class="col-sm-10 col-lg-10">
                     <div class="hotel-desc">
                        <h3>
                           <span class="hotel-name">@{{BlockRoomResult.HotelName}}</span> 
                           <span class="hotel-rate" ng-repeat="n in [] | range:BlockRoomResult.StarRating"><i class="fas fa-star"></i></span>
                        </h3>
                        <div class="address-hotel">
                           <p>@{{BlockRoomResult.AddressLine1}}</p>
                        </div>
                        <div class="inout-details">
                           <div class="checkin-date">
                              <div class="check-top">
                                 <span class="checkin-text">Check-In</span>
                                 <span class="date-value">{{date('d',strtotime($_GET['checkIndate']))}}</span>
                              </div>
                              <div class="month-value">
                                 <span>{{date('M',strtotime($_GET['checkIndate']))}}</span>
                              </div>
                           </div>
                           <div class="checkout-date">
                              <div class="check-top">
                                 <span class="checkin-text">Check-Out</span>
                                 <span class="date-value">{{date('d',strtotime($_GET['checkOutDate']))}}</span>
                              </div>
                              <div class="month-value"><span>{{date('M',strtotime($_GET['checkOutDate']))}}</span></div>
                           </div>
                           <div class="all-deatls">
                              <div class="days-nights">
                                 <p>{{$_GET['NoOfNights']+1}} Days & {{$_GET['NoOfNights']}} Nights</p>
                              </div>
                              <div class="room-value">
                                 <span class="room-numb">Room {{count(explode(',',$_GET['NoOfAdults']))}}:</span><span>{{$_GET['NoOfAdults']}} Adults</span>
                              </div>
                           </div>
                        </div>
                        <div class="disp-table">
                           <div class="disp-table-cell-left">Inclusion:</div>
                           <div class="disp-table-cellright">
                              <span  class="complementry" ><i class="fas fa-check"></i> Complimentary Wi-Fi Internet</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="cancelation">
               <p><b>Cancellation Policy:</b> @{{BlockRoomResult.HotelRoomsDetails[0].CancellationPolicy}}<span class="open">View More</span></p>
               <div class="showpanel">
                  <p><b>Hotel Policy :</b> @{{BlockRoomResult.HotelPolicyDetail}}</p>
               </div>
            </div>
         </div>
         <div class="booking-div">
            <div class="box-title"><i class="fas fa-user-edit"></i> Enter Traveller Details</div>
            <!-- <div class="change"><p><a href="login.html">Sign in</a>  to book faster and use eCash</p></div> -->
         </div>
		 
         <div class="traveller-details">
             
          
               <div class="row">
                  <div class="col-md-3">
                     <div class="labl"><label>Contact Details</label></div>
                  </div>
                  <div class="col-md-5 form-group">
                  <input type="text" class="form-control" placeholder="Email ID" name = "Email" ng-model="Email" required>
                  <span class="text-danger" ng-show="(travellerForm.Email.$dirty || submitted) && travellerForm.Email.$error.required">Email is required</span>
                  </div>
                  
                  <div class="col-md-4 form-group ad-mobile">
                     <div class="input-group">
                        <div class="input-group-prepend">
                           <div class="input-group-text">
                              <select>
                                 <option>+91</option>
                                 <option>(+355)</option>
                              </select>
                           </div>
                        </div>
                        <input type="text" class="form-control" name = "Phoneno" ng-model="Phoneno" required>
                        <span class="text-danger" ng-show="(travellerForm.Phoneno.$dirty || submitted) && travellerForm.Phoneno.$error.required">Phone number is required</span>
                     </div>
                  </div>
                  <div class="offset-3 col-md-9 col-xs-12">
                     <div class="padd-none">
                        <div class="txt2">
                           <p>Your booking details will be sent to this email address. </p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="offset-3 col-md-9">
                     <div class="travel-info">
                        <h4>Traveller Information</h4>
                        <p><span class="note">Important Note:</span> Please ensure that the names of the passengers on the travel documents is the same as on their government issued identity proof.</p>
                     </div>
                  </div>
                  <?php $rooms = explode(',',$_GET['NoOfAdults']) ?>
                  <?php //print_r($rooms);exit; ?>
                  @foreach($rooms as $room)
                  <div class="col-md-3">
                     <div class="labl"><label>Room {{$loop->iteration}}</label></div>
                  </div>
                  <div class="col-md-5 title-select form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                           <div class="input-group-text">
                              <select name = "Title{{$loop->iteration}}" ng-model="Title[{{$loop->iteration}}]" required>
                                 <option value = "">Title</option>
                                 <option value = "Mr">Mr.</option>
                                 <option value = "Mrs">Mrs.</option>
                                 <option value = "Ms">Ms.</option>
                                 <option value = "Miss">Miss.</option>
                              </select>
                           </div>
                        </div>
                        <input type="text" placeholder="First Name" class="form-control" name = "FirstName{{$loop->iteration}}" ng-model="FirstName[{{$loop->iteration}}]" required>
                     </div>
                     <span class="text-danger" ng-show="(travellerForm.Title{{$loop->iteration}}.$dirty || submitted) && travellerForm.Title{{$loop->iteration}}.$error.required">Title is required |</span>
                     <span class="text-danger" ng-show="(travellerForm.FirstName{{$loop->iteration}}.$dirty || submitted) && travellerForm.FirstName{{$loop->iteration}}.$error.required">First Name is required</span>
                  </div>
                  <div class="col-md-4 form-group"><input type="text" class="form-control" placeholder="Last Name" name = "LastName{{$loop->iteration}}" ng-model="LastName[{{$loop->iteration}}]" required>
                  <span class="text-danger" ng-show="(travellerForm.LastName{{$loop->iteration}}.$dirty || submitted) && travellerForm.LastName{{$loop->iteration}}.$error.required">Last Name is required</span>
                  </div>
                  
                  @endforeach
                  <!-- <input type = "text" name = "url" ng-model = "url" ng-value = "{{$_SERVER['QUERY_STRING']}}">  -->
               </div>
               
            
         </div>
         <div class="add-gst">
            <div class="add-inner">
               <div class="icon-div"><i class="fas fa-file-invoice"></i></div>
               <div class="add-txt">
                  <h4>Add your GST Details <span>(Optional)</span></h4>
                  <p>Claim credit of GST charges. Your taxes may get updated post submitting your GST details.</p>
               </div>
               <div class="add-btn">
                  <!-- <a href="#" class="show_hide"></a> -->
                  <div class="toggle">
                     <p>Show</p>
                  </div>
               </div>
            </div>
            <div class="content">
              
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
                              <div class="col-md-7">
                                 <div class="input-group">
                                    <div class="input-group-prepend">
                                       <div class="input-group-text">
                                          <select>
                                             <option>+91</option>
                                             <option>(+355)</option>
                                          </select>
                                       </div>
                                    </div>
                                    <input type="text" class="form-control">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 text-right"><button class="gst-btn">Add GST</button></div>
                  </div>
               
            </div>
         </div>
         <div class="proceed">
         <input class="btn btn-primary" type="submit" value="Proceed To Payment" name="submit">
         </div>
      </div>
	 
      <div class="col-md-3">
         <div class="fare-detail">
            <div class="fare-title">
               <h4>Tariff Details</h4>
            </div>
            <div class="fare-content">
               <div class="row">
                  <div class="col-8">
                     <div class="base">
                        <p>Hotel Charges</p>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="base-fare">
                        <i class="fas fa-rupee-sign"></i> @{{BlockRoomResult.HotelRoomsDetails[0].Price.OfferedPriceRoundedOff}}
                        <p></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-8">
                     <div class="base">
                        <p>Hotel GST</p>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="base-fare">
                        <p><i class="fas fa-rupee-sign"></i></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-8">
                     <div class="base">
                        <p>Convenience Fee & Taxes</p>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="base-fare">
                        <p><i class="fas fa-rupee-sign"></i>{{$corporate_service_charge}}</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="total-fare">
               <div class="you-pay">
                  <p>You Pay :</p>
               </div>
               <div class="total-amount">
                  <p><i class="fas fa-rupee-sign"></i> @{{$corporate_service_charge + BlockRoomResult.HotelRoomsDetails[0].Price.OfferedPriceRoundedOff}}</p>
               </div>
            </div>
         </div>
      </div>
	   </form>
   </div>
</div>
</section>
@endsection