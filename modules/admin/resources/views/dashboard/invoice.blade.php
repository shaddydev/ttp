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
      <!-- Bootstrap row -->
      <div class="row" id="body-row">
         <!--sidebar-->
      
         <!--content-->
         <div class="col">
            <div class="card">
               <h4 class="card-header">
               
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
                         
                       
                       
                        <!-- <div align = "right">
                           <a id="myBtn2" href = "{{url('agent/downloadPDF/'.Request::segment(4))}}" class = "btn btn-danger">Download Invoice</a>
                        </div> -->
                        <div class="row" >
                           <div class="col-md-12">
                              <div class="card">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-sm-6">
                                         @php ($allTotal = 0)  
                                         @foreach($bookingslist as $data)
                                          <?php $faredecode =  json_decode($data->fare_quote);?>
                                          @php($allTotal += $bookingslist['0']->total)
                                          @endforeach
                                          <div class="panel panel-primary">
                                                <?php //echo "<pre>";print_r($bookingslist[0]['users_bookings']['user_details']->agentname);exit;?>
                                              @forelse($bookingslist[0]['booking_details'] as $bookingdetails)
                                              <div class="panel-heading"><strong>{{title_case($bookingslist[0]['users_bookings']['user_details']->agentname)}} </strong></div>
                                             <div class="panel-body">
                                                <table class="table-responsive">
                                                   <tr>
                                                      <th>email: </th>
                                                      <td>{{$bookingslist['0']->users_bookings['email']}}</td>
                                                   </tr>
                                                   <tr>
                                                      <th>mobile: </th>
                                                      <td>{{$bookingslist['0']->users_bookings['mobile']}}</td>
                                                   </tr>
                                                   <tr>
                                                      <th>Address: </th>
                                                      <td> {{title_case($bookingslist['0']->users_bookings['fulladdress'])}} - {{$bookingslist['0']->users_bookings['pincode']}}</td>
                                                   </tr>
                                                </table>
                                             </div>
                                             @empty
                                             @endforelse
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="panel panel-primary">
                                             <div class="panel-heading"><strong></strong></div>
                                             <div class="panel-body">
                                                <h3 class = "text-right">Invoice</h3>
                                                <p class = "text-right">invoice Number : {{preg_replace('/[A-Z]+/', '', $bookingslist['0']->BookingId)}} </p>
                                                <!-- <p class = "text-right">Date Added : -->
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
                                                         <td>{{date('j-M-Y H:i:s',strtotime($bookingslist['0']->created_at))}}</td>
                                                         <td>{{$allTotal}}</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                
                                             </div>
                                          </div>
                                       </div>
                                    </div>
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
                                                     @foreach($bookings[0] as $decode)
                                                      <tr> 
                                                         <td>{{$decode->Airline->FlightNumber}}{{$decode->Airline->AirlineName}}</td>
                                                         <td>{{$bookingslist[0]->pnr}}</td>
                                                         <td>{{date('j-M-Y H:i:s',strtotime($decode->Origin->DepTime))}}</td>
                                                         <td>{{$decode->Origin->Airport->AirportName}}-{{$decode->Origin->Airport->CityName}},{{$decode->Origin->Airport->CountryName}}</td>
                                                         <td>{{floor($decode->Duration / 60).' hrs:'.($decode->Duration -   floor($decode->Duration / 60) * 60).'min'}}</td>
                                                         <td>{{$decode->Destination->Airport->AirportName}}-{{$decode->Destination->Airport->CityName}},{{$decode->Destination->Airport->CountryName}}</td>
                                                      </tr>
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
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->Tax-$faredecode->YQTax}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">YQTax:</td>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->YQTax}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Other Charges</td>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$faredecode->OtherCharges}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Commission</td>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$data->commission}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">TDS</td>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$data->tds}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">Service Charge</td>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$data->service_charge}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">GST</td>
                                                                     <td style=" border-bottom: 1px solid #f1f1f1; padding:10px;">₹ {{$data->gst}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" padding:10px;">Total:</td>
                                                                     <td style=" padding:10px;">₹ {{$data->total_display}}</td>
                                                                  </tr>

                                                                  <tr>
                                                                     <td style=" padding:10px;">Total Payable:</td>
                                                                     <td style=" padding:10px;">₹ {{$data->total}}</td>
                                                                  </tr>
                                                                  
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                         @php($allTotal += $bookingslist['0']->total)
                                                         @php ($i++)
                                                         @endforeach
                                                         <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td align = "right">All Total: ₹ {{$allTotal}}</td>
                                                         </tr>
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
                                             <div class="panel-heading"><strong>Passenger Details</strong></div>
                                             <div class="panel-body">
                                                <table class="table">
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
         </div>
      </div>
      <!-- end content-->
   </div>
   </div>
  </div>
@endsection