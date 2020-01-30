		
        @if($flights->Response->Error->ErrorCode===0)
        <section class="filter-area">
				<div class="container-fluid">
					<div class="row no-gutters">
						<div class="col-lg-3 bg-grey">
							<div class="search-filter">
								<h2 class="full filter-head">
								<span class="fl">Filter</span>
								<span class="filter-close" ><i class="fas fa-times-circle"></i></span>
								</h2>
								<div class="refine"><h3>Refine Results</h3></div>
								<div class="full-fiter"> <div class="stops">
									<p>No. of Stops</p>
									<ul>
										<li><a href="#"><span class="stop-number"><b>0</b> stop</span><span>3299/-</span></a></li>
										<li><a href="#"><span class="stop-number"><b>1</b> stop</span><span>2799/-</span></a></li>
										<li><a href="#"><span class="stop-number"><b>2</b> stop</span><span>2299/-</span></a></li>
									</ul>
								</div>
								<div class="time">
									<p>Departure time</p>
									<ul>
										<li><a href="#">
											<span>
												<span class="morning-icon"></span>
											</span>
											<span class="d-time">00-06</span>
										</a></li>
										<li><a href="#">
											<span>
												<span class="sun-icon"></span>
											</span>
											<span class="d-time">06-12</span>
										</a></li>
										<li><a href="#">
											<span>
												<span class="evening-icon"></span>
											</span>
											<span class="d-time">12-18</span>
										</a></li>
										<li><a href="#">
											<span>
												<span class="moon-icon"></span>
											</span>
											<span class="d-time">18-00</span>
										</a></li>
									</ul>
								</div>
								<div class="price">
									<p>Fare Price</p>
									<div class="rangeBlock">
										<div class="rangeInput">
											<input type="text" class="js-input-from" id="minPrice" value="0" readonly="">
											<!-- <span>-</span> -->
											<input type="text" class="js-input-to" id="maxPrice" value="0" readonly="">
										</div>
										<div class="range-slider"><span class="irs js-irs-0"><span class="irs"><span class="irs-line" tabindex="-1"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min" style="visibility: hidden;">Rp. 2.499</span><span class="irs-max" style="visibility: hidden;">Rp. 1.000.000</span><span class="irs-from" style="visibility: visible; left: 0%;">Rp. 2.499</span><span class="irs-to" style="visibility: visible; left: 31.6973%;">Rp. 500.000</span><span class="irs-single" style="visibility: hidden; left: 0.922538%;">Rp. 2.499 - Rp. 500.000</span></span><span class="irs-grid"></span><span class="irs-bar" style="left: 3.22581%; width: 46.657%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-slider from" style="left: 0%;"></span><span class="irs-slider to type_last" style="left: 46.657%;"></span></span><input type="text" class="js-range-slider irs-hidden-input" id="price-slider" value="" readonly=""></div>
										
									</div>
								</div>
								<div class="airlines">
									<p>Airlines</p>
									<div class="custom-control custom-checkbox">
										
										<div class="d-flex">
											
											<input type="checkbox" class="custom-control-input" id="flight1">
											<label class="custom-control-label" for="flight1">
												<div class="d-flex">
													<div class="labelImg">
														
														<img src="/public/images/flight.png">
														
													</div>
													<div>
														<div>Indigo</div>
														<p>Rs 474,99</p>
														
													</div>
													
													
												</div>
												
											</label></div>
											
										</div>
										<div class="custom-control custom-checkbox">
											
											<div class="d-flex">
												
												<input type="checkbox" class="custom-control-input" id="flight2">
												<label class="custom-control-label" for="flight2">
													<div class="d-flex">
														<div class="labelImg">
															
															<img src="/public/images/flight1.png">
															
														</div>
														<div>
															<div>Spicejet</div>
															<p>Rs 474,99</p>
															
														</div>
														
														
													</div>
													
												</label></div>
												
											</div>
											<div class="custom-control custom-checkbox">
												
												<div class="d-flex">
													
													<input type="checkbox" class="custom-control-input" id="flight3">
													<label class="custom-control-label" for="flight3">
														<div class="d-flex">
															<div class="labelImg">
																
																<img src="/public/images/flight2.png">
																
															</div>
															<div>
																<div>Air India</div>
																<p>Rs 474,99</p>
																
															</div>
															
															
														</div>
														
													</label></div>
													
												</div>
												<div class="custom-control custom-checkbox">
													
													<div class="d-flex">
														
														<input type="checkbox" class="custom-control-input" id="flight4">
														<label class="custom-control-label" for="flight4">
															<div class="d-flex">
																<div class="labelImg">
																	
																	<img src="/public/images/flight3.png">
																	
																</div>
																<div>
																	<div>Jet Airways</div>
																	<p>Rs 474,99</p>
																	
																</div>
																
																
															</div>
															
														</label></div>
														
													</div>
												</div>
											</div>
										</div></div>
										<div class="col-lg-9">
											<div class="top-section">
												<div class="d-flex justify-content-between">
													<div class="left-div"><p>Found {{count($flights->Response->Results[0])}} Flights</p>
													<p><small>IN 2.46 SECONDS</small></p></div>
													<div class="center-div">
														<ul>
															<li><p>{{$flights->Response->Origin}}</p>
															<p><small>{{$postData['date_up']}}</small></p><i class="fas fa-long-arrow-alt-right"></i></li>
															<li><p>{{$flights->Response->Destination}}</p>
														</li>
													</ul>
												</div>
												<div class="right-div">
													<a href="#" data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i> <span class="modify-search">Modify Search</span></a>
													<button class="filter-btn"><i class="fas fa-filter"></i></button>
												</div>
											</div>
										</div>
										<div class="flight-list">

											<div class="slider-section">
												<div class="monthSlide">
													<div class="owl-carousel" id="monthSlider">
														
													@if($calenderFare->Response->Error->ErrorCode===0)
													 @foreach($calenderFare->Response->SearchResults as $key=>$date )
														<div class="monthItem">
															<p class="month-label">
																{{date("d M", strtotime($date->DepartureDate))}}
															</p>
															<p class="month-price">
																<span class="rs">Rs.</span>{{number_format($date->Fare+$date->Tax)}}
															</p>
														</div>
													@endforeach
													@endif
														
													</div>
												</div>
												<div class=" calender text-center">
													<img src="/public/images/calender.svg">
													<p>Fare Calander</p>
												</div>
											</div>
											</div>

											
											<div class="flight-head">
												<div class="flight-title">Airline</div>
												<div class="flight-rest">
													<div class="flight-depart">Departure</div>
													<div class="flight-ariv">Arrival</div>
													<div class="flight-dur">Duration</div>
													<div class="flight-price">Price</div>
													<div class="flight-btn"></div>
												</div>
											</div>
											<div class="flight-body">
												@foreach($flights->Response->Results[0] as $key=>$flight )
												
												@foreach($flight->Segments[0] as $seg_key=>$segment )
                              							<div class="flight-body-main">
																<div class="flight-inner">
																	<div class="flight-Btitle">
																		<div class="flight-logo">
																		<img src="/public/images/airlines/{{$segment->Airline->AirlineCode}}.gif"></div>
																		<div>
																			<p class="flight-name">{{$segment->Airline->AirlineName}}</p>
																			<p class="flight-price1">{{$segment->Airline->AirlineCode}} {{$segment->Airline->FlightNumber}}</p>
																		</div>
																	</div>
															 
																	<div class="flight-rest">
																		<div class="flight-Bdepart">{{ substr($segment->StopPointDepartureTime, -8,-3) }}</div>
																		<div class="flight-Bariv">{{substr($segment->StopPointArrivalTime, -8,-3) }}</div>
																		<div class="flight-Bdur">
																			<p>{{date('H:i', mktime(0,$segment->Duration))}}</p>
																			<img src="/public/images/long-arrow.png">
																			<p>Non-stop</p></div>
																			<div class="flight-Bprice">Rs {{number_format($flight->Fare->PublishedFare)}}</div>
																			<div class="flight-Bbtn"><a href="flight-book.html">Book Now</a>
																				<div class="mt-2" >{{$segment->NoOfSeatAvailable}} seats left </div>
																			</div>
																		</div>
																</div>
															<div class="flight-footer">
																	<div class="flight-details"><a href="#" data-toggle="modal" data-target="#flightDetail_{{$key}}" >Flight Detail</a></div>
															</div>
													        </div>
													        <div class="modal fade" id="flightDetail_{{$key}}" role="dialog" style="display: none;" aria-hidden="true">
																			<div class="modal-dialog modal-lg">
																				<!-- Modal content-->
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
																									<p>{{$flights->Response->Origin}}</p>
																									<i class="fas fa-long-arrow-alt-right"></i>
																								</li>
																								<li>
																									<p>{{$flights->Response->Destination}}</p>
																								</li>
																								</ul>
																								<span class="schedule">{{date("D,d M", strtotime($segment->Duration))}} | {{date('H:i', mktime(0,$segment->Duration))}}  | <span class="non-stop">Non Stop</span>
																								</span>
																							</div>
																							<div class="right-div">
																								<div class="flight-price">
																								<p>Rs. {{number_format($flight->Fare->PublishedFare)}}</p>
																								<p><span>(Per Adult)</span></p>
																								</div>
																								<div class="flight-Bbtn"><a href="flight-book.html">Book Now</a></div>
																							</div>
																						</div>
																						<div class="modal-tabs">
																							<ul class="nav nav-tabs">
																								<li><a data-toggle="tab" href="#basic_{{$key}}" class="active">Itinerary</a></li>
																								<li><a data-toggle="tab" href="#detailed_{{$key}}">Fare SUMMARY & RuleS </a></li>
																							</ul>
																							<div class="tab-content">
																								<div id="basic_{{$key}}" class="tab-pane fade in active">
																								<div class="sector-detail">
																									<div class="row">
																										<div class="text-sm-center col-sm-2 col-lg-3 text-xs-left">
																											<div class="flight-pic">
																											<picture>
																												<source media="(min-width: 650px)" srcset="/public/images/airlines/{{$segment->Airline->AirlineCode}}.gif">
																												<source media="(min-width: 465px)" srcset="/public/images/airlines/{{$segment->Airline->AirlineCode}}.gif">
																												<img src="/public/images/airlines/{{$segment->Airline->AirlineCode}}.gif" alt="flight logo" style="width:auto;">
																											</picture>
																											</div>
																											<div class="flight-info">
																											<p>{{$segment->Airline->AirlineName}}</p>
																											<p class="small-txt">{{$segment->Airline->AirlineCode}}-{{$segment->Airline->FlightNumber}}</p>
																											<p>32B</p>
																											</div>
																										</div>
																										<div class="col-sm-10 col-lg-9">
																											<div class="row">
																											<div class="col-6 order-first col-md-3">
																												<div class="from-place">
																													<p>{{$segment->Origin->Airport->CityName}}, {{$segment->Origin->Airport->CountryCode}}</p>
																													<h3>{{substr($segment->StopPointDepartureTime, -8,-3)}}</h3>
																													<p class="bold"></p>
																													<span class="gray-light">{{$segment->Origin->Airport->AirportName}}<span>, T-{{$segment->Origin->Airport->Terminal}}</span></span>
																												</div>
																											</div>
																											<div class="col-6 col-md-3">
																												<div class="to-place">
																													<p>{{$segment->Destination->Airport->CityName}}, {{$segment->Destination->Airport->CountryCode}}</p>
																													<h3>{{substr($segment->StopPointArrivalTime, -8,-3)}}</h3>
																													<p class="bold"></p>
																													<span class="gray-light">{{$segment->Destination->Airport->AirportName}}<span>, T-{{$segment->Destination->Airport->Terminal}}</span></span>
																												</div>
																											</div>
																											<div class="col-sm-12 text-center order-md-first col-md-6 col-lg-6">
																												<p class="top-para">
																													<span class="time-taken">
																													<i class="far fa-clock"></i>&nbsp; 1h 15m &nbsp;</span>
																													<span class="meal"><span class="light-line">|</span>&nbsp;Free Meal</span>
																													<span class="economy"><span class="light-line">|</span>&nbsp; Economy</span>
																												</p>
																												<p class="middle-para"><span class="type-text"><i class="fas fa-plane"></i>Flight</span></p>
																												<p class="bottom-para"><span>25 kgs &nbsp;</span><span class="light-line">|</span>&nbsp;<span>Partially Refundable</span>
																												</p>
																											</div>
																											</div>
																										</div>
																									</div>
																								</div>
																								</div>
																								<div id="detailed_{{$key}}" class="tab-pane fade">
																								<div class="row">
																									<div class="col-md-5">
																										<div class="one-fourth">
																											<div class="insert-content">
																											<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0" style="position:relative;">
																												<thead>
																													<tr>
																														<th>
																														<strong>Fare Summary</strong>
																														</th>
																														<th><strong>ADT x1</strong></th>
																													</tr>
																												</thead>
																												<tbody>
																													<tr>
																														<td > Base Fare </td>
																														<td > Rs.&nbsp; 3,780</td>
																													</tr>
																													<tr >
																														<td> Airline Fuel Surcharges </td>
																														<td > Rs.</i>&nbsp;	592</td>
																													</tr>
																													<tr>
																														<td><strong>Total</strong></td>
																														<td><strong>Rs.  4,372</strong></td>
																													</tr>
																												</tbody>
																											</table>
																											</div>
																											<p class="ltr-gray mt10 fs-sm">
																											<sup>*</sup>Total fare displayed above has been rounded off and may thus show a slight difference.
																											</p>
																										</div>
																									</div>
																									<div class="col-md-7">
																										<div class="insert-content">
																											<div class="farerule-select">
																											<!-- ngRepeat: sector in flDtl.fareRules.sectors --><span class="select-rule sort-active">
																											DEL-BOM
																											</span><!-- end ngRepeat: sector in flDtl.fareRules.sectors -->
																											</div>
																											<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0">
																											<thead>
																												<tr class="bg-grey">
																													<th>
																														<h3 class="bold">Fare Rules</h3>
																													</th>
																													<th class="tr bold">
																													</th>
																												</tr>
																											</thead>
																											<tbody>
																												<tr>
																													<th width="30%">Airline</th>
																													<td width="70%">SpiceJet</td>
																												</tr>
																												<tr>
																													<th>Fare Basis Code</th>
																													<td>XXXXX</td>
																												</tr>
																												<tr>
																													<th>Refund Type
																														<span class="asterisk">**</span>
																													</th>
																													<td>Partially Refundable </td>
																												</tr>
																												<tr class="">
																													<th>Airline Cancellation Fee
																														<span class="asterisk">*</span>
																													</th>
																													<td>
																														<i>Rs.</i>
																														3,000
																													</td>
																												</tr>
																												<tr>
																													<th>Yatra Online
																														<br> Cancellation/Rescheduling Service Fee
																														<span class="asterisk">*</span>
																													</th>
																													<td>
																														<span>
																														<i>Rs.</i>&nbsp;
																														400
																														</span>
																													</td>
																												</tr>
																												<tr>
																													<th>Yatra Offline
																														<br> Cancellation/Rescheduling Service Fee
																														<span class="asterisk">*</span>
																													</th>
																													<td>
																														<span>
																														<i>Rs.</i>&nbsp;
																														1,250
																														</span>
																													</td>
																												</tr>
																												<tr>
																													<th>Cancellation Policy
																														<span class="asterisk">*</span>
																													</th>
																													<td>
																														Cancellation penalty per sector applicable 2 hrs prior to departure - INR 3000. If cancellation is done with in 2 hrs of departure, the ticket will be treated as a No-Show. In case of a No-Show, the fare in Non-Refundable. Basic Fare + YQ + YR will be forfeited and only statutory taxes will be refunded in this case. Partial cancellation is not allowed for tickets booked under a special return fare.
																													</td>
																												</tr>
																												<tr>
																													<th>Re-issuance
																														<span class="asterisk">*</span>
																													</th>
																													<td>
																														INR 3000 will be charged as rebooking /change fee up to 2 hour prior to flight departure.  In case of a No-Show, the fare in Non-Refundable. Basic Fare + YQ + YR will be forfeited and only statutory taxes will be refunded in this case.
																													</td>
																												</tr>
																											</tbody>
																											</table>
																										</div>
																										<div class="ltr-gray ">
																											<span class="asterisk">*</span> Per person per sector.
																											<br>
																											<span class="asterisk">**</span>Please note: Yatra cancellation fee is over and above the airline cancellation fee
																											due to which refund type
																											may vary.
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
													@endforeach
                         						@endforeach
										    </div>
									</section>
			@else 
			<div class="container-fluid" >
						<div class="card border-dark mb-3" style="max-width: 18rem;">
							<div class="card-header">No flights found</div>
							<div class="card-body text-dark">
								<h5 class="card-title">{{ $flights->Response->Error->ErrorMessage }}</h5>
								  <p class="card-text">Sorry, There were no flights found for this route and date combination.</p>
									<p>We suggest you modify your search and try again.</p>
							</div>
					</div>
			</div>
			@endif;
