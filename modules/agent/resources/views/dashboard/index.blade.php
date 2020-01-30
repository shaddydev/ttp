@extends('layouts.app')
@section('title', config('app.name', 'TravelTrip+'))
@section('content')
<div class="home-content">
   <div id="home-slider" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
         @if(count($homesliderinfo)>0)
         <?php $i = 1; ?>
         @foreach($homesliderinfo as $homeslider)
         @if($i == 1)
         <li data-target="#home-slider" data-slide-to="{{ $i }}" class="active"></li>
         @else
         <li data-target="#home-slider" data-slide-to="{{ $i }}"></li>
         @endif
         <?php $i++; ?>
         @endforeach
         @endif
      </ol>
      <!-- The slideshow -->
      <div class="carousel-inner">
         @if(count($homesliderinfo)>0)
         <?php $ij = 1; ?>
         @foreach($homesliderinfo as $homeslider)
         @if($ij == 1)
         <div class="carousel-item active">
            <img src="{{ url('/public/uploads/homeslider/resizepath/'.$homeslider['image']) }}" alt="Los Angeles">
         </div>
         @else
         <div class="carousel-item">
            <img src="{{ url('/public/uploads/homeslider/resizepath/'.$homeslider['image']) }}" alt="Chicago">
         </div>
         @endif
         <?php $ij++; ?>
         @endforeach
         @endif
      </div>
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#home-slider" data-slide="prev">
      <i class="fas fa-chevron-left"></i>
      </a>
      <a class="carousel-control-next" href="#home-slider" data-slide="next">
      <i class="fas fa-chevron-right"></i>
      </a>
   </div>
   <div class="slider-tabs">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12 search-title">
               <h2>{{ ($welcomeinfo['0']['welcome_title']) }}</h2>
            </div>
            <div class="col-md-12">
               <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active show" data-toggle="tab" href="#flight"><i class="fas fa-plane"></i> Flights</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#hotel"><i class="fas fa-hotel"></i> Hotels</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#bus"><i class="fas fa-bus"></i> Bus</a>
                  </li>
               </ul>
               <!-- Tab panes -->
               @include('partials.search')
               <!-- End tab-pane -->
            </div>
         </div>
      </div>
   </div>
</div>
<section class="welcome">
   <div class="container-fluid">
   @if(Auth::User()->hasRole('admin'))
      <div class="row">
         <div class="col-md-12">
            <h2>{{ ($welcomeinfo['0']['welcome_message']) }}</h2>
            <div class="welcome-img"><span><img src="{{ asset('public/images/welcome.png') }}"></span></div>
            <p>{{ ($welcomeinfo['0']['welcome_description']) }}.</p>
            <a href="#" class="know">Know MORE</a><a href="#" class="contact">Contact Now</a>
         </div>
      </div>
      @endif
      <div class="row top-margin">
         @if(count($featureinfo)>0)
         @foreach($featureinfo as $featureinfo)
         <div class="col-md-3">
            <div class="activity">
               <h3><span><img src="{{ url('/public/uploads/features/resizepath/'.$featureinfo['logo']) }}"></span> <span class="special">{{ $featureinfo['title'] }}</span></h3>
               <p>{{ $featureinfo['description'] }}</p>
            </div>
         </div>
         @endforeach
         @endif
      </div>
   </div>
</section>
<section class="service-section">
   <div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <div class="agent-recent">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="recent-title">
                        <h3>Recent Bookings</h3>
                        <p>Get your recently bookings details</p>
                     </div>
                     <div class="recent-booking">
                        <ul class="nav nav-tabs">
                           <li><a data-toggle="tab" class="active" href="#recent-trip">Recent trips</a></li>
                           <li><a data-toggle="tab" href="#upcoming-trip">Upcoming trips</a></li>
                           <li><a data-toggle="tab" href="#past-trip">Past trips</a></li>
                        </ul>
                        <div class="tab-content">
                           <div id="recent-trip" class="tab-pane fade in show active">
                              <div class="table-resposnive">
                                 <table class="table table-stripped">
                                    <thead>
                                       <tr>
                                          <td>Booking Id</td>
                                          <td>PNR Number</td>
                                          <td>Passenger Name</td>
                                          <td>Trip Date</td>
                                          <!-- <td>Action(s)</td> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @forelse($recentbookinglist as $bookings)
                                       @forelse($bookings['booking_details'] as $bookingdetails)
                                       <tr>
                                          <td>{{$bookings['BookingId'] }}</td>
                                          <td>{{$bookings['pnr'] }}</td>
                                          <td>{{$bookingdetails['title'] }} &nbsp; {{$bookingdetails['fname'] }} &nbsp; {{$bookingdetails['lname'] }}</td>
                                          <td>{{$bookings['created_at'] }}</td>
                                          <!-- <td></td> -->
                                       </tr>
                                       @empty
                                       @endforelse
                                       @empty
                                       @endforelse
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div id="upcoming-trip" class="tab-pane fade">
                              <div class="table-resposnive">
                                 <table class="table table-stripped">
                                    <thead>
                                       <tr>
                                          <td>Booking Id</td>
                                          <td>PNR Number</td>
                                          <td>Passenger Name</td>
                                          <td>Trip Date</td>
                                          <!-- <td>Action(s)</td> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @forelse($upcommingbookinglist as $bookings)
                                       @forelse($bookings['booking_details'] as $bookingdetails)
                                       <tr>
                                          <td>{{$bookings['BookingId'] }}</td>
                                          <td>{{$bookings['pnr'] }}</td>
                                          <td>{{$bookingdetails['title'] }} &nbsp; {{$bookingdetails['fname'] }} &nbsp; {{$bookingdetails['lname'] }}</td>
                                          <td>{{$bookings['created_at'] }}</td>
                                          <!-- <td></td> -->
                                       </tr>
                                       @empty
                                       @endforelse
                                       @empty
                                       @endforelse
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div id="past-trip" class="tab-pane fade">
                              <div class="table-resposnive">
                                 <table class="table table-stripped">
                                    <thead>
                                       <tr>
                                          <td>Booking Id</td>
                                          <td>PNR Number</td>
                                          <td>Passenger Name</td>
                                          <td>Trip Date</td>
                                          <!--  <td>Action(s)</td> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @forelse($pastbookinglist as $bookings)
                                       @forelse($bookings['booking_details'] as $bookingdetails)
                                       <tr>
                                          <td>{{$bookings['BookingId'] }}</td>
                                          <td>{{$bookings['pnr'] }}</td>
                                          <td>{{$bookingdetails['title'] }} &nbsp; {{$bookingdetails['fname'] }} &nbsp; {{$bookingdetails['lname'] }}</td>
                                          <td>{{$bookings['created_at'] }}</td>
                                          <!-- <td></td> -->
                                       </tr>
                                       @empty
                                       @endforelse
                                       @empty
                                       @endforelse
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="col-lg-6">
                     <div class="notify-title">
                        <h3>Recent Bookings</h3>
                        <p>Get your recently bookings details</p>
                     </div>
                     <div class="notification">
                        <ul class="nav nav-tabs">
                           <li><a data-toggle="tab" class="active" href="#finance-info">Finance Information</a></li>
                           <li><a data-toggle="tab" href="#contact-info">Contact Information</a></li>
                           <li><a data-toggle="tab" href="#booking-info">Booking Guides</a></li>
                           <li><a data-toggle="tab" href="#other-info">Other</a></li>
                        </ul>
                        <div class="tab-content">
                           <div id="finance-info" class="tab-pane fade in show active">
                              <p><span class="gst-process">Gst Claim Process</span> After Implementation of GST from 01.07.2017. as per industry practice, trade partners has to raise the invoice for GST to claim on lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                           </div>
                           <div id="contact-info" class="tab-pane fade">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                           </div>
                           <div id="booking-info" class="tab-pane fade">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                           </div>
                           <div id="other-info" class="tab-pane fade">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                           </div>
                        </div>
                     </div>
                  </div> -->
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="testimonial-section">
   <div class="container">
   <div class="row">
      <div class='offset-3 col-md-6 text-center'>
         <h2 class="testimonial-title">OUR CLIENT’S WORDS</h2>
      </div>
   </div>
   <div class='row'>
      <div class='col-md-12'>
         <div class="carousel slide" data-ride="carousel" id="quote-carousel">
            <div class="carousel-inner">
               <!-- Quote 1 -->
               @if(count($testimonialinfo)>0)              
               <?php $i = 1; ?>
               @foreach($testimonialinfo as $testimonialinfo)
               @if($i == 1)
               <div class="carousel-item active">
                  @else
                  <div class="carousel-item">
                     @endif
                     <blockquote>
                        <div class="row">
                           <div class="col-sm-2 text-center">
                              <img class="img-circle" src="{{ url('/public/uploads/testimonials/resizepath/'.$testimonialinfo['image']) }}">
                           </div>
                           <div class="col-sm-9 quote">
                              <p>"{{ ($testimonialinfo['description']) }}."</p>
                              <p><span>{{ ($testimonialinfo['username']) }}</span> {{ ($testimonialinfo['designation']) }}</p>
                           </div>
                        </div>
                     </blockquote>
                  </div>
                  <?php $i++; ?>
                  @endforeach
                  @endif
               </div>
               <!-- Carousel Buttons Next/Prev -->
               <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
               <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="ad-baner">
   <div class="ad-ban">
      <img src="{{ url('/public/uploads/banner/resizepath/'.$bannerinfo['0']['banner_image']) }}">
   </div>
</section>
@endsection