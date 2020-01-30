<!DOCTYPE html>
<html>
   <head>
      <title>Travel Trip Plus</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
   </head>
   <body>
      <?php  $getsitedata = getsiteinfo();?>
     
      <table width="700px" cellspacing="0" cellpadding="0" align="center" border="0">
         <tr>
            <td  style="padding: 10px 0px;">
               <strong>{{title_case($bookingslist[0]['users_bookings']['user_details']->agentname)}}</strong><br>
               Phone: +91 -{{$bookingslist['0']->users_bookings['mobile']}}<br>
               Email: {{$bookingslist['0']->users_bookings['email']}}<br>
               Address : {{title_case($bookingslist['0']->users_bookings['fulladdress'])}} - {{$bookingslist['0']->users_bookings['pincode']}}
            </td>
            <td  style="padding: 10px 0px;" align="right">
               <strong>Invoice : {{preg_replace('/[A-Z]+/', '', $bookingslist['0']->BookingId)}}</strong><br>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <table width="700px" cellspacing="0" cellpadding="6" border="1" style=" border-color: #eee;">
                  <thead>
                     <tr>
                        <th>Booking ID</th>
                        <th>Booking Date & Time</th>
                        <th>Grand Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>{{$bookingslist['0']->booking_reference_id}}</td>
                        <td>{{date('j-M-Y H:i:s',strtotime($bookingslist['0']->created_at))}}</td>
                        <td>{{$bookingslist['0']->total}}</td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
         <br>
        
         <tr>
            @php ($i = 0)
            @php ($allTotal = 0)
            @foreach($bookingslist as $data)
            <?php $faredecode =  json_decode($data->fare_quote); ?>
            <td valign="top" style="padding-top: 20px;">
               <table cellpadding="0" cellspacing="0" border="1" style="width:100%;  border-color: #f9f9f9;">
                  <tbody>
                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Subtotal:</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$faredecode->BaseFare}}</td>
                     </tr>
                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Tax</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$faredecode->Tax-$faredecode->YQTax}}</td>
                     </tr>

                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">YQTax:</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$faredecode->YQTax}}</td>
                     </tr>
                     
                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Other Charges</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$faredecode->OtherCharges}}</td>
                     </tr>

                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Commission:</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$data->commission}}</td>
                     </tr>
                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">TDS:</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$data->tds}}</td>
                     </tr>
                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Service Charge:</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$data->service_charge}}</td>
                     </tr>
                     <tr>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">GST:</td>
                        <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">INR {{$data->gst}}</td>
                     </tr>

                     <tr>
                        <td style=" padding:10px;">Total:</td>
                        <td style=" padding:10px;">INR {{$data->total_display}}</td>
                     </tr>

                     <tr>
                        <td style=" padding:10px;">Total payable:</td>
                        <td style=" padding:10px;">INR {{$data->total}}</td>
                     </tr>

                  </tbody>
               </table>
            </td>
            @php($allTotal += $bookingslist['0']->total)
            @php ($i++)
            @endforeach
         </tr>
         <tr>
            <td colspan = "2">
               <table width="700px" cellspacing="0" cellpadding="6" border="1" style=" border-color: #eee;margin-top:20px">
                  <thead>
                     <tr>
                        <th>Flight</th>
                        <th>PNR</th>
                        <th>Journey Date & Time</th>
                        <th>Boarding</th>
                        <th>Duration</th>
                        <th>De-Boarding</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php $i = 0;?>
                  @foreach($bookingslist as $data)
                     <?php $bookings =  json_decode($data->booking_info);?>
                     @foreach($bookings as $decode)
                        @foreach($decode as $bookdata)
                     <tr>
                        <td>{{$bookdata->Airline->FlightNumber}}{{$bookdata->Airline->AirlineName}}  </td>
                        <td>{{$data->pnr}}</td>
                        <td>{{date('jM-Y H:i:s',strtotime($bookdata->Origin->DepTime))}}</td>
                        <td>{{$bookdata->Origin->Airport->AirportName}}-{{$bookdata->Origin->Airport->CityName}},{{$bookdata->Origin->Airport->CountryName}}</td>
                        <td>{{floor($bookdata->Duration / 60).' hrs:'.($bookdata->Duration -   floor($bookdata->Duration / 60) * 60).'min'}}</td>
                        <td>{{$bookdata->Destination->Airport->AirportName}}-{{$bookdata->Destination->Airport->CityName}},{{$bookdata->Destination->Airport->CountryName}}</td>
                     </tr>
                     @endforeach
                     @endforeach
                     <?php $i++;?>
                     @endforeach
                  </tbody>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan = "2">
               <table width="700px" cellspacing="0" cellpadding="6" border="1" style=" border-color: #eee;margin-top:20px">
                  <thead>
                     <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Ticket Number</th>
                        <th>Mobile Number</th>
                        <th>Gender</th>
                        <th>Address</th>
                     </tr>
                  </thead>
                  <tbody>
                  @forelse($bookingslist[0]['booking_details'] as $bookingdetails)
                     <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$bookingdetails->title}}</td>
                        <td>{{$bookingdetails->fname}} &nbsp; {{$bookingdetails->lname}}</td>
                        <td>{{$bookingdetails->email}}</td>
                        <td>{{getticket($bookingdetails->id)}}</td>
                        <td>( +{{$bookingdetails->country_code}} ) {{$bookingdetails->mobile}}</td>
                        <td>
                           @if($bookingdetails->gender == '1')
                           Male
                           @else
                           @Female
                           @endif
                        </td>
                        <td>{{$bookingdetails->address}}</td>
                     </tr>
                     @empty
                     @endforelse
                  </tbody>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>