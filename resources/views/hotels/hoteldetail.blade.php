@extends('layouts.app')
@section('content')
<section class="booking" ng-controller="HotelsDetailController">
   <div class="preloader" ng-if="HotelInfoResult.ResponseStatus !== 1 && GetHotelRoomResult.ResponseStatus !== 2" >
      <img class="absolute-image" src="/public/images/loader.gif">
   </div>
   
   <div class="container-fluid" >
   <div class="row">
      <div class="col-md-12" ng-switch="HotelInfoResult.ResponseStatus">
         <div class="backtoHotels" ng-switch-when="2">
            <div class="row d-flex align-items-center">
               <div class="col-md-6">
                  <div class="backto"><a href = "{{url()->previous()}}"<i class="fas fa-chevron-left"></i> Back to Search Results </a></div>
               </div>
               <div class="col-md-6">
                  <div class="searchModify">
                     <a href="#" data-toggle="modal" data-target="#hotel-modify"><i class="fas fa-search"></i> <span class="modify-search">Modify Search</span></a>
                  </div>
               </div>
            </div>
         </div>
       
         <div class = "row" ng-switch-when="2">
            <div class = "col-md-12">
               <h3 align = "center">Sorry,No Room Found </h3>
            </div>
         </div>
         <section ng-switch-default>
         <div class="backtoHotels">
            <div class="row d-flex align-items-center">
               <div class="col-md-6">
                  <div class="backto"><a href = "{{url()->previous()}}"<i class="fas fa-chevron-left"></i> Back to Search Results </a></div>
               </div>
               <div class="col-md-6">
                  <div class="searchModify">
                     <a href="#" data-toggle="modal" data-target="#hotel-modify"><i class="fas fa-search"></i> <span class="modify-search">Modify Search</span></a>
                  </div>
               </div>
            </div>
         </div>
         <div class="hotelNames" >
            <div class="row">
               <div class="col-md-6">
                  <div class="hotelnRate">
                     <div class="namehotel">@{{HotelInfoResult.HotelDetails.HotelName}}</div>
                     <div class="rate">
                        <div class="star-rating">
                           <p> </p>
                           <span style="width:@{{(HotelInfoResult.HotelDetails.StarRating)*25}}%">Rated <strong class="rating">0</strong> out of 5</span>
                        </div>
                     </div>
                  </div>
                  <div class="hotelAddress">
                     <p>@{{HotelInfoResult.HotelDetails.Address}}</p>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="hotelPrice">
                     <div class="roomRate">
                        <i class="fas fa-rupee-sign"></i> @{{GetHotelRoomResult.HotelRoomsDetails[0].Price.OfferedPriceRoundedOff}}
                        <div class="priceFor">
                           <p>Price for {{$_GET['NoOfNights']}} nights</p>
                        </div>
                     </div>
                     <div class="chooseRoom"><a href="#HOTELRoom" class="billBtn">Choose Room</a></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="hotelMenu"  id="myNavbar">
            <ul>
               <li><a href="#photos">Photos</a></li>
               <li><a href="#HOTELRoom" data-toggle="tab">Rooms</a></li>
               <li><a href="#reviews">Reviews</a></li>
               <li><a href="#mapview">Map</a></li>
               <li><a href="#policies">Hotel policies</a></li>
            </ul>
         </div>
         <div class="photos">
            <div class="row">
               <div class="col-md-8">
                  <div class="hotel-slide">
                     <div class="owl-carousel" id="hotelSlider">
                        <div class="hotelItem"  ng-repeat="(key,img) in HotelInfoResult.HotelDetails.Images">
                           <div class="hotel-img">
                              <img src="@{{img}}" class = "img-responsive">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="hotelRating">
                     <p>Very Good</p>
                     <div class="overAll">
                        <div class="star-rating">
                           <span style="width:@{{(HotelInfoResult.HotelDetails.StarRating)*25}}%">Rated <strong class="rating">0</strong> out of 5</span>
                        </div>
                        <a href="#reviews" class="overallReview">203 REVIEWS</a>
                     </div>
                     <div class="basedOn">
                        <p>Based on Overall Traveller Rating</p>
                     </div>
                  </div>
                  <div class="aboutHotel">
                     <ul>
                        <li>
                           <p class="full type-label"><i class="fas fa-check"></i> <span>Impressive Location </span><span class="green">4.0/5</span></p>
                        </li>
                        <li>
                           <p class="full type-label"><i class="fas fa-check"></i> <span>Refreshing Cleanliness </span><span class="green">4.0/5</span></p>
                        </li>
                     </ul>
                  </div>
                  <div class="inout-details">
                     <div class="checkin-date">
                        <div class="check-top">
                           <span class="checkin-text">Check-In</span>
                           <span class="date-value">12</span>
                        </div>
                        <div class="month-value">
                           <span>PM</span>
                        </div>
                     </div>
                     <div class="checkout-date">
                        <div class="check-top">
                           <span class="checkin-text">Check-Out</span>
                           <span class="date-value">12</span>
                        </div>
                        <div class="month-value"><span>PM</span></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="advantages">
                     <h3>Travel Trip Plus Advantages</h3>
                     <ul>
                        <li ng-repeat="row in HotelInfoResult.HotelDetails.HotelFacilities track by $index">
                           <span>@{{row}}</span>
                        </li>
                     </ul>
                  </div>
                  <div class="roomContent">
                     <p><strong>Description</strong></p>
                     <p> @{{ (HotelInfoResult.HotelDetails.Description )}}</p>
                     <p><strong>Attaction</strong></p>
                     <p></p>
                  </div>
               </div>
            </div>
         </div>
         <div class="chooseRoom" id = "HOTELRoom">
            <div class="titlesHotel">
               <h3>CHOOSE ROOM</h3>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="roomOption">
                     <!-- <form>
                        <div class="row">
                          
                          
                          <div class="col-md-3 form-group">
                            <div class="input-group">
                              
                              <input type="text" class="form-control hasDatepicker" id="departdate" placeholder="Check In Date">
                              <div class="input-group-addon">
                                <i class="fas fa-calendar-alt"></i>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 form-group">
                            <div class="input-group">
                              
                              <input type="text" class="form-control" id="returndate" placeholder="Check Out Date">
                              <div class="input-group-addon">
                                <i class="fas fa-calendar-alt"></i>
                              </div>
                            </div>
                            
                          </div>
                          <div class="col-md-3">
                            
                            <div id="tour-count1">
                              <div class="tourist-val"><span class="tour-count-val">2</span><span>Traveler, Economy</span></div>
                              <div class="tour-icon"><i class="fas fa-caret-down"></i></div>
                            </div>
                            <div class="touriests_count1">
                              <div class="tour-content1">
                                <div class="room-no">Room 1:</div>
                                <div class="tour-content">
                                  <span class="inputblock"><input name="adult" id="adult_count" type="text" value="1"> Adult</span>
                                  <div class="signs">
                                    <span class="minus" id="adult_minus">-</span>
                                    <span class="plus" id="adult_plus">+</span>
                                  </div>
                                </div>
                                
                                <div class="tour-content">
                                  <span class="inputblock"><input name="child" id="child_count" type="text" value="0"> Child</span>
                                  <div class="signs">
                                    <span class="minus" id="child_minus">-</span>
                                    <span class="plus" id="child_plus">+</span>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="add-del-room"><a href="#" class="hoteladdRoom">Add room</a></div>
                              <div class="be-ddn-footer"><a href="#">Done</a></div>
                            </div>
                          </div>
                          <div class="col-md-3"><div class="flight-Bbtn"><input type="button" value="Check Availability" class="hotelCheck"></div></div>
                        </div>
                        
                        
                        </form> -->
                     <div class="roomType">
                        <h3>Deluxe Room</h3>
                        <div class="aboutRoom">
                           <!-- <div class="roomLeft">
                              <div class="roomImg">
                                <a   data-toggle="modal" data-target="#myModal">
                                  <img src="assets/images/hotel3.jpg" class="img-fluid">
                                </a>
                              </div>
                              </div> -->
                            
                           <div class="roomRight" ng-if = "GetHotelRoomResult.ResponseStatus ===1 ">
                              <div class="roomFull" ng-repeat =  "(roomkey,room) in (GetHotelRoomResult.HotelRoomsDetails) | unique:'Price.OfferedPriceRoundedOff'" >
                              
                                 <h4>@{{room.RoomTypeName}}</h4>
                                 <div class="roomRow">
                                    <div class="guestNo">
                                       <h5>Max Guests</h5>
                                       <ul>
                                          <li><i class="fas fa-male"></i></li>
                                          <li><i class="fas fa-male"></i></li>
                                          <li><i class="fas fa-male"></i></li>
                                          <li><i class="fas fa-child"></i></li>
                                          <li><i class="fas fa-child"></i></li>
                                       </ul>
                                    </div>
                                    <div class="roomInclusion">
                                       <h5>Inclusions</h5>
                                       <ul>
                                          <li><i class="fas fa-check"></i> Complimentary Wi-Fi Internet</li>
                                          <li><i class="fas fa-check"></i> Stags/Bachelors not allowed</li>
                                       </ul>
                                    </div>
                                    <div class="roomHighlights">
                                       <h5>Highlights</h5>
                                       <ul>
                                          <li ng-repeat = "list in room.Amenities">
                                             <i class="fas fa-money-check"></i>@{{list}}
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="roomPrice">
                                       <h5>Price for {{$_GET['NoOfNights']}}nights</h5>
                                       <p>
                                          @{{room.Price.CurrencyCode}} @{{room.Price.OfferedPriceRoundedOff}}
                                       </p>
                                   
                                    </div>
                                    <div class="roomBook">
                                       <a href="#" class="roomBooking" ng-click="roomdetail('{{$_SERVER['QUERY_STRING']}}',HotelInfoResult.HotelDetails.HotelName,roomkey);">Book Now</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="mapView" id = "mapview">
            <div class="titlesHotel">
               <h3>MAP VIEW</h3>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="map">
                     <div id="googleMap" style="width:100%;height:400px;"></div>
                  </div>
               </div>
            </div>
         </div>
         <!-- <div class="nearby">
            <div class="titlesHotel">
              <h3>NEARBY LANDMARKS</h3>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="important">
                  <h3>Important</h3>
                  
                  <div class="row">
                    <div class="col-md-4 rightBr">
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                    </div>
                    <div class="col-md-4 rightBr">
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                    </div>
                    <div class="col-md-4 rightBr">
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                      <div class="landmarkList">
                        <div class="landmarkPlace">Titto'S Hospital</div>
                        <div class="landmarkDistance">0.24km</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div> -->
         <!-- <div class="hotelAmenities">
            <div class="titlesHotel">
              <h3>HOTEL AMENITIES</h3>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="amnitiesInner">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                      <div class="aminitieList">
                        <h4><i class="fas fa-user-lock"></i> Safety & Security</h4>
                        <ul>
                          <li><i class="fas fa-check"></i>Fire Extinguisher</li>
                          <li><i class="fas fa-check"></i>Security Guard Timings - 24x7</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed inside/outside hotel premises</li>
                          <li><i class="fas fa-check"></i>CCTV camera installed on each floor</li>
                          <li><i class="fas fa-check"></i>Doctor on Call</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div> -->
         <div class="hotelPolicies" ng-if = "HotelInfoResult.HotelDetails.HotelPolicy">
            <div class="titlesHotel" >
               <h3>HOTEL POLICIES</h3>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="policiesMain">
                     <div class="policiesInner">
                        <div class="policiesIn1">
                           @{{HotelInfoResult.HotelDetails.HotelPolicy}}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="ttpPolicy">
               <div class="row">
                  <div class="col-md-12">
                     <div class="faq">
                        <h3>FAQs</h3>
                        <div class="faqQa">
                           <h4>How do I know my reservation was booked ?</h4>
                           <p>You will receive an SMS and email on confirmation of your hotel(s) booking.</p>
                        </div>
                        <div class="faqQa">
                           <h4>Do I need to confirm my reservation ?</h4>
                           <p>There is no need to confirm your reservation. If you still feel you would like to verify that your reservation was made, you can do so by writing to our Customer Support Team or by contacting our customer services team.</p>
                        </div>
                        <div class="faqQa">
                           <h4>How do I cancel/amend a hotel(s) reservation?</h4>
                           <p>To cancel a booking log in to My Bookings section or call our call center on 0120-4904820 (all networks)</p>
                           <p>To amend a booking call our call center on 0120-4904820 (all networks).</p>
                        </div>
                        <div class="faqQa">
                           <h4>Is there a cancellation policy for hotel(s) booked on traveltripplus.com?</h4>
                           <p>The cancellation policy for hotel(s) bookings varies according to hotel(s) and room type. For more information, please check the cancellation policy mentioned next to the price for the room type. If you are cancelling after the check-in date, there will be no refund. In all cases, you'll be charged a standard cancellation fee of Rs. 250 per booking over and above the hotel(s)'s own cancellation charges.</p>
                        </div>
                        <div class="faqQa">
                           <h4>How do I pay for the gala dinner?</h4>
                           <p>Gala dinner charges which are applicable for Christmas and New Year dates would be extra and payable directly to the hotel(s). Please check with the hotel(s) directly for more information on the same.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 </section>
      </div>
	  
   </div>
</section>
<div class="modal fade" id="hotel-modify" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Modify Search</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
         </div>
         <div class="modal-body">
            <form method = "get" >
               <div class="row">
                  <div class="col-md-6 form-group">
                     <input type="text" placeholder="Select Place" class="form-control hotel-place" value = "{{$_GET['cityname']}}" id = "cityList">
                     <input type = "hidden" name = "cityname" value = "{{$_GET['cityname']}}">
                     <input type = "hidden" name = "cityid" value = "{{$_GET['cityid']}}">
                      <input type = "hidden" name = "countryid" value = "{{$_GET['countryid']}}">
                  </div>
                  <div class="col-md-3 form-group">
                     <div class="input-group" id = "date_up">
                        <input type ="text" class="dateHidden form-control" name = "checkIndate" value="{{$_GET['checkIndate']}}" id = "depart_date"/>
                        <a href="javascript:void(0);" id="modelchooseDateBtn" class="prodDetBtngreen activegreen"><i class="far fa-calendar-alt"></i></a>
                        <div class="choosedatepicker">
                           <div id="modeldepartdate" style="display:none;"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 form-group">
                     <div class="input-group" id = "date_down">
                        <input type ="text" class="dateHidden form-control" name = "checkOutDate" value="{{$_GET['checkOutDate']}}"  id = "return_date"/>
                        <input type = "hidden" id = "numberOfNight" name = "NoOfNights" value = "{{$_GET['NoOfNights']}}">
                        <a href="javascript:void(0);" id="modelchooseDateBtn1" class="prodDetBtngreen activegreen"><i class="far fa-calendar-alt"></i></a>
                        <div class="choosedatepicker">
                           <div id="modelreturndate" style="display:none;"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <div class= "row after-add-more">
                  <div class="col-md-12">
                     <label>Room 1 :</label>
                  </div>
                  <div class="col-md-4 mar-bottom">
                     <div class="value-inc"><button class="minus modelminus"  data-type="adultminus">-</button>
                        <span class="inputblock"><input name="NoOfAdults[]" id="tour_adult_count" type="text" value="1"> Adult<br>(above 12 years)</span>
                        <button class="plus modelplus"  data-type="adultplus">+</button>
                     </div>
                  </div>
                  <div class="col-md-4 mar-bottom">
                     <div class="value-inc"><button class="minus modelminus" data-type="childminus">-</button>
                        <span class="inputblock"><input name="NoOfChild[]" id="tour_child_count"  type="text" value="0"> Children<br>(below 12 years)</span>
                        <button class="plus modelplus" data-type="childplus">+</button>
                     </div>
                     <div class="tour-content age"> <span class="inputblock">Child Age </span></div>
                  </div>
                
                </div>
                  <div class="col-md-12">
                     <div class="add-row"><a href="#" class="under-link modeladd-more">Add another room</a> <a href="#" class="under-link modelremove" style = "display:none">Remove room</a>  </div>
                     
                  </div>

               </div>
               <div class="row form-group">
                  <div class="col-md-12">
                     <div class="flight-Bbtn"><button type = "submit" class = "billBtn" id = "hoteldetail">Search</button></div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection