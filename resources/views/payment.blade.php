@extends('layouts.app')

@section('content')

<?php 
$Baggageprice = 0;
if(!empty($Baggage)){
  
  
  $i = 0 ;foreach($Baggage as $bgdata){
      // $bdata = json_decode($bgdata,JSON_UNESCAPED_SLASHES);
      foreach($bgdata as $data)
       foreach($data as $row){
        //echo "<pre>"; print_r($row);
        $Baggageprice +=  json_decode($row)->Price;
       }
    
      
      
  $i++;}
}

?>

<section class="booking">

          <div class="container-fluid">
            <div class="row">
              <div class="col-md-8">
              @include('message')
                <div class="row review-div">
                    <div class="col-md-9 box-title"><i class="far fa-credit-card"></i> Payment Method  </div>
                    <div class="col-md-3" > Time left : <b class="Timer" ></b>  </div>
                </div>
                <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                  @if (!Auth::guest())
                    <li><a href="#home" data-toggle="tab" class="active">Credit Wallet</a></li>
                    <li><a href="#about" data-toggle="tab">Cash Wallet</a></li>
                    <li><a href="#services" data-toggle="tab">Pay Online</a></li>
                  @else
                    <li><a class="active" href="#services" data-toggle="tab">Pay Online</a></li>
                  @endif
                  
                </ul>
        <div class="tab-content">
                @if (!Auth::guest())
                  <div class="tab-pane active" id="home">                
                    <div class="">
                    <p class="payWith">Pay with Your Credit Wallet</p>  
                    <p class="balance">Your Credit Wallet Balance is {{$user->user_details->credit}} INR</p> 
                      <div class="amountPay">
                        <form method="post" action="{{url('payment/checkout-submit')}}"  >
                        <i class="fas fa-rupee-sign"></i> {{$final_total+$Baggageprice}}
                        {!! csrf_field() !!}
                        <input type="hidden"  name="walletType" value="{{$final_total > $user->user_details->advance ? 2 : 4}}" />
                        @if($user->user_details->credit < $final_total+$Baggageprice && $user->user_details->advance < $final_total+$Baggageprice)
                        <a href="#" class="payNow disabled">Pay Now</a>
                        @else
                        <button type='submit'  class="payNow doCheckout">Pay Now</button>
                        @endif
                        </form>
                      </div>  
                    <p class="byClick">By clicking on Pay Now, you are agreeing to our Term &amp; Conditions and Privacy policy</p>      
                    </div>
                  </div> 
                  <div class="tab-pane" id="about"> 
                    <div class="">
                    <p class="payWith">Pay with Your Cash Wallet</p>  
                    <p class="balance">Your Cash Wallet Balance is {{$user->user_details->cash}} INR</p> 
                        <div class="amountPay">
                        <form method="post" action="{{url('payment/checkout-submit')}}"  >
                        <i class="fas fa-rupee-sign"></i> {{$final_total+$Baggageprice}}
                        {!! csrf_field() !!}
                        <input type="hidden"  name="walletType" value="1" />
                        @if($user->user_details->cash < $final_total+$Baggageprice)
                        <a href="#" class="payNow disabled">Pay Now</a>
                        @else
                        <button type='submit' class="payNow doCheckout">Pay Now</button>
                        @endif
                        </form>
                    </div>  
                    <p class="byClick">By clicking on Pay Now, you are agreeing to our Term &amp; Conditions and Privacy policy</p> </div>
                  </div>
                  <div class="tab-pane" id="services"> 
                    <div class="">
                    <p class="payWith">Pay with Credit/Debit Card</p>  
                    <div class="amountPay"><i class="fas fa-rupee-sign"></i> {{$final_total+$Baggageprice}}
                    <a href="{{url('payment/pay-online')}}" class="payNow doCheckout">Pay Now</a></div>  
                    <p class="byClick">By clicking on Pay Now, you are agreeing to our Term &amp; Conditions and Privacy policy</p>
                    </div>
                  </div>
                  @else
                  <div class="tab-pane active" id="services"> 
                    <div class="">
                    <p class="payWith">Pay with Credit/Debit Card</p>  
                    <div class="amountPay"><i class="fas fa-rupee-sign"></i> {{$final_total+$Baggageprice}}
                    <a href="{{url('payment/pay-online')}}" class="payNow">Pay Now</a></div>  
                    <p class="byClick">By clicking on Pay Now, you are agreeing to our Term &amp; Conditions and Privacy policy</p>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
                
              </div>
              <div class="col-md-4">
                <div class="paymentBar">
                  <div class="paymentDetails">
                    <h5>Payment Details </h5>
                    <div class="flightPrice">
                      <div class="totalPrice">
                        <div class="totalLeft"><p>Total Flight Price</p></div>
                        <div class="totalRight"><p><i class="fas fa-rupee-sign"></i> {{$final_total}}</p></div>
                      </div>
                      @if($Baggageprice != 0)
                      <div class="totalPrice">
                        <div class="totalLeft"><p>Total Baggage Price</p></div>
                        <div class="totalRight"><p><i class="fas fa-rupee-sign"></i> {{$Baggageprice}}</p></div>
                      </div>
                      @endif
                      <div class="youPay">
                        <div class="totalLeft"><p>You Pay</p></div>
                        <div class="totalRight"><p><i class="fas fa-rupee-sign"></i> {{$final_total+$Baggageprice}}</p></div>
                      </div>
                    </div>
                  </div>

                  <div class="bookingSummary">
                    <h5>Book Summary</h5>
                    
                    @foreach($tripDetails as $tkey=>$tdetail)
                    @foreach($tdetail->Response->Results->Segments as $stkey=>$detail)
                    @foreach($detail as $key=>$moredetail)
                    <div class="flightSummary"  >
                      <div class="flightName">
                      <source media="(min-width: 650px)" srcset="/public/images/airlines/{{$moredetail->Airline->AirlineCode}}.gif">
                      <source media="(min-width: 465px)" srcset="/public/images/airlines/{{$moredetail->Airline->AirlineCode}}.gif">
                      <img src="/public/images/airlines/{{$moredetail->Airline->AirlineCode}}.gif" alt="flight logo" style="width:auto;">
                      <span>{{$moredetail->Airline->AirlineCode}}-{{$moredetail->Airline->FlightNumber}} ({{$moredetail->Airline->FareClass}})</span></div>
                      <div class="flighttoFrom">
                        <div class="flightLocation">
                          <p>{{$moredetail->Origin->Airport->AirportCode}}</p>
                          <span>{{$moredetail->Origin->DepTime}}</span>
                        </div>
                        <!--<div class="flightstops">
                          <p>Stop(s)</p>
                          <span><i class="fas fa-plane"></i></span>
                        </div>-->
                        <div class="flightdestiny">
                        <p>{{$moredetail->Destination->Airport->AirportCode}}</p>
                          <span>{{$moredetail->Destination->ArrTime}}</span>
                        </div>
                       </div>
                     </div>
                      @endforeach
                     @endforeach
                    @endforeach
                  </div>

                  <div class="contactDetails">
                    <h5>Contact Details</h5>
                    <div class="cDetails">
                      <!--
                      @foreach($tickets as $key=>$ticketUser)
                       @foreach($ticketUser as $i=>$udata)
                        <div class="contactPerson">{{$key+1}}. </div>
                       @endforeach
                      @endforeach
                      -->
                      <p><span>Email:</span>{{$user_email}}</p>
                      <p><span>Phone:</span> +{{$countryCode}} - {{$mobileNo}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>


        <div class="modal fade" id="doCheckout" role="dialog">
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please Wait....</h4>
                </div>
                <div class="modal-body">
                    <p>Please wait while we are processing your request</p>
                    <p>Please do not click back or refresh button</p>
                </div>
                <div class="loader-sm" >
                      <p><img class="no-data" src="/public/images/loader-small.gif"></p>
                </div>
              </div>
          </div>
</div>

@endsection


@section('footer_scripts')
  <script type="text/javascript">
     $(".doCheckout").click(function(){
          $('#doCheckout').modal({backdrop: 'static', keyboard: false})  
     });
   </script>
@endsection