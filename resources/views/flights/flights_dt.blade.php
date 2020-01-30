		
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
																{{date("d-M", strtotime($date->DepartureDate))}}
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

											<table id="all-flights" class="display" style="width:100%">
											<thead>
												<tr>
													<th>Airline</th>
													<th>Departure</th>
													<th>Arrival</th>
													<th>Duration</th>
													<th>Price</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												@foreach($flights->Response->Results[0] as $key=>$flight )
												@foreach($flight->Segments[0] as $seg_key=>$segment )
												<tr>
													<td><img src="/public/images/airlines/{{$segment->Airline->AirlineCode}}.gif">{{$segment->Airline->AirlineName}}</td>
													<td>System Architect</td>
													<td>Edinburgh</td>
													<td>61</td>
													<td>2011/04/25</td>
													<td>$320,800</td>
												</tr>
												@endforeach
                         	                    @endforeach
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
			@endif
