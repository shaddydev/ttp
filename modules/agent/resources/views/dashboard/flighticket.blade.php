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
	$airlinecode = $decoded[0][0]->Airline->AirlineCode;?>
	<?php $faredecode = json_decode($bookingslist[0]->fare_quote);?>
	<?php $getsitedata = getsiteinfo();?>
	<body style="margin:0px;font-family: 'Ubuntu', sans-serif; font-size: 13px; font-weight: 400; line-height: 23px;">
		<div align = "center">
				<button id="myBtn" style="background: #fffcc7; color: #fb8c1b; border:1px solid #ff0000; margin: 4px;">Edit Markup</button>
				<button id="myBtn1" onclick = "hidefare();" style="background: #fffcc7; color: #fb8c1b; border:1px solid #ff0000; margin: 4px;">Hide Fare</button>
				<button id="myBtn2" onclick="printDiv();" target = "_blank"style="background: #fffcc7; color: #fb8c1b; border:1px solid #ff0000; margin: 4px;">Print e Ticket</button>
				<a id  = "model3" href = "javaScript:void(0)" style="background: #fffcc7; color: #fb8c1b; border:1px solid #ff0000; margin: 4px;">Email Ticket</a>
		</div>
		<table width="700" align="center" cellspacing="0" cellpadding="0" border="0" style="border:2px solid #444" id = "DivIdToPrint">
			<tr>
				<td valign="top" style="padding:10px;">
				<strong style="font-size: 18px; text-transform: uppercase;">{{ $users['role_id'] != 3 ? $users->user_details->agentname : 'Travel Trip Plus'}}</strong><br>
				{{$users['role_id'] != 3 ? $users->user_details->agentadd :($getsitedata['4']->value) }}<br>
				Contact No. : {{ $users['role_id'] != 3 ? $users['mobile'] : ($getsitedata['2']->value)  }}<br>
				Email Id: {{ $users['role_id'] != 3 ?  $users['email'] :($getsitedata['5']->value) }}
				</td>
				<td valign="top" align="right" style="padding:10px;">
					<strong>R PNR : {{ $bookingslist[0]->pnr}}</strong><br>
					Issued Date : {{date('d/m/Y',strtotime($bookingslist['0']->created_at))}}
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding:10px; ">
					<table width="700" cellpadding="0" cellspacing="0" border="0" style=" padding:10px 0px; line-height:20px;border-top:2px solid #ccc; border-bottom: 2px solid #ccc;">
						<tr>
							<td valign="top">
								Customer Contact No. : <strong>{{$bookingslist['0']['booking_details'][0]['mobile']}}</strong><br>
							
							</td>
							<td valign="top">AIRLINE PNR : <strong>{{ $bookingslist[0]->pnr}}</strong></td>
							<td valign="top">
								Issued by : <strong></strong><br>
							
							</td>
							<td valign="top">
						
								<img src="{{asset('public/images/airlines/'.$airlinecode)}}.gif" width="25">
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan="2" style="padding:10px; ">
					<table width="700" cellspacing="0" cellpadding="0" border="0" style="padding: 10px; border:2px solid #ccc; ">
					    <?php $i = 0; $k= 0;?>
							 @foreach($bookingslist as $data)
							
							<?php $bookings =  json_decode($data->booking_info);?>
							@foreach($bookings as $decode)
						    @foreach($decode as $bookdata)
								
						<tr>
						<td>{{$k == 0 ? 'Departure' : 'Return'}}</td>
							<td valign="top" style="padding-bottom:20px">
								<strong>{{$bookdata->Airline->AirlineName}}</strong><br>
								{{$bookdata->Airline->AirlineCode}}-{{$bookdata->Airline->FlightNumber}}<br>
								Operated by <strong>{{$bookdata->Airline->AirlineCode}}</strong> <br>
								Class Code : <strong>{{$bookdata->Airline->FareClass}}</strong>
							</td>
							<td valign="top" align="right"  style="padding-bottom:20px">
								Departure <img src="{{asset('public/images/depart.png')}}"> <strong>{{$bookdata->Origin->Airport->CityName}}</strong><br>
								<strong>{{date('jM-Y H:i:s',strtotime($bookdata->Origin->DepTime))}}</strong><br>
							
								Departure Terminal :- {{$bookdata->Origin->Airport->Terminal}}<br>
							</td>
							<td valign="top" align="center"  style="padding-bottom:20px">
								<img src="{{asset('public/images/clock.png')}}"><br>
								<strong>{{floor($bookdata->Duration / 60).' hrs:'.($bookdata->Duration -   floor($bookdata->Duration / 60) * 60).'min'}}</strong><br>
							
							</td>
							<td valign="top"  style="padding-bottom:20px">
								Arrival <img src="{{asset('public/images/arrival.png')}}"> <strong>{{$bookdata->Destination->Airport->CityName}}</strong><br>
								<strong>{{date('jM-Y H:i:s',strtotime($bookdata->Destination->ArrTime))}}</strong><br>
							
								Arival Terminal :- {{$bookdata->Destination->Airport->Terminal}}<br>
							</td>
							
						</tr>
						 @endforeach
						<?php $k++;?>
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
					   <?php $baggageCharge = 0 ;?>
						 @forelse($bookingslist[0]['booking_details'] as $bookingdetails)
								<?php $extrabaggage = json_decode($bookingdetails['baggage_info']) ;
								      if(!empty($extrabaggage)){
												$baggageCharge += $extrabaggage[0]->Price;
											}
								      ?>
							<tr>
							<td style="padding: 5px;"><strong>{{$bookingdetails['title']}}.{{$bookingdetails['fname']}} &nbsp; {{$bookingdetails['lname']}}</td>
							<td style="padding: 5px;">{{$bookingslist[0]->status == 0 ? 'Cancel' :  ($bookingslist[0]->pnr == '' ? 'Not Confirmed'  : 'Confirmed')}}</td>
							<td style="padding: 5px;">{{ getticket($bookingdetails['id']) }}</td>
							<td style="padding: 5px;">-</td>
							<td style="padding: 5px;">-</td>
							<td style="padding: 5px;">{{$decode[0]->Baggage}}{{$extrabaggage != '' ? '+'. $extrabaggage[0]->Weight .'KG' : ''}}</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 10px;">
					<table width="700" cellpadding="0" cellspacing="0" border="0" id = "faredetail">
						<tr>
							<td style="border:1px solid #ccc;" valign="top">
								<table style="width: 100%">
									<thead>
										<tr><th colspan="2">Payment Details</th></tr>
										<?php //echo "<pre>";print_r($faredecode)?>
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
											<td>{{$faredecode->Currency}}  {{$baggageCharge}}</td>
										</tr>
										<tr>
											<td>Seat</td>
											<td>{{$faredecode->Currency}}  {{$faredecode->TotalBaggageCharges}}</td>
										</tr>
										<tr style="background: #ddd;">
											<td>Taxes & Other Charges</td>
											@php $moreother = ($bookingslist['0']->total -  ($faredecode->BaseFare + $baggageCharge));
											   
											 @endphp
										 
											<!-- <td>{{$faredecode->Currency}} {{$faredecode->Tax + $faredecode->OtherCharges }} </td> -->
										
										 <td>{{$faredecode->Currency}} <span id = "moremarkup"> {{$moreother}}</span></td>
										</tr>
										<tr>
											<td><strong>Gross Amount</strong></td>
											
										<td id = "addmarkup"><strong> {{$bookingslist['0']->total}}</strong></td>
										</tr>
									</tbody>
								</table>
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
					<p><strong>"THANK YOU FOR BOOKING WITH {{ $users['role_id'] != 3 ? $users->user_details->agentname : 'Travel Trip Plus'}}"</strong></p>
				</td>
			</tr>
		</table>
		<div id="myModal" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				
				<div class="form">
				   <form>
						<label><strong>Markup</strong></label>
						<input type="text" placeholder="0" style="min-width: 100px;" id = "markup">
						<div class="saveClose">
							<button class="save" onclick = "add();" type = "button">Save</button><button id = "closed" class="close">Close</button>
						</div>
						</form>
				</div>
			</div>
		</div>
		<!-- second modelbox -->
		<div id="mymailModal" class="emailmodal">
			<!-- Modal content -->
			<div class="emailmodal-content">
				
				<div class="form">
				   <form method = "post" id="myBtn3" action = "{{url('/agent/mailticket/'.Request::segment(4))}}">
					  {{csrf_field()}}
						<label><strong>Enter Mail ID</strong></label>
						<input type="email" placeholder="enter sender mail ID" style="min-width: 100px;" required name = "emailid" id = "emailid">
						<div class="saveClose">
							<button class="save"  onclick = "send();" type = "submit">Send</button>
						</div>
						</form>
				</div>
			</div>
		</div>
		<script>
		// Get the modal
		var modal = document.getElementById("myModal");
		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");
		// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			// When the user clicks the button, open the modal
			btn.onclick = function() {
			
			modal.style.display = "block";
			}
			// When the user clicks on <span> (x), close the modal
				span.onclick = function() {
				modal.style.display = "none";
				}
				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function(event) {
				if (event.target == modal) {
				modal.style.display = "none";
				}
				}
				</script>
				
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
				<script>
					var othercharge = document.getElementById('moremarkup').innerText;
					var x = document.getElementById('addmarkup').innerText;
				function add(){
				
				 
					var y = document.getElementById('markup').value;
					 
				  document.getElementById('moremarkup').innerText = +othercharge + +y;

					document.getElementById('addmarkup').innerText = +x + +y;

					var oldUrl = $('#myBtn3').attr("action");

          var newUrl = oldUrl+'?kt='+$('#addmarkup').text()+'&och='+$('#moremarkup').text(); 

					$('#myBtn3').attr("action",newUrl);
					
					let element = document.getElementById('closed');
					element.dispatchEvent(new Event("click"));
				}

				var oldUrl = $('#myBtn3').attr("action");
				
				function hidefare(){
					var x =$("#faredetail").toggle();
					var price  = $('#addmarkup').text();
				   
						if($("#faredetail").is(":visible")){
							
							$('#myBtn3').attr("action",oldUrl);
							} else{
									
									var newUrl = oldUrl+'?et="'+price+'"'; // 
									$('#myBtn3').attr("action",newUrl);
									}
					
				}

				</script>
				

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
       // Email ticket model box 
			
					var emailmodal = document.getElementById("mymailModal");
					var emailbtn = document.getElementById("model3");
					 
					 
					var emailspan = document.getElementsByClassName("emailclose")[0];
						emailbtn.onclick = function() {
						
						emailmodal.style.display = "block";
						}
						
						emailspan.onclick = function() {
							emailmodal.style.display = "none";
							}
						
						window.onclick = function(event) {
							if (event.target == emailmodal) {
								emailmodal.style.display = "none";
								}
							}

							
					</script>

	</body>
</html>