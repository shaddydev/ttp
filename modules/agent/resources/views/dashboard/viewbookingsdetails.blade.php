@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
   <div class="container-fluid">
      <div class="page-title">
         <h3>My Agents
         </h3>
         <ul>
            <li>
               <a href="/">Home
               </a> 
               <span class="arrow-icon">
               <i class="fas fa-long-arrow-alt-right">
               </i>
               </span>
            </li>
            <li>
               <span>Your Profile
               </span>
            </li>
         </ul>
      </div>
   </div>
</section>
<section class="user-panel">
   <div class="container-fluid">
      <!-- Bootstrap row -->
      <div class="row" id="body-row">
         <!--sidebar-->
         @include('agent::layouts.sidebar')
         <!--content-->
         <div class="col">
            <div class="card">
               <h4 class="card-header">
                  <button class="panel-button">
                  <i class="fas fa-bars">
                  </i>
                  </button>My Bookings
               </h4>
               <?php //print_r($user); exit;?>
               <div class="card-body">
                  <div class="account-details">
                     <!--profile form-->
                     <div class="account-details">
                        @include('agent::message')
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
                        <?php  $getsitedata = getsiteinfo();?>
                        <div class = "row">
                        <div class = "col-md-6"></div>
                        @if($bookingslist[0]->pnr!==NULL)
                        <?php //echo "<pre>";print_r($bookingslist);?>
                        <div class = "col-md-6">
                          <a class = "btn btn-danger btn-sm" href = "{{url(Auth::user()->role->name.'/flight/ticket/'.$bookingslist['0']->id.'/'.$bookingslist['0']->user_id)}}" target = "_blank"><i class="fa fa-print" aria-hidden="true"></i> Print Ticket</a>
                          <a class = "btn btn-info btn-sm" href = "{{url(Auth::user()->role->name.'/bookings/invoice/'.$bookingslist['0']->id.'/'.$bookingslist['0']->user_id)}}" target = "_blank"><i class="fa fa-file" aria-hidden="true"></i> Invoice</a>
                          <a class = "btn btn-danger btn-sm" href = "{{url(Auth::user()->role->name.'/bookings/requestchange/'.$bookingslist['0']->id)}}"><i class="fa fa-times" aria-hidden="true"></i> Change request</a>
                        </div>
                        @endif
                        <div>
                        <div class="row" id = "">
                           <div class="col-md-12">
                              <div class="card">
                                 <div class="card-body">
                                    <div class="row">
                                      
                                       <div class="col-sm-7">
                                          <div class="panel panel-primary">
                                             <div class="panel-heading"><strong></strong></div>
                                             <div class="panel-body">
                                             <div class="row">
                                               <div class="col-12"><img src = "{{asset('public/uploads/siteinfo/resizepath/26339476829fb2cb816b6b29395c7b2b.png')}}"></div>
                                               <div class="col-3"><strong>Email ID</strong></div>
                                               <div class="col-9">{{ ($getsitedata['5']->value) }}</div>
                                               <div class="col-3"><strong>Mobile</strong></div>
                                               <div class="col-9">{{ ($getsitedata['2']->value) }}</div>
                                               <div class="col-3"><strong>Address</strong></div>
                                               <div class="col-9">{{ ($getsitedata['4']->value) }}</div>
                                               </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-5">
                                          <div class="panel panel-primary">
                                             <div class="panel-heading"><strong>{{title_case($bookingslist['0']->users_bookings['fname'])}} &nbsp; {{title_case($bookingslist['0']->users_bookings['lname'])}}</strong></div>
                                             <div class="panel-body">
                                               <div class="row">
                                               <div class="col-3"><strong>Email:</strong></div>
                                               <div class="col-9">{{$bookingslist['0']->users_bookings['email']}}</div>
                                               <div class="col-3"><strong>Mobile:</strong></div>
                                               <div class="col-9">{{$bookingslist['0']->users_bookings['mobile']}}</div>
                                               <div class="col-3"><strong>Address:</strong></div>
                                               <div class="col-9">{{title_case($bookingslist['0']->users_bookings['fulladdress'])}} - {{$bookingslist['0']->users_bookings['pincode']}}</div>
                                               </div>
                                               
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-primary">
                                             <div class="panel-heading"><strong>Booking Details</strong></div>
                                             <div class="panel-body">
                                                <table class="table">
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
                                                         <td>{{date('jM-Y H:i:s',strtotime($bookingslist['0']->created_at))}}</td>
                                                         <td>₹ {{$bookingslist['0']->total}}</td>
                                                      </tr>
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
                                             <div class="panel-heading"><strong>Journey Details</strong></div>
                                             <div class="panel-body">
                                                <table class="table">
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
                                                     @foreach($bookings as $booking_info)
                                                     @foreach($booking_info as $bookingdata)
                                                      <tr> 
                                                         <td><img src="/public/images/airlines/{{$booking_info[0]->Airline->AirlineCode}}.gif" width="40px">
                                                            <p style="margin: 0px;"><strong>{{$bookingdata->Airline->AirlineName}}</strong></p>
                                                            <p style="margin: 0px;"> {{$bookingdata->Airline->AirlineCode}}-{{$bookingdata->Airline->FlightNumber}}</p></td>
                                                         <td>{{$data->pnr}}</td>
                                                          <td>{{date('jM-Y H:i:s',strtotime($booking_info[0]->Origin->DepTime))}}</td>
                                                         <td>{{$bookingdata->Origin->Airport->AirportName}}-{{$bookingdata->Origin->Airport->CityName}},{{$bookingdata->Origin->Airport->CountryName}}</td>
                                                         <td>{{floor($bookingdata->Duration / 60).' hrs:'.($bookingdata->Duration -   floor($bookingdata->Duration / 60) * 60).'min'}}</td>
                                                         <td>{{$bookingdata->Destination->Airport->AirportName}}-{{$bookingdata->Destination->Airport->CityName}},{{$bookingdata->Destination->Airport->CountryName}}</td>
                                                      </tr>
                                                      @endforeach
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
                                             <div class="panel-heading"><strong>Other Info</strong></div>
                                             <div class="panel-body">
                                                <table class="table">
                                                   <tbody>
                                                    <?php $decode =''?>
                                                     @foreach($bookingslist as $data)
                                                     @if(!empty($data->all_details))
                                                      <tr> 
                                                         <?php $decode =  json_decode($data->all_details);?>
                                                      <td>Meal :  {{$decode->FlightItinerary->Passenger[0]->SegmentAdditionalInfo[0]->Meal}}</td>
                                                      </tr>
                                                      @endif
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
                                                         <th>Name</th>
                                                         <th>Email</th>
                                                         <th>Mobile Number</th>
                                                         <th>Gender</th>
                                                         <th>Baggage</th>
                                                         
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                     <?php //print_r($bookingslist);exit;?>
                                                      @forelse($bookingslist[0]['booking_details'] as $bookingdetails)
                                                      <tr>
                                                         <td>{{$loop->iteration}}</td>
                                                         <td>{{$bookingdetails->title}}</td>
                                                         <td>{{$bookingdetails->fname}} &nbsp; {{$bookingdetails->lname}}</td>
                                                         <td>{{$bookingdetails->email}}</td>
                                                         <td>( +{{$bookingdetails->country_code}} ) {{$bookingdetails->mobile}}</td>
                                                         <td>
                                                            @if($bookingdetails->gender == '1')
                                                            Male
                                                            @else
                                                            Female
                                                            @endif
                                                         </td>
                                                         <td>
                                                         @if(!empty($bookingdetails->baggage_info))
                                                         <?php print_r(json_decode($bookingdetails->baggage_info)[0]->Weight.'KG | 15kg');?>
                                                        
                                                         @endif
                                                         
                                                         </td>
                                                        
                                                      </tr>
                                                      @empty
                                                      @endforelse
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          <br><br>
                                       <div class="row">
                                       <div class="col-sm-12">
                                          <div class="panel panel-primary">
                                             <div class="panel-heading"><strong>Payment Detail</strong></div>
                                             <div class="panel-body">
                                                <table class="table">
                                                <thead>
                                                   <tr>
                                                      <th>Base Fare</th>
                                                      <th>Taxes</th>
                                                     
                                                      <th>Baggage Charges</th>
                                                      <th>Total</th>
                                                    
                                                   </thead>
                                                   <tbody>
                                                   <?php $baggageCharge = 0 ;?>
                                                     <?php  foreach($bookingslist[0]['booking_details'] as $bookingdetails){
                                                         $extrabaggage = json_decode($bookingdetails['baggage_info']) ;
                                                         if(!empty($extrabaggage)){
                                                               $baggageCharge += $extrabaggage[0]->Price;
                                                            }
                                                         }
                                                      ?>
                                                   @php ($i = 0)
                                                   @php ($allTotal = 0)
                                                     @foreach($bookingslist as $data)
                                                      <tr> 
                                                         <?php $fare_details =  json_decode($data->fare_quote);?>
                                                         <td>₹ {{$fare_details->BaseFare}}</td>
                                                         <td>₹ {{$fare_details->Tax }} </td>
                                                        
                                                         <td>₹<?php echo $baggageCharge?></td>
                                                         <td>₹ {{$bookingslist['0']->total}}</td>
                                                      </tr>
                                                      @php($allTotal += $bookingslist['0']->total)
                                                      @php ($i++)
                                                      @endforeach
                                                      <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>All Total: ₹ {{$allTotal}}</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <br><br>
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
         </div>
      </div>
      <!-- end content-->
   </div>
   </div>
</section>
</div>
@endsection