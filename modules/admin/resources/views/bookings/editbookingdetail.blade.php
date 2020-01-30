@extends('admin::layouts.admin')
@section('admin::content')
<div class="content">
   <div class="container-fluid">
      <!--flash message-->
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <i class="material-icons">close</i>
         </button>
         <span>
         <b>{{ $message }} </b></span>
      </div>
      @endif
      <!--end flash messages--> 
      
      @if ($message = Session::get('error'))
      <div class="alert alert-danger">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <i class="material-icons">close</i>
         </button>
         <span>
         <b>{{ $message }} </b></span>
      </div>
      @endif
      <!--end flash messages-->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                     <i class="material-icons">Booking Details</i>
                  </div>
                  <h4 class="card-title">Booking Details</h4>
               </div>
               <br><br> 
			    <form method="get" name="pnrupdateform" action = "{{url('admin/view_bookings')}}">
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="panel panel-primary">
                           <div class="panel-body">
                              <table class="table-responsive">
                                 <tr>
                                    <th>User Name: </th>
                                    <td>{{$bookingslist['0']->users_bookings['fname']}} &nbsp; {{$bookingslist['0']->users_bookings['lname']}}</td>
                                 </tr>
                                 <tr>
                                    <th>Agency: </th>
                                    <td>{{$bookingslist['0']->users_bookings->user_details->agentname}}-{{$bookingslist['0']->users_bookings->user_details->unique_code}}</td>
                                 </tr>
                                 <tr>
                                    <th>Assignee: </th>
                                    <td>@if($bookingslist['0']->assignee_id == '')<?php echo "";?> @else<?php echo getassigneename($bookingslist['0']->assignee_id); ?> @endif</td>
                                 </tr>
                                 <tr>
                                    <th>PNR: </th>
                                    <td><input type = "text"  name="pnrno" class = "form-control" value = "{{$bookingslist['0']->pnr}}">
                                    <input type="hidden" name="mainbookingid" value="{{$bookingslist['0']->id}}"></td>
                                 </tr>
                               
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="panel panel-primary">
                           <div class="panel-body">
                              <table class="table-responsive">
                                 <tr>
                                    <th>Booking Reference Id: </th>
                                    <td>{{$bookingslist['0']->booking_reference_id}}</td>
                                 </tr>
                                 <tr>
                                    <th>PNR </th>
                                    <td>{{$bookingslist['0']->pnr}}</td>
                                 </tr>
                                 <tr>
                                    <th>Booking Date & Time: </th>
                                    <td>{{$bookingslist['0']->created_at}}</td>
                                 </tr>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <br><br>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="panel panel-primary">
                           <div class="panel-heading"><strong>Journey Details</strong></div>
                           <div class="panel-body">
                              <table class="table">
                                 <thead>
                                    <tr>
                                       <th>Trip Type</th>
                                       <th>Flight</th>
                                       
                                       <th>Journey Date & Time</th>
                                       <th>Boarding</th>
                                       <th>Duration</th>
                                       <th>De-Boarding</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php $i = 0; ?>
                                   <?php //echo "<pre>"; print_r($bookingslist[0]);?>
                                    @foreach($bookingslist as $data)
                                    <?php $bookings =  json_decode($data->booking_info); ?>
                                    <?php $all_details =  json_decode($data->all_details); ?>
                                    @foreach($bookings[0] as $decode)
                                    <tr>
                                   
                                    <td>{{$i == 0 ? 'Departure' : 'Return'}}</td>
                                       <td><b>{{$decode->Airline->AirlineName}}</b><br>{{$decode->Airline->AirlineCode}}&nbsp;{{$decode->Airline->FlightNumber}}({{$decode->Airline->FareClass}})
                                       <br>
                                       @if($all_details!==null)
                                        {{$all_details->FlightItinerary->AirlineRemark}}
                                       @endif
                                       </td>
                                       
                                       
                                       <td>{{$decode->Origin->DepTime}}</td>
                                       <td>{{$decode->Origin->Airport->AirportName}}-{{$decode->Origin->Airport->CityName}},{{$decode->Origin->Airport->CountryName}}</td>
                                       <td>{{floor($decode->Duration / 60).' hrs:'.($decode->Duration -   floor($decode->Duration / 60) * 60).'min'}}</td>
                                       <td>{{$decode->Destination->Airport->AirportName}}-{{$decode->Destination->Airport->CityName}},{{$decode->Destination->Airport->CountryName}}</td>
                                       @endforeach
                                    <?php $i++;?>
                                    @endforeach
                                 </tbody>
                              </table>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <br><br>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="panel panel-primary">
                           <div class="panel-heading"><strong>Passenger Details</strong></div>
                           <div class="panel-body">
                              <table class="table">
                                 <thead>
                                    <tr>
                                       <th class="text-center">#</th>
                                       <th>Title</th>
                                       <th>First Name</th>
                                       <th>Last Name</th>
                                       <th>Ticket Number</th>
                                       <th>Email</th>
                                       <th>Mobile Number</th>
                                       <th>Gender</th>
                                       <th>Address</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 @forelse($bookingslist[0]['booking_details'] as $bookingdetails)
                                 <input type="hidden" name="bookingid[]" value="{{$bookingdetails->id}}">
                                    <tr>
                                       <td>{{$loop->iteration}}</td>
                                       <td>{{$bookingdetails->title}}</td>
                                       <td>{{$bookingdetails->fname}}</td>
                                       <td>{{$bookingdetails->lname}}</td>
                                       <td><input type = "text" name = "ticketno[]" class = "form-control" value = "{{ getticket($bookingdetails->id) }}"></td>
                                       <td>{{$bookingdetails->email}}</td>
                                       <td>( +{{$bookingdetails->country_code}} ) {{$bookingdetails->mobile}}</td>
                                       <td> @if($bookingdetails->gender == '1')
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
                           </div>
                        </div>
                     </div>
                  </div>
                
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="panel panel-primary">
                           <div class="panel-heading"><strong>Payment Details</strong></div>
                           <div class="panel-body">
                              <table class="table">
                                 <tbody>
                                    <tr>
                                      
                                       @php ($i = 0)
                                       @php ($allTotal = 0)
                                       @foreach($bookingslist as $data)
                                       <?php $faredecode =  json_decode($data->fare_quote);?>
                                       <td valign="top" style="padding-top: 20px;">
                                          <table cellpadding="0" cellspacing="0" border="1" style="width:100%;  border-color: #f9f9f9;">
                                             <tbody>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Subtotal:</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->BaseFare}}</td>
                                                </tr>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Tax</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹  {{$faredecode->Tax}}</td>
                                                </tr>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Other Charges</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹  {{$faredecode->OtherCharges}}</td>
                                                </tr>
                                                <tr>
                                                   <td style=" padding:10px;">Total:</td>
                                                   <td style=" padding:10px;">₹ {{$bookingslist['0']->total_display}}</td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       @php($allTotal += $bookingslist['0']->total)
                                       @php ($i++)
                                       @endforeach
                                    </tr>
                                    <tr>
                                       <td align = "right">All Total: ₹ {{$allTotal}}</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <br><br>
                   <input type="submit" class="btn btn-primary" name="updatepnrno" value = "submit"> 
               </div>
			   </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection