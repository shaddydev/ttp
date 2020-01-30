@extends('layouts.app')
@section('content')
<div ng-controller="flightsController">
<div class="preloader" ng-if="searchResponse === 0" >
 <img class="absolute-image" src="/public/images/loader.gif">
</div>
<section class="filter-area">
   <div class="container-fluid">
      <div class="row no-gutters">
         <div class="col-lg-3 bg-grey">
            <div class="sidebar-ad" >
               <div class="search-filter">
                  <h2 class="full filter-head">
                     <span class="fl">Filter</span>
                     <span class="filter-close" ><i class="fas fa-times-circle"></i></span>
                  </h2>
                  <div class="refine">
                     <h3>Refine Results</h3>
                  </div>
                  <div class="full-fiter">
                     <div class="stops">
                        <p>No. of Stops</p>
                        <ul ng-if="searchResponse === 1 && hasError === 0" >
                           <li ng-repeat="(key, flight) in flights.Response.Results[0] | unique:'Segments[0].length' "  >
                              <label for="stop@{{key}}" class="stop-number"><span><strong>@{{flight.Segments[0].length-1}}</strong> stop</span></label>
                              <input type="checkbox" data-ng-change="filterFlights('Stops')" name="Stop[]" data-ng-model="Filter.Stops[flight.Segments[0].length-1]"  id="stop@{{key}}" class="tpStop">
                              <span class="text-nowrap">@{{priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst)}}</span>
                           </li>
                        </ul>
                     </div>
                     <div class="time">
                        <p>Departure time</p>
                        <ul ng-if="searchResponse === 1 && hasError === 0 " >
                           <li class="timeslot_li">
                              <label for="early_morning"   class="timeSlot" >
                              <span>
                              <span class="morning-icon"></span>
                              </span>
                              <span class="d-time">00-06</span>
                              </label>
                              <input class="tpTimeSlot" id="early_morning" type="checkbox" data-ng-change="filterFlights('TimeSlot')" name="Timeslot[]" data-ng-model="Filter.TimeSlot['early_morning']"  />
                           </li>
                           <li class="timeslot_li">
                              <label for="morning" class="timeSlot">
                              <span>
                              <span class="sun-icon"></span>
                              </span>
                              <span class="d-time">06-12</span>
                              </label>
                              <input class="tpTimeSlot" id="morning" type="checkbox" data-ng-change="filterFlights('TimeSlot')" name="Timeslot[]" data-ng-model="Filter.TimeSlot['morning']"  />
                           </li>
                           <li class="timeslot_li">
                              <label for="afternoon" class="timeSlot" >
                              <span>
                              <span class="evening-icon"></span>
                              </span>
                              <span class="d-time">12-18</span>
                              </label>
                              <input class="tpTimeSlot" id="afternoon" type="checkbox" data-ng-change="filterFlights('TimeSlot')" name="Timeslot[]" data-ng-model="Filter.TimeSlot['afternoon']"  />
                           </li>
                           <li class="timeslot_li">
                              <label for="night" class="timeSlot">
                              <span>
                              <span class="moon-icon"></span>
                              </span>
                              <span class="d-time">18-00</span>
                              </label>
                              <input id="night" class="tpTimeSlot" type="checkbox" data-ng-change="filterFlights('TimeSlot')" name="Timeslot[]" data-ng-model="Filter.TimeSlot['night']"  />
                           </li>
                        </ul>
                     </div>
                     <div class="price">
                        <p>Fare Price</p>
                        <div ng-if="searchResponse === 1 && hasError === 0 " class="rangeBlock">
                           <div class="rangeInput">
                             <rzslider rz-slider-model="priceSlider.min" rz-slider-high="priceSlider.max" rz-slider-options="priceSlider.options"></rzslider>
                           </div>
                        </div>
                     </div>
                     <div class="airlines">
                        <p>Airlines</p>
                        <div class="all-airlines" ng-if="searchResponse === 1 && hasError === 0 " >
                           <div ng-repeat="(key, flight) in flights.Response.Results[0] | unique:'Segments[0][0].Airline.AirlineName' "  class="custom-control custom-checkbox" >
                              <div class="d-flex">
                                 <input type="checkbox" data-ng-change="filterFlights('AirlineCode')" value="@{{flight.Segments[0][0].Airline.AirlineCode}}"  data-ng-model='Filter.AirlineCode[flight.Segments[0][0].Airline.AirlineCode]' class="custom-control-input" id="flight_@{{key}}">
                                 <label class="custom-control-label" for="flight_@{{key}}">
                                    <div class="d-flex">
                                       <div class="labelImg airlines-list">
                                          <img src="/public/images/airlines/@{{flight.Segments[0][0].Airline.AirlineCode}}.gif">
                                       </div>
                                       <div>
                                          <div class="airline-name" >@{{flight.Segments[0][0].Airline.AirlineName}}</div>
                                          <p>@{{priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst)}}</p>
                                       </div>
                                    </div>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-9">
            <!-- <img ng-if="searchResponse === 0" class="no-data" src="/public/images/no-data.png"> -->
            <div ng-if="flights.Response.Error.ErrorCode === 0" >
               <div class="top-section">
                  <div class="d-flex justify-content-between">
                     <div class="left-div">
                        <p>Found @{{flights.Response.Results[0].length}} Flights</p>
                        <!-- <p><small>IN 2.46 SECONDS</small></p> -->
                     </div>
                     <div class="center-div">
                        <ul>
                           <li>
                              <p>{{$postData['start']}}</p>
                              <p><small>@{{dateFormattext(postData.date_up)}}</small></p>
                              <i class="fas fa-long-arrow-alt-right"></i>
                           </li>
                           <li>
                              <p>{{$postData['end']}}</p>
                           </li>
                        </ul>
                     </div>
                     <div class="right-div">
                        <a href="#" data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i> <span class="modify-search">Modify Search</span></a>
                        <button class="filter-btn"><i class="fas fa-filter"></i></button>
                        @if( !Auth::guest() && Auth::user()->hasRole('agent'))
                         <md-checkbox class="show-commission" ng-model="showCommission" aria-label="Commission?"></md-checkbox>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog modal-lg">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Modify Search</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <form action="{{url('flights')}}" method="get">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="trip-radio" id = "trip">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input" id="oneway" name="triptype" checked value = "oneway">
                                          <label class="custom-control-label" for="oneway">One Way</label>
                                       </div>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input" id="roundtrip" name="triptype"  value = "roundtrip">
                                          <label class="custom-control-label" for="roundtrip">Round Trip</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3 form-group">
                                    <input type="text"  id = "origin" name = "start" value="{{$postData['start']}}" class="airport_list_up form-control">
                                    <div id = "res"></div>
                                    <input type = "hidden" name="origin" value="{{$postData['origin']}}" >
                                    <input type = "hidden" name = "oct" value = "{{$postData['oct']}}"> 
                                 </div>
                                 <div class="col-md-3 form-group">
                                    <input type="text" id = "destination" name = "end" placeholder="Enter destination" class="airport_list_down form-control"  value="{{$postData['end']}}">
                                    <input type = "hidden" name="destination"  value="{{$postData['destination']}}">
                                    <input type = "hidden" name = "dct" value = "{{$postData['dct']}}">
                                 </div>
                                 <div class="col-md-3 form-group">
                                    <div class="input-group" id = "date_up">
                                      <input type ="text" class="dateHidden form-control" name = "date_up" value="{{$postData['date_up']}}" id = "depart_date"/>
                                      <a href="javascript:void(0);" id="modelchooseDateBtn" class="prodDetBtngreen activegreen"><i class="far fa-calendar-alt"></i></a>
                                      <div class="choosedatepicker">
                                          <div id="modeldepartdate" style="display:none;"></div>
                                       </div>
                                       
                                    </div>
                                 </div>
                                 <div class="col-md-3 form-group" style = "display:{{$postData['date_down'] != '' ? 'block' : 'none'}}" id = "roundtripdate">
                                    <div class="input-group" id = "date_down">
                                    <input type ="text" class="dateHidden form-control" name = "date_down" value="{{$postData['date_down']}}"  id = "return_date" />
                                    <!-- <span>error</span>   -->
                                    <a href="javascript:void(0);" id="modelchooseDateBtn1" class="prodDetBtngreen activegreen"><i class="far fa-calendar-alt"></i></a>
                                      <div class="choosedatepicker">
                                          <div id="modelreturndate" style="display:none;"></div>
                                       </div>
                                    </div>
                                    <span style = "color:red ; display:none" id = "reuiredmsg" >Required</span>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-4 form-group">
                                    <div class="value-inc">
                                       <span class="minus" id="modeladult_minus">-</span>
                                       <span class="inputblock"><input name="adult" id="modeladult_count" type="text" value="{{$postData['adult']}}"> Adult</span>
                                       <span class="plus" id="modeladult_plus">+</span>
                                    </div>
                                 </div>
                                 <div class="col-md-4 form-group">
                                    <div class="value-inc">
                                       <span class="minus" id="modelchild_minus">-</span>
                                       <span class="inputblock"><input name="child" id="modelchild_count" type="text" value="0"/> Child</span>
                                       <span class="plus" id="modelchild_plus">+</span>
                                    </div>
                                 </div>
                                 <div class="col-md-4 form-group">
                                    <div class="value-inc"><span class="minus" id="modelinfant_minus">-</span>
                                       <span class="inputblock"><input name="infant" id="modelinfant_count" type="text" value="0"/> Infant<br />(below 2 years)</span>
                                       <span class="plus" id="modelinfant_plus">+</span>
                                    </div>
                                 </div>
                              </div>
                       
                        <span id = "modelmsgbox" style = "color:red"></span>
                        <div class="row">
                           <div class="col-md-4 form-group">
                              <select class="form-control" name = "cabin_class">
                                 <option value = "2">Economy</option>
                                 <option value = "3">Premium Economy</option>
                                 <option value = "4">Business</option>
                              </select>
                           </div>
                           <div class="col-md-4 form-group">
                              <select class="form-control"  >
                                 <option ng-repeat="(key, flight) in flights.Response.Results[0] |unique:'Segments[0][0].Airline.AirlineName' ">@{{flight.Segments[0][0].Airline.AirlineName}}</option>
                              </select>
                           </div>
                           <div class="col-md-4 form-group">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="nonStop">
                                 <label class="custom-control-label" for="nonStop">Non Stop Flight</label>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                        <div class="col-md-12">
                        <div class="flight-Bbtn"><button class="form-control modify">modify search</button></div>
                        </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="flight-list">
               <div class="slider-section">
                  <div class="monthSlide">
                     <div class="owl-carousel" id="monthSlider">
                        <div ng-click="calenderSearch(dateFormatInput(calender_item.DepartureDate.trim()))" class="monthItem" ng-repeat="(key, calender_item) in calenderFare.Response.SearchResults" >
                           <p class="month-label">
                              @{{dateFormatdateMonth(calender_item.DepartureDate.trim())}}
                           </p>
                           <p class="month-price">
                               @{{priceDisplay(calender_item.BaseFare+calender_item.FuelSurcharge+calender_item.OtherCharges+calender_item.Tax)}}
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class=" calender text-center">
                     <img src="/public/images/calender.svg">
                     <p>Fare Calander</p>
                  </div>
                  
               </div>
            </div>
            <div class="flight-head">
               <div  title="Sort by Airline" ng-click="setOrderProperty('Segments[0][0].Airline.AirlineName')" class="flight-title">Airline</div>
               <div class="flight-rest">
                  <div  title="Sort by Departure"  ng-click="setOrderProperty('Segments[0][0].Origin.DepTime')" class="flight-depart">Departure</div>
                  <div title="Sort by Arrival" ng-click="setOrderProperty('Segments[0][0].Destination.ArrTime')" class="flight-ariv">Arrival</div>
                  <div title="Sort by Duration" ng-click="setOrderProperty('Segments[0][0].Duration')" class="flight-dur">Duration</div>
                  <div title="Sort by Price" ng-click="setOrderProperty('Fare.PublishedFare')" class="flight-price">Price</div>
                  <div title="Sort by Airline" ng-click="setOrderProperty('AirlineName')" class="flight-btn"></div>
               </div>
            </div>
            <div class="flight-body" >
               <div ng-repeat="(key, flight) in flights.Response.Results[0] | orderBy:orderProperty | filter: filterFunction"  class="flight-body-main" >
                  <div class="flight-inner">
                     <div class="flight-Btitle">
                        <div class="flight-logo">
                           <img src="/public/images/airlines/@{{flight.Segments[0][0].Airline.AirlineCode}}.gif">
                        </div>
                        <div>
                           <p class="flight-name">@{{flight.Segments[0][0].Airline.AirlineName}}</p>
                           <p class="flight-price1">@{{flight.Segments[0][0].Airline.AirlineCode}} @{{flight.Segments[0][0].Airline.FlightNumber}} (@{{flight.Segments[0][0].Airline.FareClass}})
                           </p>
                         </div>
                         </div>
                     <div class="flight-rest">
                        <div class="flight-Bdepart">@{{flight.Segments[0][0].Origin.DepTime.substr(11,5)}}</div>
                        <div ng-if="flight.Segments[0].length===1" class="flight-Bariv">@{{flight.Segments[0][0].Destination.ArrTime.substr(11,5)}}</div>
                        <div ng-if="flight.Segments[0].length>1" class="flight-Bariv">@{{flight.Segments[0][flight.Segments[0].length-1].Destination.ArrTime.substr(11,5)}}</div>
                        <div class="flight-Bdur">
                           <p ng-if="flight.Segments[0].length === 1" >@{{ timeFormatText(flight.Segments[0][0].Duration)}}</p>
                           <p ng-if="flight.Segments[0].length > 1" >@{{ timeFormatText(flight.Segments[0][flight.Segments[0].length-1].AccumulatedDuration - flight.Segments[0][flight.Segments[0].length-1].GroundTime )}}</p>
                           <?php $value="{{flight.Segments[0][0].Airline.AirlineCode}}";?>
                           <img src="/public/images/long-arrow.png">
                           <p ng-if="flight.Segments[0].length === 1" >Non-stop</p>
                           <p ng-if="flight.Segments[0].length > 1" >@{{flight.Segments[0].length-1}} stop</p>
                        </div>
                        
                        <div data-toggle="tooltip" data-trigger="click" data-html="true" title="" class="flight-Bprice new">@{{priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst)}}

                        <div class="tooltip-content" >
                        
                           <table class="table table-condensed" width="100%" cellspacing="0" cellpadding="0" style="position:relative;">
                                 <thead>
                                    <tr>
                                       <th>
                                          <strong>Fare Summary</strong>
                                       </th>
                                       <th ng-repeat="(pKey, allPrices) in flight.FareBreakdown" ><strong><span ng-if="allPrices.PassengerType==1">ADTx@{{allPrices.PassengerCount}}</span>
                                          <span ng-if="allPrices.PassengerType==2">CHDx@{{allPrices.PassengerCount}}</span>
                                          <span ng-if="allPrices.PassengerType==3">INFx@{{allPrices.PassengerCount}}</span>
                                          </strong>
                                       </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td > Base Fare </td>
                                       <td ng-repeat="(pKey, allPrices) in flight.FareBreakdown" >@{{ priceDisplay(allPrices.BaseFare)}}</td>
                                    </tr>
                                    <tr >
                                       <td> Airline Fuel Surcharges </td>
                                       <td ng-repeat="(pKey, allPrices) in flight.FareBreakdown" >@{{ priceDisplay(allPrices.YQTax)}}</td>
                                    </tr>
                                    <tr >
                                       <td> Tax </td>
                                       <td ng-repeat="(pKey, allPrices) in flight.FareBreakdown" >@{{ priceDisplay(allPrices.Tax-allPrices.YQTax)}}</td>
                                    </tr>
                                    <tr >
                                       <td colspan="@{{flight.FareBreakdown.length}}" > Other Charges </td>
                                       <td colspan="@{{flight.FareBreakdown.length}}" >@{{priceDisplay(flight.Fare.OtherCharges)}}</td>
                                    </tr>
                                    <tr >
                                       <td colspan="@{{flight.FareBreakdown.length}}" > Service Charges </td>
                                       <td colspan="@{{flight.FareBreakdown.length}}" >@{{priceDisplay(service_charge)}}</td>
                                    </tr>
                                    <tr>
                                       <td colspan="@{{flight.FareBreakdown.length}}" >GST</td>
                                       <td colspan="@{{flight.FareBreakdown.length}}" >@{{priceDisplay(service_charge_gst)}}</td>
                                    </tr>
                                    <tr>
                                       <td colspan="@{{flight.FareBreakdown.length}}" ><strong>Total</strong></td>
                                       <td colspan="@{{flight.FareBreakdown.length}}" ><strong>@{{ priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst)}}</strong></td>
                                    </tr>
                              
                              
                                    <tr style="display:none" class="commission-area"  ng-repeat="(cid, commission) in package_commission" ng-if="commission.code == flight.Segments[0][0].Airline.AirlineCode" >
                                       <td style="border: none;" colspan="@{{flight.FareBreakdown.length+2}}" >
                                       <table class="commission-tooltip" >
                                          <tr ng-if="commission.fare_type == 2 " >
                                             <td colspan="@{{flight.FareBreakdown.length}}" >Commission(-) :</td>
                                             <td colspan="@{{flight.FareBreakdown.length}}" >
                                             @{{ priceDisplay(calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission))  }}</td>
                                          </tr>
                                          <tr ng-if="commission.fare_type == 2 " >
                                             <td colspan="@{{flight.FareBreakdown.length}}" >TDS(+) :</td>
                                             <td colspan="@{{flight.FareBreakdown.length}}" >
                                             @{{ priceDisplay(calculateTDS(calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission)))  }}</td>
                                          </tr>
                                          <tr ng-if="commission.fare_type == 2 "  >
                                             <td colspan="@{{flight.FareBreakdown.length}}" >Payable Amount :</td>
                                             <td colspan="@{{flight.FareBreakdown.length}}" >
                                             @{{ priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst - calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission)+ calculateTDS(calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission)) )  }}
                                             </td>
                                          </tr>
                                          
                                          <tr ng-if="commission.fare_type == 1 " >
                                          <td>Commission(-) :</td>
                                             <td colspan="@{{flight.FareBreakdown.length}}" >
                                             @{{ priceDisplay(calculateCommission(flight.Fare.BaseFare,commission.commission)) }}</td>
                                          </tr>

                                          <tr ng-if="commission.fare_type == 1 " >
                                             <td colspan="@{{flight.FareBreakdown.length}}" >TDS(+) :</td>
                                             <td colspan="@{{flight.FareBreakdown.length}}" >
                                             @{{ priceDisplay(calculateTDS(calculateCommission(flight.Fare.BaseFare,commission.commission)))  }}</td>
                                          </tr>

                                          <tr ng-if="commission.fare_type == 1 " >
                                          <td colspan="@{{flight.FareBreakdown.length}}" >Payable Amount :</td>
                                             <td colspan="@{{flight.FareBreakdown.length}}" >
                                             @{{ priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst - calculateCommission(flight.Fare.BaseFare,commission.commission)+ calculateTDS(calculateCommission(flight.Fare.BaseFare,commission.commission)) ) }}</td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                                 </tbody>
                           </table>
                           <hint>Note : Total fare displayed above has been rounded off and may thus show a slight difference</hint>
                        </div>

                        <div style="display:none" class="commission-area" ng-repeat="(cid, commission) in package_commission" >
                            
                               <span ng-if="commission.code == flight.Segments[0][0].Airline.AirlineCode" >
                                 <span ng-if="commission.fare_type == 2 " >
                                       @{{ 
                                        priceDisplay(calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission))
                                       }} | 

                                       @{{ priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst - calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission) + calculateTDS(calculateCommission(flight.Fare.BaseFare+flight.Fare.YQTax,commission.commission)) ) }} 

                                 </span>
                                 <span ng-if="commission.fare_type == 1 " >

                                      @{{ 
                                        priceDisplay(calculateCommission(flight.Fare.BaseFare,commission.commission))
                                       }} | 

                                       @{{ priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst - calculateCommission(flight.Fare.BaseFare,commission.commission) + calculateTDS(calculateCommission(flight.Fare.BaseFare,commission.commission)) ) }} 
                                 </span>
                               </span>
                        </div>

                        </div>
                        <br>
                        <span></span>
                        <div class="flight-Bbtn">
                           <a href="javascript:void(0);" ng-click="bookNow(flight.ResultIndex);" >Book Now</a>
                           <div class="mt-2" >@{{flight.Segments[0][0].NoOfSeatAvailable}} seats left </div>
                        </div>
                     </div>
                  </div>
                  <div class="flight-footer">
                     <div class="float-right"><a href="#" >@{{remarkDisplay(flight.AirlineRemark)}}</a></div>
                     <div class="flight-details float-left"><a href="#" data-resultindex = "@{{flight.ResultIndex}}" data-toggle="modal" class = "farequotes" data-target="#flightDetail_@{{key}}" >Flight Detail</a></div>
                  </div>
                  <div class="modal fade" id="flightDetail_@{{key}}" role="dialog" style="display: none;" aria-hidden="true">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title">Flight Details</h4>
                              <button type="button" class="close" data-dismiss="modal">×</button>
                           </div>
                           <div class="modal-body">
                              <div class="modal-top">
                                 <div class="center-div">
                                    <ul>
                                       <li>
                                          <p>@{{flights.Response.Origin}}</p>
                                          <i class="fas fa-long-arrow-alt-right"></i>
                                       </li>
                                       <li>
                                          <p>@{{flights.Response.Destination}}</p>
                                       </li>
                                    </ul>
                                    <span class="schedule">@{{dateFormattext(postData.date_up)}} |
                                        <duration ng-if="flight.Segments[0].length === 1" >@{{ timeFormatText(flight.Segments[0][0].Duration)}}</duration>
                                        <duration ng-if="flight.Segments[0].length > 1" >@{{ timeFormatText(flight.Segments[0][flight.Segments[0].length-1].AccumulatedDuration - flight.Segments[0][flight.Segments[0].length-1].GroundTime )}}
                                        </duration>
                                         | 
                                    <span class="non-stop" ng-if="flight.Segments[0].length === 1" >Non-stop</span>
                                    <span class="non-stop" ng-if="flight.Segments[0].length > 1" >@{{flight.Segments[0].length-1}} stop</span>
                                    </span>
                                 </div>
                                 <div class="right-div">
                                    <div class="flight-price">
                                       <p>@{{priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst)}}</p>
                                    </div>
                                    <div class="flight-Bbtn"><a  ng-click="bookNow(flight.ResultIndex);" href="javascript:void(0);">Book Now</a></div>
                                 </div>
                              </div>
                              <div class="modal-tabs">
                                 <ul class="nav nav-tabs">
                                    <li><a data-toggle="tab" href="#basic_@{{key}}" class="active">Itinerary</a></li>
                                    <li><a data-toggle="tab" href="#detailed_@{{key}}">Fare SUMMARY & RuleS </a></li>
                                 </ul>
                                 <div class="tab-content">
                                    <div id="basic_@{{key}}" class="tab-pane fade in active">
                                       <div ng-repeat="(seg_key, segment) in flight.Segments[0]" class="sector-detail">
                                          <div class="row">
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
                                                   <p class="small-txt">@{{segment.Airline.AirlineCode}}-@{{segment.Airline.FlightNumber}} (@{{segment.Airline.FareClass}})</p>
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
                                                         <span class="gray-light">@{{segment.Origin.Airport.AirportName}}<span>, T-@{{segment.Origin.Airport.Terminal}}</span></span>
                                                      </div>
                                                   </div>
                                                   <div class="col-6 col-md-3">
                                                      <div class="to-place">
                                                         <p>@{{segment.Destination.Airport.CityName}}, @{{segment.Destination.Airport.CountryCode}}</p>
                                                         <h3>@{{segment.Destination.ArrTime.substr(11,5)}}</h3>
                                                         <p class="bold"></p>
                                                         <span class="gray-light">@{{segment.Destination.Airport.AirportName}}<span>, T-@{{segment.Destination.Airport.Terminal}}</span></span>
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
                                                         <span ng-if="flight.IsRefundable===true" class="text-success" >Partially Refundable</span>
                                                         <span ng-if="flight.IsRefundable===false" class="text-danger" >Non-Refundable</span>
                                                      </p>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <hr>
                                       </div>
                                    </div>
                                    <div id="detailed_@{{key}}" class="tab-pane fade">
                                       <!-- <div class="row">
                                          <div class="col-md-6"> -->
                                             <div class="one-fourth">
                                                <div class="insert-content">
                                                   <table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0" style="position:relative;">
                                                      <thead>
                                                         <tr>
                                                            <th>
                                                               <strong>Fare Summary</strong>
                                                            </th>
                                                            <th ng-repeat="(pKey, allPrices) in flight.FareBreakdown" ><strong><span ng-if="allPrices.PassengerType==1">ADTx@{{allPrices.PassengerCount}}</span>
                                                               <span ng-if="allPrices.PassengerType==2">CHDx@{{allPrices.PassengerCount}}</span>
                                                               <span ng-if="allPrices.PassengerType==3">INFx@{{allPrices.PassengerCount}}</span>
                                                               </strong>
                                                            </th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <tr>
                                                            <td > Base Fare </td>
                                                            <td ng-repeat="(pKey, allPrices) in flight.FareBreakdown" >@{{ priceDisplay(allPrices.BaseFare)}}</td>
                                                         </tr>
                                                         <tr >
                                                            <td> Airline Fuel Surcharges </td>
                                                            <td ng-repeat="(pKey, allPrices) in flight.FareBreakdown" >@{{ priceDisplay(allPrices.YQTax)}}</td>
                                                         </tr>
                                                         <tr >
                                                            <td> Tax </td>
                                                            <td ng-repeat="(pKey, allPrices) in flight.FareBreakdown" >@{{ priceDisplay(allPrices.Tax-allPrices.YQTax)}}</td>
                                                         </tr>
                                                         <tr >
                                                            <td colspan="@{{flight.FareBreakdown.length}}" > Other Charges </td>
                                                            <td colspan="@{{flight.FareBreakdown.length}}" >@{{priceDisplay(flight.Fare.OtherCharges)}}</td>
                                                         </tr>
                                                         <tr >
                                                            <td colspan="@{{flight.FareBreakdown.length}}" > Service Charges </td>
                                                            <td colspan="@{{flight.FareBreakdown.length}}" >@{{priceDisplay(service_charge)}}</td>
                                                         </tr>
                                                         <tr >
                                                            <td colspan="@{{flight.FareBreakdown.length}}" >GST</td>
                                                            <td colspan="@{{flight.FareBreakdown.length}}" >@{{priceDisplay(service_charge_gst)}}</td>
                                                         </tr>
                                                         <tr>
                                                            <td colspan="@{{flight.FareBreakdown.length}}" ><strong>Total</strong></td>
                                                            <td colspan="@{{flight.FareBreakdown.length}}" ><strong>@{{ priceDisplay(flight.Fare.PublishedFare+service_charge+service_charge_gst)}}</strong></td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </div>
                                                <p class="ltr-gray mt10 fs-sm">
                                                   <sup>*</sup>Total fare displayed above has been rounded off and may thus show a slight difference.
                                                </p>
                                             </div>
                                          <!-- </div>
                                          <div class="col-md-6"> -->
                                             <div class="insert-content">
                                                <div class="farerule-select">
                                                   <span class="select-rule sort-active">
                                                   @{{flights.Response.Origin}}-@{{flights.Response.Destination}}
                                                   </span>
                                                </div>
                                                <div class="table-responsive fareq">
                                                <div style="vertical-align:middle; text-align:center">
                                                   <img src = "{{url('public/admin/img/LoaderIcon.gif')}}" class = "">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="ltr-gray ">
                                                <span class="asterisk">*</span> Per person per sector.
                                                <br>
                                                <span class="asterisk">**</span>Please note: TravelTripPlus cancellation fee is over and above the airline cancellation fee
                                                due to which refund type
                                                may vary.
                                             </div>
                                          </div>
                                       <!-- </div>
                                 </div> -->
                     </div>
                  <div class="row" ng-if="hasError !== 0" >
             @include('../apierror')
         </div>
</section>
</div>
@endsection
