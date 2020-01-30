@extends('layouts.app')

@section('content')

<div class="modal fade conformModal" id="confirm" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      @php
      {{
        $flightItenary = unserialize(Cookie::get('all_post'));
        $start = explode('-',$flightItenary['start']);
        $end = explode('-',$flightItenary['end']);
      }}
      @endphp
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Confirming Your Flight(s)</h4>
            <p class="top-para">
               <span class="meal">{{$flightItenary['adult']+$flightItenary['child']+$flightItenary['infant']}} Traveller(s)</span>
               <span class="economy"><span class="light-line">|</span> {{($flightItenary['cabin_class']===2)?'Economy':($flightItenary['cabin_class']===3)?'Premium Economy':($flightItenary['cabin_class']===4)?'Business':'All'}}</span>
            </p> 
         </div>
         <div class="modal-body">
            <div class="flightsDuration row">
               <div class="flightFrom col-md-5">
                  <p><strong>{{$flightItenary['origin']}}</strong></p>
                  <p>{{ $start[1] }}</p>
               </div>
               <div class="flightDate col-md-3">
                  <p>{{ date("D, d M",strtotime($flightItenary['date_up'])) }}</p>
               </div>
               <div class="flightTo col-md-4">
                  <p><strong>{{$flightItenary['destination']}}</strong></p>
                  <p>{{ $end[1]  }}</p>
               </div>
            </div>
             @if($flightItenary['date_down']!==null)
               <div class="flightsDuration row">
                  <div class="flightFrom col-md-5">
                     <p><strong>{{$flightItenary['destination']}}</strong></p>
                     <p>{{$end[1]}}</p>
                  </div>
                  <div class="flightDate col-md-3">
                     <p>{{ date("D, d M",strtotime($flightItenary['date_down'])) }}</p>
                  </div>
                  <div class="flightTo col-md-4">
                     <p><strong>{{$flightItenary['origin']}}</strong></p>
                     <p>{{$start[1]}}</p>
                  </div>
                  </div>
               @endif
         </div>
         <div class="loader-sm" >
                     <p><img class="no-data" src="/public/images/loader-small.gif"></p>
               </div>
      </div>
      
   </div>
</div>

<div class="site-wrapper" ng-controller="bookingController" >
   <div class="home-content">
      <section class="booking">
         <div class="container-fluid">
         <div class="row" ng-if="searchResponse === 0 " >
               <div class="col-md-12" >
                     <img class="no-data" src="/public/images/loading-booking.png">
               </div>
            </div>
            <form name="travellerForm" method="POST" novalidate ng-submit="payNow(travellerForm.$valid);" >
            {{ csrf_field() }}
              <div class="row" ng-if="searchResponse === 1 && hasError === 0" >
               <div class="col-md-9" >
                  <div class="review-div">
                     <div class="box-title"><i class="fas fa-search-plus"></i>Flight Detail</div>
                     <div class=""><a class="btn btn-primary" ng-click="goBackToSearch();" href="javascript:void(0);">Change Flight</a></div>
                  </div>
                 
                  <div class="booking-content" ng-repeat="(trip_key, trips) in responseData.fareQuote" >
                     <div class="total-time" ng-if="trips.Response.Results.Segments.length==1" >
                        <span class="trip-time">Total Time: @{{ timeFormatText(trips.Response.Results.Segments[0][0].Duration)}}</span> 
                        <span class="trip-date" ng-if="trip_key==0">Date:{{ date("D, d M",strtotime($flightItenary['date_up'])) }}</span>
                        <span class="trip-date" ng-if="trip_key==1">Date:{{ date("D, d M",strtotime($flightItenary['date_down'])) }}</span>
                        <span class="review-title" ng-if="trip_key==0" >Departure</span>
                        <span class="review-title" ng-if="trip_key==1" >Return</span>
                     </div>

                     <div class="total-time" ng-if="trips.Response.Results.Segments.length>1" >
                      
                      @{{ str_replace('T',' ',trips.Response.Results.Segments[0][0].Origin.DepTime) }}
                        <span class="trip-time">Total Time: @{{ timeFormatText(trips.Response.Results.Segments[0][trips.Response.Results.Segments[0].length-1].AccumulatedDuration)}}</span>
                        <p class="text-left">Depature Date:{{ $flightItenary['date_up']}}</p><br>
                        <p class="text-left">Return Date:{{ $flightItenary['date_down']}}</p>
                        <span class="review-title" >Departure & Return</span>
                     </div>

                     <div class="sector-detail">

                     <div class="row" ng-if="trips.Response.Results.Segments.length==1" ng-repeat="(seg_key, segment) in trips.Response.Results.Segments[0]" >
                        <div class="text-sm-center col-sm-2 col-lg-3 text-xs-left">
                           <div class="flight-pic">
                           <picture>
                              <source media="(min-width: 650px)" srcset="/public/images/airlines/@{{segment.Airline.AirlineCode}}.gif">
                              <source media="(min-width: 465px)" srcset="/public/images/airlines/@{{segment.Airline.AirlineCode}}.gif">
                              <img src="/public/images/airlines/@{{segment.Airline.AirlineCode}}.gif" alt="flight logo" style="width:auto;">
                           </picture>
                           </div>
                           <div class="flight-info">
                           <p>@{{segment.Airline.AirlineName}}</p>
                           <p class="small-txt">@{{segment.Airline.AirlineCode}}-@{{segment.Airline.FlightNumber}}</p>
                           <p>@{{segment.Craft}}</p>
                           </div>
                        </div>
                        <div class="col-sm-10 col-lg-9">
                           <div class="row">
                           <div class="col-6 order-first col-md-3">
                              <div class="from-place">
                                 <p>@{{segment.Origin.Airport.CityName}}, @{{segment.Origin.Airport.CountryCode}}</p>
                                 <h3>@{{segment.Origin.DepTime.substr(11,5)}}</h3>
                                 <p class="bold"></p>
                                 <span class="gray-light">@{{segment.Origin.Airport.AirportName}}<span><terminal ng-if="segment.Origin.Airport.Terminal!==''" >, T-@{{segment.Origin.Airport.Terminal}}</terminal></span></span>
                              </div>
                           </div>
                           <div class="col-6 col-md-3">
                              <div class="to-place">
                                 <p>@{{segment.Destination.Airport.CityName}}, @{{segment.Destination.Airport.CountryCode}}</p>
                                 <h3>@{{segment.Destination.ArrTime.substr(11,5)}}</h3>
                                 <p class="bold"></p>
                                 <span class="gray-light">@{{segment.Destination.Airport.AirportName}}<span><terminal ng-if="segment.Destination.Airport.Terminal!==''" >, T-@{{segment.Destination.Airport.Terminal}}</terminal></span></span>
                              </div>
                           </div>
                           <div class="col-sm-12 text-center order-md-first col-md-6 col-lg-6">
                              <p class="top-para">
                                 <span class="time-taken">
                                 <i class="far fa-clock"></i>&nbsp; @{{ timeFormatText(segment.Duration)}} &nbsp;</span>
                                 <span class="meal"><span class="light-line">|</span>&nbsp;Free Meal</span>
                                 <span class="economy"><span class="light-line">|</span>&nbsp; Economy</span>
                              </p>
                              <p class="middle-para"><span class="type-text"><i class="fas fa-plane"></i>Flight</span></p>
                              <p class="bottom-para"><span>@{{segment.Baggage}}&nbsp;</span><span class="light-line">|</span>&nbsp;
                              <span ng-if="trips.Response.Results.IsRefundable===true" class="text-success" >Partially Refundable</span>
                              <span ng-if="trips.Response.Results.IsRefundable===false" class="text-danger" >Non-Refundable</span>
                              </p>
                           </div>
                           </div>
                        </div>
                     </div>

                     <div class="" ng-if="trips.Response.Results.Segments.length>1" ng-repeat="(seg_key, segment_main) in trips.Response.Results.Segments" >
                     <div class="row"  ng-repeat="(seg_key, segment) in segment_main" >
                        <div class="text-sm-center col-sm-2 col-lg-3 text-xs-left">
                           <div class="flight-pic">
                           <picture>
                              <source media="(min-width: 650px)" srcset="/public/images/airlines/@{{segment.Airline.AirlineCode}}.gif">
                              <source media="(min-width: 465px)" srcset="/public/images/airlines/@{{segment.Airline.AirlineCode}}.gif">
                              <img src="/public/images/airlines/@{{segment.Airline.AirlineCode}}.gif" alt="flight logo" style="width:auto;">
                           </picture>
                           </div>
                           <div class="flight-info">
                           <p>@{{segment.Airline.AirlineName}}</p>
                           <p class="small-txt">@{{segment.Airline.AirlineCode}}-@{{segment.Airline.FlightNumber}}</p>
                           <p>@{{segment.Craft}}</p>
                           </div>
                        </div>
                        <div class="col-sm-10 col-lg-9">
                           <div class="row">
                           <div class="col-6 order-first col-md-3">
                              <div class="from-place">
                                 <p>@{{segment.Origin.Airport.CityName}}, @{{segment.Origin.Airport.CountryCode}}</p>
                                 <h3>@{{segment.Origin.DepTime.substr(11,5)}}</h3>
                                 <p class="bold"></p>
                                 <span class="gray-light">@{{segment.Origin.Airport.AirportName}}<span><terminal ng-if="segment.Origin.Airport.Terminal!==''" >, T-@{{segment.Origin.Airport.Terminal}}</terminal></span></span>
                              </div>
                           </div>
                           <div class="col-6 col-md-3">
                              <div class="to-place">
                                 <p>@{{segment.Destination.Airport.CityName}}, @{{segment.Destination.Airport.CountryCode}}</p>
                                 <h3>@{{segment.Destination.ArrTime.substr(11,5)}}</h3>
                                 <p class="bold"></p>
                                 <span class="gray-light">@{{segment.Destination.Airport.AirportName}}<span><terminal ng-if="segment.Destination.Airport.Terminal!==''" >, T-@{{segment.Destination.Airport.Terminal}}</terminal></span></span>
                              </div>
                           </div>
                           <div class="col-sm-12 text-center order-md-first col-md-6 col-lg-6">
                              <p class="top-para">
                                 <span class="time-taken">
                                 <i class="far fa-clock"></i>&nbsp; @{{ timeFormatText(segment.Duration)}} &nbsp;</span>
                                 <span class="meal"><span class="light-line">|</span>&nbsp;Free Meal</span>
                                 <span class="economy"><span class="light-line">|</span>&nbsp; Economy</span>
                              </p>
                              <p class="middle-para"><span class="type-text"><i class="fas fa-plane"></i>Flight</span></p>
                              <p class="bottom-para"><span>@{{segment.Baggage}}&nbsp;</span><span class="light-line">|</span>&nbsp;
                              <span ng-if="trips.Response.Results.IsRefundable===true" class="text-success" >Partially Refundable</span>
                              <span ng-if="trips.Response.Results.IsRefundable===false" class="text-danger" >Non-Refundable</span>
                              </p>
                           </div>
                           </div>
                        </div>
                        </div>
                     </div>
                      <input type="hidden" ng-model="user.tripDetails" value="@{{responseData.fareQuote}}"  />
                     </div>
                  </div>
                  <div class="booking-div">
                     <div class="box-title"><i class="fas fa-user-edit"></i> Traveller Details</div>
                     <!-- <div class="change"><p><a href="login.html">Sign in</a>  to book faster and use eCash</p></div> -->
                  </div>
                  <div class="traveller-details" id="traveller-details" >
                        <div class="row" ng-if="response.length>0" ng-repeat="(er_key, error) in response" >
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                           <div ng-class="error.type=='error'?alert-danger:alert-success" class="alert alert-danger alert-dismissible fade show">
                              <strong>@{{error.type}}</strong>@{{error}}.
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                           </div>
                        </div>
                        </div>

                        <!--<div class="row" >
                        <div class="col-md-3">
                              <div class="labl"><label>Login</label></div>
                           </div>
                           <div class="col-md-3 form-group">
                              <input type="text" ng-model="login.email" required  name="email" class="form-control" placeholder="Email">
                              <span class="text-danger" ng-show="(travellerForm.email.$dirty || loginSubmitted) && travellerForm.email.$error.required">Email is required</span>
                           </div>
                           <div class="col-md-3 form-group ad-mobile">
                              <input ng-model="login.password" required type="password" placeholder="Password" name="password" class="form-control">
                              <span class="text-danger" ng-show="(travellerForm.password.$dirty || loginSubmitted) && travellerForm.password.$error.required">Password is required</span>
                           </div>

                           <div class="col-md-3 form-group ad-mobile">
                              <a class="btn btn-info" href="javascript:void(0);" ng-click="doLogin();" >Login</a>
                           </div>

                           <hr>
                           <strong>OR</strong>
                        </div>-->
                        <div class="row">
                           <div class="col-md-3">
                              <div class="labl"><label>Contact Details</label></div>
                           </div>
                           <div class="col-md-5 form-group">
                              <input type="text" ng-model="user.emailId" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required  name="emailId" class="form-control" placeholder="Email ID">
                              <span class="text-danger" ng-show="(travellerForm.emailId.$dirty || submitted) && travellerForm.emailId.$error.required">Email is required</span>
                              <span class="text-danger" ng-show="(travellerForm.emailId.$dirty || submitted) && travellerForm.emailId.$error.pattern">Please Enter Valid Email</span>
                           </div>
                           <div class="col-md-4 form-group ad-mobile">
                              <div class="input-group">
                                 <div class="input-group-prepend">
                                    <div class="input-group-text">
                                       <select ng-model="user.countryCode" >
                                          <option value="91" >+91</option>
                                       </select>
                                    </div>
                                 </div>
                                 <input ng-model="user.mobileNo" required type="number" ng-minlength="10"  ng-maxlength="10"  placeholder="Mobile Number" name="mobileNo" class="form-control">
                              </div>
                              <span class="text-danger" ng-show="(travellerForm.mobileNo.$dirty || submitted) && travellerForm.mobileNo.$error.required">Phone number is required</span>
                              <span class="text-danger" ng-show="(travellerForm.mobileNo.$dirty || submitted) && (travellerForm.mobileNo.$error.minlength ||
                              travellerForm.mobileNo.$error.maxlength) ">Phone number should be 10 digits</span>
                           </div>
                           <div class="offset-3 col-md-9 col-xs-12">
                              <div class="padd-none">
                                 <div class="txt2">
                                    <p>Note: All communication related to booking will be send to this email address and mobile</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           
                           <div class="offset-3 col-md-9">
                              <div class="travel-info">
                                 <p><span class="note">Important Note:</span>Please make sure that travellers names are as per government approved identity card or passport</p>
                              </div>
                           </div>



                           
                           <div class="offset-0 col-md-12 mb-4" ng-repeat="(userKey, userTypes) in responseData.fareQuote[0].Response.Results.FareBreakdown" >
                            <div class="row" ng-repeat="n in [] | range:userTypes.PassengerCount" >
                                 <div class="col-md-3">
                                    <div class="labl">
                                       <label ng-if="userTypes.PassengerType===1" >Adult @{{n+1}}</label>
                                       <label ng-if="userTypes.PassengerType===2" >Child @{{n+1}}</label>
                                       <label ng-if="userTypes.PassengerType===3" >Infrant @{{n+1}}</label>
                                 </div>
                                 </div>
                                 <div class="col-md-3 title-select form-group">
                                    <div class="input-group">
                                       <div class="input-group-prepend">
                                          <div class="input-group-text">
                                             <select  ng-if="userTypes.PassengerType===1" ng-model="user.ticket[userKey][n]['title']" >
                                                <option value="Mr" >Mr.</option>
                                                <option value="Mrs" >Mrs.</option>
                                                <option value="Ms" >Ms.</option>
                                             </select>
                                             <select  ng-if="userTypes.PassengerType===2 || userTypes.PassengerType===3 " ng-model="user.ticket[userKey][n]['title']" >
                                                <option value="Mstr" >Master</option>
                                                <option value="Miss" >Miss</option>
                                             </select>
                                          </div>
                                       </div>
                                       <input ng-model="user.ticket[userKey][n]['fname']" name="ticket_fname_@{{userKey}}_@{{n}}" required  type="text" placeholder="First Name" class="form-control">
                                    </div>
                                    <span class="text-danger" ng-show="(travellerForm.ticket_fname_@{{userKey}}_@{{n}}.$dirty || submitted) && travellerForm.ticket_fname_@{{userKey}}_@{{n}}.$error.required">First Name is required</span>
                                 </div>

                              <div class="col-md-3 form-group"><input ng-model="user.ticket[userKey][n]['lname']" name="ticket_lname_@{{userKey}}_@{{n}}" required type="text" class="form-control" placeholder="Last Name">
                              
                              <span class="text-danger" ng-show="(travellerForm.ticket_lname_@{{userKey}}_@{{n}}.$dirty || submitted) && travellerForm.ticket_lname_@{{userKey}}_@{{n}}.$error.required">Last Name is required</span>

                              </div>

                              <div class="col-md-3 form-group">
                                 
                                 <md-datepicker ng-required='hasAirIndia'  name="ticket_dob_@{{userKey}}_@{{n}}" ng-if="userTypes.PassengerType===1" ng-model="user.ticket[userKey][n]['dob']" md-placeholder="DOB"  md-min-date="minDate.adult" md-max-date="maxDate.adult" ></md-datepicker>

                                 <md-datepicker required name="ticket_dob_@{{userKey}}_@{{n}}" ng-if="userTypes.PassengerType===2" ng-model="user.ticket[userKey][n]['dob']" md-placeholder="DOB"  md-min-date="minDate.child" md-max-date="maxDate.child" ></md-datepicker>

                                 <md-datepicker required  name="ticket_dob_@{{userKey}}_@{{n}}" ng-if="userTypes.PassengerType===3" ng-model="user.ticket[userKey][n]['dob']" md-placeholder="DOB"  md-min-date="minDate.infant" md-max-date="maxDate.infant" ></md-datepicker>

                                 <span class="text-danger" ng-show="(travellerForm.ticket_dob_@{{userKey}}_@{{n}}.$dirty || submitted) && travellerForm.ticket_dob_@{{userKey}}_@{{n}}.$error.required">DOB is required</span>
                              </div>
                              

                           <div class="offset-3 col-md-9" >
                              <div class="row" > 
                                   <div  class="col-md-3 labl">
                                       <label >Passport</label>
                                   </div>

                                  <div class="col-md-5 form-group" >
                                    <input ng-model="user.ticket[userKey][n]['passport']"  name="ticket_pno_@{{userKey}}_@{{n}}" class="form-control" id="ticket_pno_@{{userKey}}_@{{n}}" placeholder="Passport Number"  >

                                    <span class="text-danger" ng-show="(travellerForm.ticket_pno_@{{userKey}}_@{{n}}.$dirty || submitted) && travellerForm.ticket_pno_@{{userKey}}_@{{n}}.$error.required">Passport No is required</span>
                                  </div>

                                  

                                  <div class="col-md-4 form-group" >
                                    <md-datepicker   ng-model="user.ticket[userKey][n]['expiry']" md-placeholder="Expiry"  md-min-date="passportExpiry.min" md-max-date="passportExpiry.max" ></md-datepicker>
                                  </div>
                              </div>
                            </div>

                            <div class="offset-3 col-md-9" >
                              <div class="row" > 
                                 
                                 <div  class="col-md-2 labl">
                                       <label >Nationality</label>
                                 </div>
                                 <div class="col-md-4 form-group" >
                                       <select required name="ticket_nationality_@{{userKey}}_@{{n}}"  class="form-control" id="ticket_nationality_@{{userKey}}_@{{n}}" ng-model="user.ticket[userKey][n]['nationality']">
                                       <option value= "IN" ng-selected="user.ticket[userKey][n]['nationality'] = 'IN'">India</option>
                                          <option ng-repeat="(ckey, country) in responseData.countrylist" value="@{{ckey}}" >@{{country}}</option>
                                       </select>

                                       <span class="text-danger" ng-show="(travellerForm.ticket_nationality_@{{userKey}}_@{{n}}.$dirty || submitted) && travellerForm.ticket_nationality_@{{userKey}}_@{{n}}.$error.required">Nationality is required</span>
                                 </div>

                                 <div  class="col-md-2 labl">
                                       <label >Country</label>
                                 </div>
                                 <div class="col-md-4 form-group" >
                                       <select required name="ticket_pcountry_@{{userKey}}_@{{n}}"  class="form-control" id="ticket_pcountry_@{{userKey}}_@{{n}}" ng-model="user.ticket[userKey][n]['visa_country']" >
                                          <option value= "IN" ng-selected="user.ticket[userKey][n]['visa_country'] = 'IN'">India</option>
                                          <option ng-repeat="(ckey, country) in responseData.countrylist" value="@{{country}}" >@{{country}}</option>
                                       </select>

                                       <span class="text-danger" ng-show="(travellerForm.ticket_pcountry_@{{userKey}}_@{{n}}.$dirty || submitted) && travellerForm.ticket_pcountry_@{{userKey}}_@{{n}}.$error.required">Country is required</span>
                                    </div>
                              </div>
                           
                            </div>

                            </div>

                          </div>

                        </div>

                  </div>

                  <div class="modal fade" id="confirmPassengers" role="dialog">
                                 <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Please verify the name of travellers</h4>
                                       </div>
                                       <div class="modal-body" ng-init="start=0"  >
                                          <div ng-repeat="(uid, userInfo) in user.ticket" >
                                             <div ng-repeat="(udid, udata) in userInfo" class="name" ng-init="current = $parent.$parent.start; $parent.$parent.start = $parent.$parent.start+1;" >@{{udata.title}}. @{{udata.fname}} @{{udata.lname}}</div>
                                          </div>
                                          <div class="confirmation">
                                             <div class="message">Are you sure you want to continue?</div>
                                             <div class="buttons">
                                                <button class="bg-primary" ng-click="submitBookingDetails();" class="yes">Yes</button>
                                                <button type="button" class="no" data-dismiss="modal">No</button>
                                             </div>
                                            </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                  <div class="add-gst">
                     <div class="add-inner">
                        <div class="icon-div"><i class="fas fa-file-invoice"></i></div>
                        <div class="add-txt">
                           <h4>Add your GST Details <span ng-if="!isGstMandatory" >(Optional)</span></h4>
                           <p>Claim credit of GST charges. Your taxes may get updated post submitting your GST details.</p>
                        </div>
                        <div class="add-btn">
                           <!-- <a href="#" class="show_hide"></a> -->
                           <div class="toggle" ng-class="{'expanded': isGstMandatory}" >
                              <p>Show</p>
                           </div>
                        </div>
                     </div>
                     <div class="content" ng-class="{'hide': !isGstMandatory}" >
                        <form  >
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="gst-form">
                                    <div class="row form-group">
                                       <div class="col-md-5"><label>GST Number:</label></div>
                                       <div class="col-md-7">
                                          <input ng-required='isGstMandatory' name="GSTno" ng-model="user.GSTno" type="text" class="form-control">
                                          <span class="text-danger" ng-show="(travellerForm.GSTno.$dirty || submitted) && travellerForm.GSTno.$error.required">GST Number is required in GST</span>
                                       </div>
                                    </div>
                                    <div class="row form-group">
                                       <div class="col-md-5"><label>Email Id:</label></div>
                                       <div class="col-md-7">
                                          <input ng-required='isGstMandatory' name="companyEmail" ng-model="user.companyEmail" type="text" class="form-control">
                                          <span class="text-danger" ng-show="(travellerForm.companyEmail.$dirty || submitted) && travellerForm.companyEmail.$error.required">Company email is required in GST</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="gst-form">
                                    <div class="row form-group">
                                       <div class="col-md-5"><label>Company Name:</label></div>
                                       <div class="col-md-7">
                                          <input ng-required='isGstMandatory' name="companyName" ng-model="user.companyName" type="text" class="form-control">
                                          <span class="text-danger" ng-show="(travellerForm.companyName.$dirty || submitted) && travellerForm.companyName.$error.required">Company phone is required in GST</span>
                                       </div>
                                    </div>
                                    <div class="row form-group">
                                       <div class="col-md-5"><label>Mobile Number</label></div>
                                       <div class="col-md-7">
                                          <div class="input-group">
                                             <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                   <select ng-model="user.companyMobileCode" >
                                                      <option>91</option>
                                                   </select>
                                                </div>
                                             </div>
                                             <input ng-required='isGstMandatory' name="companyMobile" ng-model="user.companyMobile" type="text" placeholder="Mobile No" class="form-control">
                                             <span class="text-danger" ng-show="(travellerForm.companyMobile.$dirty || submitted) && travellerForm.companyMobile.$error.required">Company phone is required in GST</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="gst-form">
                                    <div class="row form-group">
                                       <div class="col-md-5"><label>Address:</label></div>
                                       <div class="col-md-7">
                                          <input ng-required='isGstMandatory' name="companyAddress" ng-model="user.companyAddress" type="text" class="form-control">
                                          <span class="text-danger" ng-show="(travellerForm.companyAddress.$dirty || submitted) && travellerForm.companyAddress.$error.required">Address required in GST</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!--<div class="col-md-12 text-right"><button class="gst-btn">Add GST</button></div>-->
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="booking-div" style = "display:none">
                     <div class="box-title"><i class="fas fa-plus-circle"></i>  Service Requests <span>(Optional)</span></div>
                  </div>
                  <div class="service-div" style = "display:none">
                     <div class="row">
                        <div class="col-md-12" >
                           <a class="add-meal"><i class="fas fa-plus"></i> Add Meal</a> 
                           <a class="add-baggage"><i class="fas fa-plus"></i> Add Baggage</button> 
                           <a class="select-seat"><i class="fas fa-plus"></i> Select Seats</a>
                           <div class="meal-add">
                              <h3>Select Meal Preferences</h3>
                                 <div class="row">
                                     <div class="col-md-4" ng-repeat="(fqid, fq) in responseData.getSSR" ng-if='responseData.getSSR[fqid].Response.MealDynamic' >
                                       <span class="trip-title" ng-if="fqid==0" >Departure</span>
                                       <span class="trip-title" ng-if="fqid==1" >Return</span>
                                       <p>@{{responseData.getSSR[fqid].Response.MealDynamic[0][0].Origin}} <i class="fas fa-long-arrow-alt-right"></i> @{{responseData.getSSR[fqid].Response.MealDynamic[0][0].Destination}}</p>
                                       <section  ng-repeat="(userKey, userTypes) in responseData.fareQuote[0].Response.Results.FareBreakdown" >
                                          <section  class="mealSection" ng-repeat="n in [] | range:userTypes.PassengerCount"  >
                                             <label ng-if="userTypes.PassengerType===1" >Adult @{{n+1}}</label>
                                             <label ng-if="userTypes.PassengerType===2" >Child @{{n+1}}</label>
                                             <select ng-model="flightssr.Passenger[userKey].Meal[fqid]" ng-if="userTypes.PassengerType!==3" class="form-control">
                                                <option  ng-repeat="(mid, meal) in responseData.getSSR[fqid].Response.MealDynamic[0]" ng-if="responseData.getSSR[fqid].Response.MealDynamic"  value="@{{meal.Code}}" >@{{meal.AirlineDescription}}  (@{{priceDisplay(meal.Price)}})</option>
                                             </select>
                                          <section>
                                       </section>
                                    </div>
                               </div>
                           </div>

                           <div class="baggage-add">
                              <h3>Buy extra baggage allowance</h3>
                                <div class="row">
                                  <div class="col-md-4" ng-repeat="(fqid, fq) in responseData.getSSR" ng-if="responseData.getSSR[fqid].Response.Baggage" >
                                       <span class="trip-title" ng-if="fqid==0" >Departure</span>
                                       <span class="trip-title" ng-if="fqid==1" >Return</span>
                                       <p>@{{responseData.getSSR[fqid].Response.Baggage[0][0].Origin}} <i class="fas fa-long-arrow-alt-right"></i> @{{responseData.getSSR[fqid].Response.Baggage[0][0].Destination}}</p>
                                       <section  ng-repeat="(userKey, userTypes) in responseData.fareQuote[0].Response.Results.FareBreakdown" >
                                          <section class="mealSection" ng-repeat="n in [] | range:userTypes.PassengerCount"  >
                                         
                                             <label ng-if="userTypes.PassengerType===1" >Adult @{{n+1}}</label>
                                             <label ng-if="userTypes.PassengerType===2" >Child @{{n+1}}</label>
                                             <select ng-model="flightssr.Passenger[n].Baggage[fqid]" ng-if="userTypes.PassengerType!==3" class="form-control baggages" >
                                                <option  ng-repeat="(bid, baggage) in responseData.getSSR[fqid].Response.Baggage[0]" value="@{{baggage}}" >@{{baggage.Weight}} kg - @{{priceDisplay(baggage.Price)}}</option>
                                              </select>
                                           <section>
                                       </section>
                                  </div>
                               </div>
                           </div>

                           <div  class="seat-div">
                           <h3>Select seat preferences</h3>
                              <div class="row">
                                 <div class="col-md-4" ng-repeat="(fqid, fq) in responseData.getSSR" ng-if="responseData.getSSR[fqid].Response.SeatDynamic" >
                                       <span class="trip-title" ng-if="fqid==0" >Departure</span>
                                       <span class="trip-title" ng-if="fqid==1" >Return</span>
                                       <p>@{{responseData.getSSR[fqid].Response.SeatDynamic[0].SegmentSeat[0].RowSeats[0].Seats[0].Origin}} <i class="fas fa-long-arrow-alt-right"></i> @{{responseData.getSSR[fqid].Response.SeatDynamic[0].SegmentSeat[0].RowSeats[0].Seats[0].Destination}}</p>
                                       <section  ng-repeat="(userKey, userTypes) in responseData.fareQuote[0].Response.Results.FareBreakdown" >
                                          <section class="mealSection" ng-repeat="n in [] | range:userTypes.PassengerCount"  >
                                             <label ng-if="userTypes.PassengerType===1" >Adult @{{n+1}}</label>
                                             <label ng-if="userTypes.PassengerType===2" >Child @{{n+1}}</label>
                                             <button ng-if="userTypes.PassengerType!==3" data-index="@{{fqid}}" class="seat-select">Select Seat</button>
                                             <input type="hidden" value="" ng-model="flightssr.Seat[fqid].Passenger[userKey]" />
                                          <section>
                                       </section>
                                   </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="proceed">
                     <input class="btn btn-primary"  type="submit" value="Continue To Payment" name="submit"/>
                  </div>
               </div>
               <div class="col-md-3" >
                  <div class="fare-detail">
                     <div class="fare-title row">
                        <div class="col-md-10" >
                           <h4>Fare Details</h4>

                        </div>
                        <div class="col-md-2" >
                         @if( !Auth::guest() && Auth::user()->hasRole('agent'))
                           <md-checkbox class="show-commission" ng-model="showCommission" aria-label="Commission?"></md-checkbox>
                         @endif
                        </div>
                     </div>
                     <div class="fare-content">
                        <div class="row">
                           <div class="col-8" id="flip">
                              <div class="base">
                                 <p>Base Fare <span>(@{{totalPassengerCount}} Traveller)</span> <i class="fas fa-chevron-down"></i></p>
                              </div>
                           </div>
                           <div class="col-4">
                              <div class="base-fare">
                                 <p>@{{ priceDisplay(priceDetails.TotalBaseFare)}}</p>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="hidden-content">
                                 <div class="row" ng-repeat="(pKey, allPrices) in responseData.fareQuote[0].Response.Results.FareBreakdown" >
                                    <div class="col-8">
                                       <div class="base">
                                          <p ng-if="allPrices.PassengerType==1" >Adult   x @{{allPrices.PassengerCount}}</p>
                                          <p ng-if="allPrices.PassengerType==2" >Child   x @{{allPrices.PassengerCount}}</p>
                                          <p ng-if="allPrices.PassengerType==3" >Infant   x @{{allPrices.PassengerCount}}</p>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="base-fare">
                                          <p ng-if="responseData.fareQuote.length>1" >@{{ priceDisplay(responseData.fareQuote[0].Response.Results.FareBreakdown[pKey].BaseFare + responseData.fareQuote[1].Response.Results.FareBreakdown[pKey].BaseFare)}}</p>
                                          <p ng-if="responseData.fareQuote.length==1" >@{{ priceDisplay(allPrices.BaseFare)}}</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-8" id="flip1">
                              <div class="base">
                                 <p>Fee &amp; Surcharges <i class="fas fa-chevron-down"></i></p>
                              </div>
                           </div>
                           <div class="col-4">
                              <div class="base-fare">
                                 <p >@{{ priceDisplay(priceDetails.TotalFeeAndSurcharges+priceDetails.serviceCharges+priceDetails.totalGST)}}</p>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="hidden-content1">

                                 <div class="row">
                                    <div class="col-8">
                                       <div class="base">
                                          <p>Airline Fuel Surcharges</p>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="base-fare">
                                          <p>@{{priceDisplay(priceDetails.AirLineCharges)}}</p>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-8">
                                       <div class="base">
                                          <p>Tax</p>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="base-fare">
                                       <p>@{{priceDisplay(priceDetails.Taxes)}}</p>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-8">
                                       <div class="base">
                                          <p>Other Charges</p>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="base-fare">
                                       <p>@{{priceDisplay(priceDetails.OtherCharges)}}</p>
                                       </div>
                                    </div>
                                 </div>

                                 
                                 <div class="row">
                                    <div class="col-8">
                                       <div class="base">
                                          <p>Service Charge</p>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="base-fare">
                                       <p>@{{priceDisplay(priceDetails.serviceCharges)}}</p>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-8">
                                       <div class="base">
                                          <p>GST</p>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <div class="base-fare">
                                       <p>@{{priceDisplay(priceDetails.totalGST)}}</p>
                                       </div>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                        <div class = "row" id = "bag">
                          
                       
                        </div>
                        <div class="row total-pay">
                           <div class="col-md-12">
                              <div class="amount-toal">
                                 <div class="row">
                                    <div class="col-7" id="flip1">
                                       <div class="base">
                                          <p>Total Fare:</p>
                                       </div>
                                    </div>
                                    <div class="col-5 text-right">
                                       <div class="base-fare">
                                          <p id = "hidenpay" style = "display:none">@{{priceDisplay(priceDetails.serviceCharges+priceDetails.GrandTotal+priceDetails.totalGST)}}</p>
                                          <p class = "Totalpay">@{{priceDisplay(priceDetails.serviceCharges+priceDetails.GrandTotal+priceDetails.totalGST)}}</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                     
                     <div class="total-fare">
                        <div class="you-pay">
                           <p>You Pay :</p>
                        </div>
                        <div class="total-amount">
                           <p class = "Totalpay"> @{{ priceDisplay(priceDetails.serviceCharges+priceDetails.GrandTotal+priceDetails.totalGST)}}</p>
                        </div>
                     </div>


                     <div style="display:none" class="mt-2 commission-area" ng-if="priceDetails.totalCommission!==0 " >
                        <div class="row"  >
                           <div class="col-7" >
                              <div class="base">
                                 <p>Total Commission(-):</p>
                              </div>
                           </div>
                           <div class="col-5 text-right">
                              <div class="base-fare">
                                 <p>@{{ priceDisplay(priceDetails.totalCommission)}}</p>
                              </div>
                           </div>
                        </div>

                        <div class="row"  >
                           <div class="col-7" >
                              <div class="base">
                                 <p>TDS(+):</p>
                              </div>
                           </div>
                           <div class="col-5 text-right">
                              <div class="base-fare">
                                 <p>@{{ priceDisplay(priceDetails.TDS)}}</p>
                              </div>
                           </div>
                        </div>

                        <div class="row" >
                           <div class="col-7" >
                              <div class="base">
                                 <p>Payable Amount:</p>
                              </div>
                           </div>
                           <div class="col-5 text-right">
                              <div class="base-fare">
                                 <p>@{{ priceDisplay(priceDetails.serviceCharges+priceDetails.GrandTotal+priceDetails.totalGST-priceDetails.totalCommission+priceDetails.TDS)}}</p>
                              </div>
                           </div>
                        </div>
                  </div>

                  </div>
               </div>
              </div>
              </form>
            </div>

            <div class="row" ng-if="hasError !== 0" >
                  @include('../apierror')
            </div>
         </div>
      </section>
   </div>
   <div  ng-repeat="(fqid, fq) in responseData.fareQuote" ng-if="responseData.getSSR[fqid].Response.SeatDynamic" class="overlay overlay_@{{fqid}}" >
      <div class="seatside-panel seatside_panel_@{{fqid}}" >
         <a href="" data-index="@{{fqid}}" class="dismiss-menu"><i class="fas fa-times"></i></a>
         <div class="select-seat-title">
            <h4>Seat Map - Select your seats</h4>
         </div>
         <div class="seat-layout">
            <div class="seat-layout-inner">
               <div class="seat-layout-left">
                  <div class="departure-info">
                     <div class="depart">
                        departure
                     </div>
                     <!--depart close-->
                     <div class="city-code-holder">
                        <span class="city-code"> DEL </span>
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <span class="city-code">PAT</span>
                        <span class="seprator">|</span>
                        <span class="reach-day">Tue, 5 Mar 2019</span>
                     </div>
                  </div>
                  <div class="seating-area">
                     <div class="front">
                        <span class="portion">Front</span>
                        <ul class="column">
                           <li  class="seat-li">
                              F
                           </li>
                           <li class="seat-li">
                              E
                           </li>
                           <li class="seat-li">
                              D
                           </li>
                           <li></li>
                           <li class="seat-li">
                              C
                           </li>
                           <li class="seat-li">
                              B
                           </li>
                           <li class="seat-li">
                              A
                           </li>
                        </ul>
                     </div>
                     <div class="back">
                        <span class="portion">Back</span>
                     </div>
                     <div class="seating-areainner">
                        <div class="wing-left">
                           <span>seat over wing</span>
                        </div>
                        <div class="floor">
                           <div class="seats-layoutinner">
                              <ul class="column" ng-repeat="(rid, seatRows) in responseData.getSSR[fqid].Response.SeatDynamic[0].SegmentSeat[0].RowSeats" ng-if="rid>0" >
                                 <li class="seat-li right">@{{rid}}</li>   
                                 <li ng-if="sid<3" ng-repeat="(sid, seat) in seatRows.Seats" id="@{{seat.Code}}" ng-class="seat.AvailablityType===1?'booked':(seat.AvailablityType===3?'paid':'free')" ng-click="markselected(seat.AvailablityType)" class="seat-li booked">@{{seat.Code}}</li>
                                 <li class="seat-li" ></li>
                                 <li ng-if="sid>2" ng-repeat="(sid, seat) in seatRows.Seats" id="@{{seat.Code}}" ng-class="seat.AvailablityType===1?'booked':(seat.AvailablityType===3?'paid':'free')" ng-click="markselected(seat.AvailablityType)" class="seat-li booked">@{{seat.Code}}</li>
                                 <li class="seat-li left">@{{rid}}</li>
                              </ul>
                              
                           </div>
                        </div>
                        <div class="wing-right" >
                           <span></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="seat-layout-right">
                  <div class="btn-section">
                     <button class="deck-select">Maindeck</button>
                  </div>
                  <div class="seat-type">
                     <ul class="legends ng-binding">
                        <li><span class="seat-li"></span> <span>Available Seat(44)</span></li>
                        <li><span class="seat-li booked"></span> <span>Occupied Seat(94)</span></li>
                        <li><span class="seat-li selected"></span> <span>Selected Seat(0)</span></li>
                        <li><span class="seat-li comfort"></span> <span>Pay for extra comfort(0)</span></li>
                        <li><span class="seat-li lavatory"></span> <span>Lavatory</span></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="proceed">
               <a href="#">Confirm</a>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('footer_scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      $('#confirm').modal({backdrop: 'static', keyboard: false});
    });
   </script>
@endsection
