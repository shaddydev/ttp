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
      <?php
         ?>
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
                                    <td>{{date('j M Y H:i:s',strtotime($bookingslist['0']->created_at))}}</td>
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
                                    <?php $i = 0; $k = 0?>
                                    @foreach($bookingslist as $data)
                                    <?php $bookings =  json_decode($data->booking_info); ?>
                                  
                                    <?php //echo $i;?>
                                    <?php $all_details =  json_decode($data->all_details); ?>
                                    
                                    @foreach($bookings as $decode)
                                       @foreach($decode as $bookdata)
                                    <tr>
                                    <td>{{$k == 0 ? 'Departure' : 'Return'}}</td>
                                    <td><b>{{$bookdata->Airline->AirlineName}}</b><br>{{$bookdata->Airline->AirlineCode}}&nbsp;{{$bookdata->Airline->FlightNumber}}({{$bookdata->Airline->FareClass}})
                                       <br>
                                       @if($all_details!==null)
                                        {{$all_details->FlightItinerary->AirlineRemark}}
                                       @endif
                                       </td>
                                     
                                       <td>{{$bookdata->Origin->DepTime}}</td>
                                       <td>{{$bookdata->Origin->Airport->AirportName}}-{{$bookdata->Origin->Airport->CityName}},{{$bookdata->Origin->Airport->CountryName}}</td>
                                       <td>{{floor($bookdata->Duration / 60).' hrs:'.($bookdata->Duration -   floor($bookdata->Duration / 60) * 60).'min'}}</td>
                                       <td>{{$bookdata->Destination->Airport->AirportName}}-{{$bookdata->Destination->Airport->CityName}},{{$bookdata->Destination->Airport->CountryName}}</td>
                                    </tr>
                                      @endforeach
                                    <?php $k++;?>
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
                                       <th>Passport</th>
                                       <th>Mobile Number</th>
                                       <th>Gender</th>
                                       <th>Address</th>
                                       <th>More Detail</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                              
                                 @forelse($bookingslist[0]['booking_details'] as $bookingdetails)
                                    <tr>
                                    <?php //echo "<pre>"; print_r(($bookingdetails->id));?>
                                       <td>{{$loop->iteration}}</td>
                                       <td>{{$bookingdetails->title}}</td>
                                       <td>{{$bookingdetails->fname}}</td>
                                       <td>{{$bookingdetails->lname}}</td>
                                       <td>{{ getticket($bookingdetails->id)}}</td>
                                       <td>{{$bookingdetails->email}}</td>
                                       <td>{{$bookingdetails->passport}}</td>
                                       <td>( +{{$bookingdetails->country_code}} ) {{$bookingdetails->mobile}}</td>
                                       <td> @if($bookingdetails->gender == '1')
                                          Male
                                          @else
                                          @Female
                                          @endif
                                       </td>
                                       <td>{{$bookingdetails->address}}</td>
                                       <td><a href = "javaScript:void(0)" class = "viewmore">View More</a>
                                       <p class = "userdata" style = "display:none">Passport Number:{{$bookingdetails->passport}}</p>
                                       <p class = "userdata" style = "display:none">Passport exp:{{$bookingdetails->passport_exp}}</p>
                                       <p class = "userdata" style = "display:none">D.O.B:{{$bookingdetails->dob}}</p></td>
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
                           <div class="panel-heading"><strong></strong></div>
                           <div class="panel-body">
                              <table class="table">
                                 <tbody>
                                    <tr>
                                      <td ></td>
                                      <td ></td>
                                      <td ></td>
                                      <td ></td>
                                      <td ></td>
                                       @php ($i = 0)
                                       @php ($allTotal = 0)
                                       @foreach($bookingslist as $data)
                                       <?php $faredecode =  json_decode($data->fare_quote);
                                       //echo "<pre>"; print_r($faredecode)?>
                                       <td colspan="3" valign="top" style="padding-top: 20px;">
                                          <table cellpadding="0" cellspacing="0" border="1" style="width:100%;  border-color: #f9f9f9;">
                                             <tbody>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Subtotal:</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->BaseFare}}</td>
                                                </tr>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Tax</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->Tax-$faredecode->YQTax}}</td>
                                                </tr>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">YQ Tax</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->YQTax}}</td>
                                                </tr>
                                                <tr>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Other Charges</td>
                                                   <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->OtherCharges}}</td>
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
                                       <td></td>
                                       <td></td>
                                       <td align = "right">All Total: ₹ {{$allTotal}}</td>
                                    </tr>
                                 </tbody>
                              </table>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <br><br>
                    <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                           <div class="modal-dialog">
                           
                              <!-- Modal content-->
                              <div class="modal-content">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title">Mail Ticket</h4>
                              </div>
                              <div class="modal-body">
                                 <form action = "{{url('/admin/booking/mailticket/'.$bookingslist['0']->id)}}" method = "post">
                                    {{csrf_field()}}
                                    <input type = "email" name = "emailid" class = "form-control" required placeholder = "Enter sender Email ID">
                                    <input type = "submit" value = "Send" class = "btn btn-success">
                                 </form>
                               </div>
                               <div class="modal-footer">
                                 
                               </div>
                              </div>
                            </div>
                          </div>
                          <?php //echo "<pre>"; print_r();?>
                         <a id="myBtn2" href = "{{url('admin/booking/downloadPDF/'.$bookingslist['0']->id)}}" target = "_blank" class = "btn btn-danger">Download Invoice</a>
                       <a href = "{{url('admin/booking/viewticket/'.$bookingslist['0']->id)}}" target = "_blank" class = "btn btn-primary">View Ticket</a>
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Send Ticket</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection