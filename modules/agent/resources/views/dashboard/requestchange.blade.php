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
               <h4 class="card-header">My Bookings</h4>
              
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
                        <div class="edit-profile-form">
                           <form method="post" action="" name="requestchange">
                              {{ csrf_field() }}
                              <div class="form-group">
                                 <select class="refundtype form-control" id="refundtype"   name="refundtype" >
                                    <option value="">Select</option>
                                    <option value="1">Full Refund</option>
                                    <option value="2">Change ltinerary / reissue</option>
                                    <option value="3">Partial Refund</option>
                                    <option value="4">Flight Cancellation</option>
                                 </select>
                                 <span class = "text-danger"> {{ $errors->first('refundtype') }}</span>
                              </div>
                              <div class="form-group border p-2">
                                 <strong class="">Please select Refund Sectors of PNR- {{$bookingslist[0]->pnr}}</strong>
                                 <div class="custom-control custom-checkbox mt-1">
                                    <?php //$decode = json_decode($bookingslist['0']->all_details);?>
                                    <?php $decode = json_decode($bookingslist['0']->booking_info);?>
                                    <?php //echo "<pre>";print_r($bookingslist[0]->pnr); exit;?>
                                    <?php $sn = 1; ?>
                                    <input type="checkbox" class="custom-control-input" name="refundsectors[]" id="<?= $sn ?>" value="<?= $sn ?>">
                                    <label class="custom-control-label" for="<?= $sn ?>"><?php echo $decode[0][0]->Origin->Airport->AirportCode. "  -  ".$decode[0][0]->Destination->Airport->AirportCode."  ( ".substr($decode[0][0]->Origin->DepTime,0,strpos($decode[0][0]->Origin->DepTime,'T'))." ) "; ?></label>
                                 </div>
                                 <?php $sn++; ?>
                                 <span class = "text-danger"> {{ $errors->first('refundsectors') }}</span>
                              </div>
                              <div class="form-group border p-2">
                                 <strong>Please select Passengers</strong>
                                 @forelse($bookingsdetailslist['0']->booking_details as $bookingdetails)
                                 <div class="custom-control custom-checkbox mt-1">
                                    <input type="checkbox" class="custom-control-input" name="passengerdata[]" id="{{$bookingdetails['id']}}" value="{{$bookingdetails['id']}}">
                                    <label class="custom-control-label" for="{{$bookingdetails['id']}}">{{$bookingdetails['title']}} &nbsp; {{$bookingdetails['fname']}} &nbsp; {{$bookingdetails['lname']}}</label>
                                 </div>
                                 @empty
                                 @endforelse
                                 <span class = "text-danger"> {{ $errors->first('passengerdata') }}</span>
                              </div>
                              <div class="form-group ">
                                 <strong>Please enter remarks</strong>
                                 <textarea class="form-control" name = "notes"></textarea>
                                 <span class = "text-danger"> {{ $errors->first('notes') }}</span>
                              </div>
                              <div class="form-group">
                                 <strong>Note:</strong>
                                 <ol>
                                    <li>Partial Refund will be processed offline.</li>
                                    <li>In case of Infant booking, cancellation will be processed offline.</li>
                                    <li>In case of One sector to be cancel, please send the offline request.</li>
                                 </ol>
                              </div>
                              <input type="hidden" name="bookingid" value="{{$bookingslist['0']['id']}}">
                        </div>
                        <input type="submit" class="btn btn-primary" name="submitrequestchange">
                     </div>
                     </form>
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