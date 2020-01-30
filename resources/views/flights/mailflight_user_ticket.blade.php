<!DOCTYPE html>
<html>
	<head>
		<title>Travel Trip Plus</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,500,500i,700" rel="stylesheet">
	</head>
	<style type="text/css">
		.modal {  display: none;position: fixed; z-index: 1; padding-top: 100px; left: 0;top: 0; width: 100%; height: 100%;  overflow: auto;  background-color: rgba(0,0,0,0.1); }
		.modal-content { background-color: #ffffe0;margin: auto;padding: 20px;border: 2px solid #222; width: 300px;}
		.emailmodal {  display: none;position: fixed; z-index: 1; padding-top: 100px; left: 0;top: 0; width: 100%; height: 100%;  overflow: auto;  background-color: rgba(0,0,0,0.1); }
		.emailmodal-content { background-color: #ffffe0;margin: auto;padding: 20px;border: 2px solid #222; width: 300px;}
		.saveClose {  margin-top: 10px;}
		.close { margin-left: 10px;}
		.close:hover, .close:focus {color: #000;text-decoration: none;cursor: pointer;}
	</style>
	<?php $decoded = json_decode($bookingslist['0']->booking_info);
	      $airlinecode = $decoded[0][0]->Airline->AirlineCode; ?>
	<?php $faredecode = json_decode($bookingslist[0]->fare_quote);?>
	<?php $getsitedata = getsiteinfo();?>
	<body style="margin:0px;font-family: 'Ubuntu', sans-serif; font-size: 13px; font-weight: 400; line-height: 23px;">
				
		<table width="700" align="center" cellspacing="0" cellpadding="0" border="0" style="border:2px solid #444" id = "DivIdToPrint">
			<tr>
				<td valign="top" style="padding:10px;">
				<strong style="font-size: 18px; text-transform: uppercase;">{{ $users['role_id'] != 3 ? $users->user_details->agentname : 'Travel Trip Plus'}}</strong><br>
				{{$users['role_id'] != 3 ? $users->user_details->agentadd :($getsitedata['4']->value) }}<br>
				Contact No. : {{ $users['role_id'] != 3 ? $users['mobile'] : ($getsitedata['2']->value)  }}<br>
				Email Id: {{ $users['role_id'] != 3 ?  $users['email'] :($getsitedata['5']->value) }}
				</td>
				<td valign="top" align="right" style="padding:10px;">
					<strong>PNR : {{ $bookingslist[0]->pnr}}</strong><br>
					Issued Date : {{date('d/m/Y',strtotime($bookingslist['0']->created_at))}}
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding:10px; ">
					<table width="700" cellpadding="0" cellspacing="0" border="0" style=" padding:10px 0px; line-height:20px;border-top:2px solid #ccc; border-bottom: 2px solid #ccc;">
						<tr>
							<td valign="top">
								Customer Contact No. : <strong>{{$bookingsdetailslist['0']['booking_details'][0]['mobile']}}</strong><br>
							
							</td>
							<td valign="top">AIRLINE PNR : <strong>{{ $bookingslist[0]->pnr}}</strong></td>
							<td valign="top">
								Issued by : <strong></strong><br>
							
							</td>
							<td valign="top">
								<img src="/public/images/airlines/{{$airlinecode}}.gif" width="25">
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan="2" style="padding:10px; ">
					<table width="700" cellspacing="0" cellpadding="0" border="0" style="padding: 10px; border:2px solid #ccc; ">
					     <?php $i = 0;?>
							 @foreach($bookingslist as $data)
							<?php $bookings =  json_decode($data->booking_info);?>
							@foreach($bookings[0] as $decode)
						<tr >
						<td>{{$i == 0 ? 'Departure' : 'Return'}}</td>
							<td valign="top" style="padding-bottom:20px">
								<strong>{{$decode->Airline->AirlineName}}</strong><br>
								{{$decode->Airline->AirlineCode}}-{{$decode->Airline->FlightNumber}}<br>
								Operated by <strong>{{$decode->Airline->AirlineCode}}</strong>
							</td>
							<td valign="top" align="right"  style="padding-bottom:20px">
								Departure <img src="{{asset('public/images/depart.png')}}"> <strong>{{$decode->Origin->Airport->CityName}}</strong><br>
								<strong>{{date('jM-Y H:i:s',strtotime($decode->Origin->DepTime))}}</strong><br>
							
								Departure Terminal :- {{$decode->Origin->Airport->Terminal}}<br>
							</td>
							<td valign="top" align="center"  style="padding-bottom:20px">
								<img src="{{asset('public/images/clock.png')}}"><br>
								<strong>{{floor($decode->Duration / 60).' hrs:'.($decode->Duration -   floor($decode->Duration / 60) * 60).'min'}}</strong><br>
							
							</td>
							<td valign="top"  style="padding-bottom:20px">
								Arrival <img src="{{asset('public/images/arrival.png')}}"> <strong>{{$decode->Destination->Airport->CityName}}</strong><br>
								<strong>{{date('jM-Y H:i:s',strtotime($decode->Destination->ArrTime))}}</strong><br>
							
								Arival Terminal :- {{$decode->Destination->Airport->Terminal}}<br>
							</td>
							
						</tr>
						@endforeach
						<?php $i++;?>
						@endforeach
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 10px;">
					<table width="700" cellspacing="0" cellpadding="0" border="1">
						<thead>
						<tr>
							<th style="padding: 5px;">TRAVELLER (TYPE)</th>
							<th style="padding: 5px;">STATUS</th>
							<th style="padding: 5px;">TICKET NO</th>
						  <th style="padding: 5px;">MEAL</th>
							<th style="padding: 5px;">SEAT</th>
							<th style="padding: 5px;">BAGGAGE</th>
						</tr>
						</thead>
						<tbody>
					
						@forelse($bookingslist[0]['booking_details'] as $bookingdetails)
						<?php //print_r($bookingdetails['fname']);exit;?>
							<tr>
							<td style="padding: 5px;"><strong>{{$bookingdetails['fname']}} &nbsp; {{$bookingdetails['lname']}}</td>
							<td style="padding: 5px;">CONFIRMED</td>
							<td style="padding: 5px;">{{getticket($bookingdetails['booking_id'])[$loop->index]}}</td>
							<td style="padding: 5px;">-</td>
							<td style="padding: 5px;">-</td>
							<td style="padding: 5px;">{{$decode->Baggage}}</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 10px;">
				@if(@$_GET['et'] == '')
					<table width="700" cellpadding="0" cellspacing="0" border="0" id = "faredetail">
						<tr>
							<td style="border:1px solid #ccc;" valign="top">
								<table style="width: 100%">
									<thead>
										<tr><th colspan="2">Payment Details</th></tr>
									</thead>
									<tbody>
										<tr style="background: #ddd;">
											<td>Basic Fare</td>
											<td>{{$faredecode->Currency}} {{$faredecode->BaseFare}}</td>
										</tr>
										<!-- <tr>
											<td>Fuel Surcharge</td>
											<td>Rs. 400</td>
										</tr> -->
										<!-- <tr style="background: #ddd;">
											<td>K3</td>
											<td>Rs. 0</td>
										</tr> -->
										<tr>
											<td>Meals</td>
											<td>{{$faredecode->Currency}} {{$faredecode->TotalMealCharges}}</td>
										</tr>
										<tr style="background: #ddd;">
											<td>Baggage</td>
											<td>{{$faredecode->Currency}}  {{$faredecode->TotalBaggageCharges}}</td>
										</tr>
										<tr>
											<td>Seat</td>
											<td>{{$faredecode->Currency}}  {{$faredecode->TotalBaggageCharges}}</td>
										</tr>
										<tr style="background: #ddd;">
											<td>Taxes & Other Charges</td>
											<td>{{$faredecode->Currency}} {{$faredecode->Tax + $faredecode->OtherCharges }} </td>
										</tr>
										<tr>
											<td><strong>Gross Amount</strong></td>
											<td id = "addmarkup"><strong> {{@$_GET['kt'] == '' ? $bookingslist['0']->total : @$_GET['kt']}}</strong></td>
										</tr>
									</tbody>
								</table>
								@endif
							</td>
							
						</tr>
					</table>
				</td>
			</tr>

		
			<tr>
				<td colspan="2" style="padding: 10px;">
					<strong>Terms & Conditions</strong><br>
					<ul>
					<li>All Passengers must carry a Valid Photo Identity Proof at the time of Check-in.</li>
					<li>Check-in gates opens 2 hours prior to scheduled departure and closes 60 minutes prior to departure.</li>
					<li>Flight timings are subject to change without prior notice. Please recheck with the carrier prior to departure.</li>
					<li>For Fare Rules / Cancellation policy- refer to fare rules laid by the carrier.</li>
					<li>Please refer to the Conditions of Carriage laid by the carrier.</li>
				</ul>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center; background: #ddd;">
					<p><strong>"THANK YOU FOR BOOKING WITH TRAVELTRIPPLUS HOLIDAYS INDIA PVT LTD"</strong></p>
				</td>
			</tr>
		</table>
		
	</body>
</html>