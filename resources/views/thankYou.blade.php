@extends('layouts.app')
@section('content')
<?php //echo "<pre>";print_r($bookingdetail[0]['booking_details']);exit;?>
<?php //$decode = json_decode($bookingdetail['0']['booking_info']);
//print_r($decode);exit;?>
<?php //$faredecode = json_decode($bookingslist[0]->fare_quote);?>
<section class="booking" >
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8">
								<div class="confirm">
									<div class="confirmIcon"><i class="fas fa-check"></i></div>
									<div class="confirmDeail">
										<h3></h3>
										<p>Congratulations! Your flight boking is <strong>confirmed.</strong> PNR - <strong>{{$bookingdetail[0]['pnr']}}</strong></p>
										<p>Reference Number - <strong>{{$bookingdetail[0]['booking_reference_id']}}</strong></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="printBill">
									<!-- <a href="#" class="billBtn" onclick = printDiv();>Print this page</a> -->
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="bookingMessage">
									<p>
										Your booking is <strong>confirmed</strong> and the e-icket will be mailed to you within 2 hours. Please carry the printout of your e-ticket along with a photo identity proof such as driving licence, voter ID or passport to the airline check-in counter.
									</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<!-- <div class="confirmContact"><h3>Confirmation Details Have Been Sent To Contact Details Given Below</h3> -->
									<!-- <div class="detainInner">
										<div class="detailPhone"> -->
											<!-- <div class="phoneIcon"><i class="fas fa-phone"></i></div>
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
											<a href="#" class="resend">Resend</a>
										</div>
										<div class="detailEmail">
											<div class="phoneIcon"><i class="fas fa-envelope"></i></div> -->
											<!-- <form method = "post" id="myBtn3" action = "{{url('/agent/mailticket/'.$bookingdetail['0']['booking_reference_id'])}}">
					  						{{csrf_field()}}
											<div class="formField">
												<input type="text" class="form-control" name = "emailid" required>
											</div>
											<input type  = "submit" class="resend">
											</form> -->
										<!-- </div>
									</div> -->
								<!-- </div> -->
							</div>
						</div> 
						
            @foreach($bookingdetail as $detail)
						<div class="row" id = "DivIdToPrint">
							<div class="col-md-12">
								<div class="bookingDetails">
									<h3>Booking Details</h3>
									<?php $bookinginfo  = json_decode($detail['booking_info']); ?>
									      
												@forelse($bookinginfo as $decodes)
											    @if($loop->iteration>1) <hr> @endif
													@forelse($decodes as $decode)
													<div class="fbookDetails">
																<div class="flightDetail1">
																	<div class="flighNames">
																
																		<div class="flightLogo"><img src="/public/images/airlines/{{$decode->Airline->AirlineCode}}.gif"></div>
																		<div class="flightCompany">
																		
																			<p>{{$decode->Airline->AirlineName}}</p>
																			<p>{{$decode->Airline->AirlineCode}}-{{$decode->Airline->FlightNumber}}</p>
																		</div>
																	</div>
																
																</div>
																<div class="flightPnr">
																	<div class="flightType">
																		<span>Economy</span>
																		<span class="brGreen">Refundable</span>
																		<span>Non Stop</span>
																		<span>Travel Class -J</span>
																	</div>
																</div>
																<div class="flighttoFrom">
																	<div class="flightTakeof">
																		<p><strong>{{$decode->Origin->Airport->CityName}}</strong></p>
																		<p>{{date('jM-Y H:i',strtotime($decode->Origin->DepTime))}}</p>
																		<p>Airport: {{$decode->Origin->Airport->AirportName}}</p>
																		<span>Terminal - {{$decode->Origin->Airport->Terminal}}</span>
																	</div>

																	<div class="flightTime">
																		<p>{{floor($decode->Duration / 60).' hrs:'.($decode->Duration -   floor($decode->Duration / 60) * 60).'min'}}</p>
																		<p><i class="fas fa-long-arrow-alt-right"></i></p>
																	</div>

																	<div class="flightTakeof">
																		<p><strong>{{$decode->Destination->Airport->CityName}}</strong></p>
																		<p>{{date('jM-Y H:i',strtotime($decode->Destination->ArrTime))}}</p>
																		<p>Airport: {{$decode->Destination->Airport->AirportName}}</p>
																		<span> Terminal - {{$decode->Destination->Airport->Terminal}}</span>
																	</div>
																</div>
															</div>
													@empty
													@endforelse
												@empty
												@endforelse
								</div>
							
							</div>
						</div>
						<div >
									<a class = "btn btn-danger" target = "_blank" style="margin-top:10px;" href = "{{url('/agent/flight/ticket/'.$bookingdetail[$loop->index]['id'].'/'.$bookingdetail[0]['user_id'])}}">Print Ticket</a>
						</div>
            @endforeach
						<div class="row">
							<div class="col-md-12">
								<div class="passengerDetails">
									<h3>Passenger Details</h3>
									<div class="passengerList">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Name Of Traveller(S)</th>
													<th>Ticket Nubmer</th>
													<th>Meals</th>
													<th>Baggage Allowance</th>
													<th>Seat Preference</th>
												
												</tr>
											</thead>
											<tbody>
											 @foreach($bookingdetail[0]['booking_details'] as $bookingdetails)
												<tr>
													<td data-title="Name Of Traveller(S)">{{$bookingdetails['fname']}} &nbsp; {{$bookingdetails['lname']}}</td>
													<td data-title="Ticket Nubmer"></td>
													<td data-title="Meals">NA</td>
												
													<td data-title="Seat Preference">NA</td>
												
												</tr>
												@endforeach
											</tbody>
										</table>
										
										<!-- <div class="passengerRow">
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p></p></div>
										</div>
										<div class="passengerRow">
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p></p></div>
											<div class="pColumn"><p>NA</p></div>
											<div class="pColumn"><p>NA</p></div>
											<div class="pColumn"><p>NA</p></div>
											<div class="pColumn"><p>NA</p></div>
										</div> -->
									</div>
								</div>
								<?php //echo "<pre>"; print_r($bookingdetail[0][$user_id]);?>
								<!-- <div class = "row">
										<a class = "btn btn-danger" target = "_blank" href = "{{url('/agent/flight/ticket/'.$bookingdetail[0]['id'].'/'.$bookingdetail[0]['user_id'])}}">Print Ticket</a>
									</div> -->
									
							</div>
						</div>
					</div>
				</section>
<script>
				
function printDiv() 
{

    var divToPrint=document.getElementById('DivIdToPrint');

    var newWin=window.open('','Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},10);


}
</script>
@endsection