<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="travelTrip"  >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  <title>{{ config('app.name', 'TravelTrip+') }}</title> -->
    <title> @yield('title')</title>
    <!-- Styles -->
    <!--<link href="{{ asset('public/css/app.css') }}" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,500,500i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/angularjs-slider/7.0.0/rzslider.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/range-slider.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/navbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet" />
    <script src="//cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>
    
    <!-- Scripts -->
</head>

<body>

  <!-- helper for sitevalues-->
    @php
      $getsitedata = getsiteinfo();
      $gettextualpagedata = gettextualpages();
      $getaboutusfooterdata = getaboutusfooter();
      @endphp
         
      <div class="site-wrapper">
         @if (Auth::guest())
         <div class="topmenu">
            <div>
               <ul class="topleft">
                  <li><i class="fas fa-phone"></i> Any Questions? Call Us: <a href="#">{{ ($getsitedata['1']->value) }}</a></li>
               </ul>
            
               <ul class="topright">
                   <!-- Authentication Links -->
                      @if (Auth::guest())
                            <li class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><!-- <i class="fas fa-user-circle"></i>  -->Login
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('login') }}">Login As User</a></li>
                                    <li><a href="{{ url('agent/login') }}">Login As Agent</a></li>
                                    <li><a href="{{ url('agent/login?type=corporate') }}">Corporate Login</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->fname }}  {{ Auth::user()->lname }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
            </div>
         </div>
         @endif
         @if(Request::url() !== URL::to('/') && Request::url() !== URL::to('home'))
            <div class="home-content mainHeader">
                @if (Auth::guest())
                    @include('headerGuest')
                @else
                    @include('headerUser')
                @endif
            </div>
            <div class="contentWrapper" style="position:relative;">
          @endif
        @yield('content')
        @yield('page-script')
    </div>
        </div>
        <footer>
          <div class="top-footer">
              <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-content">
                      <h5><span>About us</span></h5>
                      <p>
                        {{($getaboutusfooterdata['0']->welcome_short_description)}}
                      </p>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-menu">
                      <h5><span>Quick Links</span></h5>
                      <ul class="d-flex flex-wrap">
                          <li><a href=""><i class="fas fa-chevron-right"></i> Home
                            </a>
                          </li>
                          <li><a href="#"><i class="fas fa-chevron-right"></i> Flight
                            </a>
                          </li>
                          <li><a href="#"><i class="fas fa-chevron-right"></i> Bus
                            </a>
                          </li>
                          <li><a href="#"><i class="fas fa-chevron-right"></i> Hotel</a></li>
                      </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-contact">
                      <h5><span>Contact Info</span></h5>
                      <ul>
                          <li><a><i class="fas fa-map-marker-alt"></i> {{ ($getsitedata['4']->value) }}</a>
                          </li>
                          <li><a href="tel:{{ ($getsitedata['2']->value) }}"><i class="fas fa-phone"></i> {{ ($getsitedata['2']->value) }}</a></li>
                          <li><a href="mailto:{{ ($getsitedata['5']->value) }}"><i class="fas fa-envelope"></i> {{ ($getsitedata['5']->value) }}</a></li>
                      </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-newsletter">
                      <h5><span>Social Media</span></h5>
                      <ul class="footer-social">
                          <li class="facebook"><a href="{{ ('page/'.$getsitedata['6']->value) }}"><i class="fab fa-facebook-f"></i></a></li>
                          <li class="twitter"><a href="{{ ('page/'.$getsitedata['7']->value) }}"><i class="fab fa-twitter"></i></a></li>
                          <li class="insta"><a href="{{ ('page/'.$getsitedata['8']->value) }}"><i class="fab fa-instagram"></i></a></li>
                          <li class="youtube"><a href="{{ ('page/'.$getsitedata['9']->value) }}"><i class="fab fa-pinterest-p"></i></a></li>
                      </ul>
                      <img src="{{ url('/public/uploads/siteinfo/resizepath/'.$getsitedata['0']->value) }}">		
                    </div>
                </div>
              </div>
          </div>
          <div class="bottom-footer">
              <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                      <p>{{ ($getsitedata['3']->value) }}.</p>
                    </div>
                    <div class="col-md-6">
                      <ul>
                          @if(count($gettextualpagedata)>0)
                            @foreach($gettextualpagedata as $texpage)
                              <li><a href="{{ url('page/'.$texpage->slug) }}">{{ ($texpage->page_name) }}</a></li>
                            @endforeach
                          @endif
                          <li><a href="{{ url('contactus') }}">Contact Us</a></li>
                      </ul>
                    </div>
                </div>
              </div>
          </div>
        </footer>
      
    <!-- Scripts -->
     <script src="{{ asset('public/js/app.js') }}"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.6/angular-filter.js"></script>
    <!-- Angular Material requires Angular.js Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-messages.min.js"></script>
    <!-- Angular Material Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs-slider/7.0.0/rzslider.min.js"></script>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".updatepassword").click(function(e){
         e.preventDefault();
            var oldpassword = $("input[name=oldpassword]").val();
            var newpassword = $("input[name=newpassword]").val();
            var confpass = $("input[name=confpass]").val();
            $.ajax({
                type:'POST',
                url:'/agent/updatepassword',
                data:{oldpassword:oldpassword, newpassword:newpassword, confpass:confpass},
                success:function(data){
                    //alert(data.status);
                    //alert(data.message);
                    if(data.status == '1'){
                        $(".agentpasswordupdatediv").css("color", "green");
                        $('.agentpasswordupdatediv').html(data.message).fadeIn('slow');
                        $('.agentpasswordupdatediv').delay(10000).fadeOut('slow');
                        //$('#myPasswordchange').modal('dismiss');
                    }else{
                        $(".agentpasswordupdatediv").css("color", "green");
                        $('.agentpasswordupdatediv').html(data.message).fadeIn('slow');
                        $('.agentpasswordupdatediv').delay(10000).fadeOut('slow');
                       // $('#myPasswordchange').modal('dismiss');
                    }
                }
            });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('focus' , '.airport_list_up,.airport_list_down'  ,function(){
        //$('.airport_list_up,.airport_list_down').focus(function() {
        var index = $(this);
        index.css("z-index", "2147483647");
        index.autocomplete({
                        source: '/flights/get-airport-list-json?key='+$(this).val(),
                        select: function (event, ui) {
                            this.value = ui.item.value;
                            this.cc = ui.item.cc;
                            if(event.target.id == 'origin'){
                              $("input[name=oct]").val(this.cc);
                            }
                            if(event.target.id == 'destination'){
                              $("input[name=dct]").val(this.cc);
                            }
                             event.preventDefault();
                            var destinate  = $('#destination').val();
                            var originate  = $('#origin').val();
                             
                            if((originate.length != 0) && (originate.indexOf('-')>0)){
                              $("input[name=origin]").val(originate.substr(0,originate.indexOf('-')));
                             }

                             if ((destinate.length != 0) && (destinate.indexOf('-')>0)){
                               $("input[name=destination]").val(destinate.substr(0,destinate.indexOf('-')));
                             }
                           
                            
                        }
                    })
        });
        $(document).on('keyup' , '.airport_list_up,.airport_list_down'  ,function(){
        //$('.airport_list_up,.airport_list_down').keyup(function() {
        var index = $(this);
        index.css("z-index", "2147483647");
        index.autocomplete({
                        source: '/flights/get-airport-list-json?key='+$(this).val(),
                        select: function (event, ui) {
                            this.value = ui.item.value;
                            this.cc = ui.item.cc;
                            if(event.target.id == 'origin'){
                              $("input[name=oct]").val(this.cc);
                            }
                            if(event.target.id == 'destination'){
                              $("input[name=dct]").val(this.cc);
                            }
                             event.preventDefault();
                            var destinate  = $('#destination').val();
                            var originate  = $('#origin').val();
                             
                            if((originate.length != 0) && (originate.indexOf('-')>0)){
                              $("input[name=origin]").val(originate.substr(0,originate.indexOf('-')));
                             }

                             if ((destinate.length != 0) && (destinate.indexOf('-')>0)){
                               $("input[name=destination]").val(destinate.substr(0,destinate.indexOf('-')));
                             }
                           
                            
                        }
                    })
        });
        
        $(document).on('keydown' , '.airport_list_up,.airport_list_down'  ,function(){
        //$('.airport_list_up,.airport_list_down').keydown(function() {
        var index = $(this);
        index.css("z-index", "2147483647");
        index.autocomplete({
                        source: '/flights/get-airport-list-json?key='+$(this).val(),
                        select: function (event, ui) {
                            this.value = ui.item.value;
                            this.cc = ui.item.cc;
                            if(event.target.id == 'origin'){
                              $("input[name=oct]").val(this.cc);
                            }
                            if(event.target.id == 'destination'){
                              $("input[name=dct]").val(this.cc);
                            }
                             event.preventDefault();
                            var destinate  = $('#destination').val();
                            var originate  = $('#origin').val();
                             
                            if((originate.length != 0) && (originate.indexOf('-')>0)){
                              $("input[name=origin]").val(originate.substr(0,originate.indexOf('-')));
                             }

                             if ((destinate.length != 0) && (destinate.indexOf('-')>0)){
                               $("input[name=destination]").val(destinate.substr(0,destinate.indexOf('-')));
                             }
                    }
             })
        });
        
                
        $('#depart_date').datepicker({
            dateFormat: "dd-M-yy",
            format:"yyyy/mm/dd",
            minDate: 0,
                onSelect: function () 
                {
                    var dt2 = $('#return_date');
                    var startDate = $(this).datepicker('getDate');
                    var minDate = $(this).datepicker('getDate');
                    var dt2Date = dt2.datepicker('getDate');
                    //difference in days. 86400 seconds in day, 1000 ms in second
                    var dateDiff = (dt2Date - minDate)/(86400 * 1000);
                    startDate.setDate(startDate.getDate() + 365);
                    //sets dt2 maxDate to the last day of 365 days window
                    dt2.datepicker('option', 'maxDate', startDate);
                    dt2.datepicker('option', 'minDate', minDate);
            }
        });

        $('#return_date').datepicker({
            dateFormat: "dd-M-yy",
            format:"yyyy/mm/dd",
            minDate: 0
        });

        $('#agentprofileinfo').click(function(e){
            e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var datastring = $("#agentprofile").serialize();
                var gender = $("select[name=gender]").val();
                var fname = $("input[name=fname]").val();
                var lname = $("input[name=lname]").val();
                var email = $("input[name=email]").val();
                var countrycode = $("select[name=countrycode]").val();
                var phonenumber = $("input[name=phonenumber]").val();
                var country = $("select[name=country]").val();
                var state = $("select[name=state]").val();
                var city = $("select[name=city]").val();
                var pincode = $("input[name=pincode]").val();
                var fulladdress = $("textarea[name=fulladdress]").val();
            jQuery.ajax({
                  url: "{{ url('/agent/updateprofile') }}",
                  method: 'post',
                  //data: {datastring:datastring, email:email},
                  data: {gender:gender, fname:fname, lname:lname, email:email, countrycode:countrycode, phonenumber:phonenumber, country:country, state:state, city:city, pincode:pincode, fulladdress:fulladdress},
                  success: function(data){
                       console.log(data);
                       if(data.status == '1'){
                            $("#profileupateddiv").css("color", "green");
                            $('#profileupateddiv').html(data.message).fadeIn('slow');
                            $('#profileupateddiv').delay(10000).fadeOut('slow');
                       }else{
                            $("#profileupateddiv").css("color", "green");
                            $('#profileupateddiv').html(data.message).fadeIn('slow');
                            $('#profileupateddiv').delay(10000).fadeOut('slow');
                       }
                    }
                    
            });
        });
        var _token = $('input[name="_token"]').val();
            $("#countrylist").change(function() {
                var country_id = $(this).val();
                   if (country_id != '') {
                            $.ajax({
                               url: '/ajax/get-state',
                                method: "POST",
                                dataType: 'html',
                                data: {
                                    country_id: country_id,
                                    _token : _token 
                                },
                                success: function(data) {
                                    //var count_data = Object.keys(data).length;
                                    if (data != '') {
                                        $('select[name="state"]').empty();
                                        $('select[name="city"]').empty();
                                       // $.each(data, function(key, value) {
                                                $('select[name="state"]').html(data);
                                                $('.selectpicker').selectpicker('refresh');
                                      //  });
                                    } else {
                                        $('select[name="state"]').empty();
                                        $('select[name="city"]').empty();
                                    }
                                }
                            });
                        } else {
                            $('select[name="state"]').empty();
                            $('select[name="city"]').empty();

                        }

                    });



            //city
            $(".statelist").change(function() {
                        var state_id = $(this).val();
                          if (state_id != '') {
                            $.ajax({
                                url: '/ajax/get-city',
                                method: "POST",
                                dataType: 'html',
                                data: {
                                    state_id: state_id,
                                    _token : _token 
                                },
                                success: function(data) {
                                   // var count_data = Object.keys(data).length;
                                    if (data != '') {
                                        $('select[name="city"]').empty();
                                         //$.each(data, function(key, value) {
                                                $('select[name="city"]').html(data);
                                                $('.selectpicker').selectpicker('refresh');
                                       // });
                                    } else {
                                        $('select[name="city"]').empty();
                                    }
                                }
                            });
                        } else {
                            $('select[name="city"]').empty();
                        }
                    });

    });

</script>


 <!--googleapi -->

 <script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

var componentForm = {
 // street_number: 'short_name',
 // route: 'long_name',
 // locality: 'long_name',
//  administrative_area_level_1: 'short_name',
 // country: 'long_name',
 // postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
      autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'), {types: ['geocode']});

    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    autocomplete.setFields(['address_component']);

    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
    </script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key= AIzaSyBPOxoqGdov5Z9xJw1SMVa_behLLSPacVM&libraries=places&callback=initAutocomplete"
      ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https:////cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/js/custom_ng.js') }}"></script>
    <script src="{{ asset('public/js/hotel.js') }}"></script>
    <script src="{{ asset('public/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('public/js/range-slider.js') }}"></script>
    <script src="{{ asset('public/js/main.js') }}"></script>
   <!--end google api -->

   <script>
  $(document).ready(function(){

      $('#adult_plus').click(function(){
        var current = $('#adult_count').val();
       $('#adult_count').val(+ current + +1);
       //alert(+$('#adult_count').val() + +$('#child_count').val())
       if(+$('#adult_count').val() + +$('#child_count').val() >8){
           $('#msgbox').text('Upto 9 passengers allowed');
           $('#adult_plus').css("pointer-events", "none");
           $('#child_plus').css("pointer-events", "none");
       }
       $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
      });
      $('#adult_minus').click(function(){
        var current = $('#adult_count').val();
        if(current>1){
        $('#adult_count').val(current - 1);
        }
        var infant = $('#infant_count').val();
        if(infant>=current)
        {
           $('#infant_count').val('0');
        }
        
        $('#msgbox').text('');
        $("#adult_plus").css("pointer-events", "auto");
        $('#child_plus').css("pointer-events", "auto");
        $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
      })
      // child
      $('#child_plus').click(function(){
        var child = $('#child_count').val();
       $('#child_count').val(+ child + +1);
       if(+$('#adult_count').val() + +$('#child_count').val() >8){
           $('#msgbox').text('Upto 9 passengers allowed');
           $('#child_plus').css("pointer-events", "none");
           $('#adult_plus').css("pointer-events", "none");
       }
       $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
      });
      $('#child_minus').click(function(){
        var child = $('#child_count').val();
        if(child>0){
        $('#child_count').val(child - 1);
        $('#msgbox').text('');
        $("#adult_plus").css("pointer-events", "auto");
        $('#child_plus').css("pointer-events", "auto");
        }
        $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
      })
      // infant
      $('#infant_plus').click(function(){
        var current = $('#infant_count').val();
        if($('#adult_count').val() > current){
       $('#infant_count').val(+ current + +1);
        }
        $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
      });
      $('#infant_minus').click(function(){
        var current = $('#infant_count').val();
        if(current>0){
        $('#infant_count').val(current - 1);
        }
        $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
      })
      // hotel
      $('#tour_adult_plus').click(function(){
        var current = $('#tour_adult_count').val();
       $('#tour_adult_count').val(+ current + +1);
       $('#people').text(+$('#tour_adult_count').val() + +$('#tour_child_count').val());
      });
      $('#tour_adult_minus').click(function(){
        var current = $('#tour_adult_count').val();
        if(current>1){
        $('#tour_adult_count').val(current - 1);
        }
        $('#people').text(+$('#tour_adult_count').val() + +$('#tour_child_count').val());
      })
      
      $('#tour_child_plus').click(function(){
        var current = $('#tour_child_count').val();
       $('#tour_child_count').val(+ current + +1);
       $('#people').text(+$('#tour_adult_count').val() + +$('#tour_child_count').val());
      });
      $('#tour_child_minus').click(function(){
        var current = $('#tour_child_count').val();
        if(current>0){
        $('#tour_child_count').val(current - 1);
        }
        $('#people').text(+$('#tour_adult_count').val() + +$('#tour_child_count').val());
      })
      //Bus
      $('#seat_plus').click(function(){
        var current = $('#seat_count').val();
       $('#seat_count').val(+ current + +1);
      });
      $('#seat_minus').click(function(){
        var current = $('#seat_count').val();
        if(current>1){
        $('#seat_count').val(current - 1);
        }
        $('.tour-count-val').text(+$('#modeladult_count').val() + +$('#modelchild_count').val() + +$('#modelinfant_count').val());
      })
  });
  
   
   </script>
   <script>
   $(document).ready(function(){

    $(document).on("click","#modeladult_plus",function() {
        var current = $('#modeladult_count').val();
       $('#modeladult_count').val(+ current + +1);
        if(+$('#modeladult_count').val() + +$('#modelchild_count').val() >8){
           $('#modelmsgbox').text('Upto 9 passengers allowed');
           $('#modeladult_plus').css("pointer-events", "none");
           $('#modelchild_plus').css("pointer-events", "none");
       }
       $('.tour-count-val').text(+$('#adult_count').val() + +$('#child_count').val() + +$('#infant_count').val());
        });

        $(document).on("click","#modeladult_minus",function() {
        var current = $('#modeladult_count').val();
        if(current>1){
        $('#modeladult_count').val(current - 1);
        }
        var infant = $('#modelinfant_count').val();
        if(infant>=current)
        {
           $('#modelinfant_count').val('0');
        }
        
        $('#modelmsgbox').text('');
        $("#modeladult_plus").css("pointer-events", "auto");
        $('#modelchild_plus').css("pointer-events", "auto");
        $('.tour-count-val').text(+$('#modeladult_count').val() + +$('#modelchild_count').val() + +$('#modelinfant_count').val());
      })


       // child
       $(document).on("click","#modelchild_plus",function() {
        var child = $('#modelchild_count').val();
       $('#modelchild_count').val(+ child + +1);
       if(+$('#modeladult_count').val() + +$('#modelchild_count').val() >8){
           $('#modelmsgbox').text('Upto 9 passengers allowed');
           $('#modelchild_plus').css("pointer-events", "none");
           $('#modeladult_plus').css("pointer-events", "none");
       }
       $('.tour-count-val').text(+$('#modeladult_count').val() + +$('#modelchild_count').val() + +$('#modelinfant_count').val());
      });
      $(document).on("click","#modelchild_minus",function() {
        var child = $('#modelchild_count').val();
        if(child>0){
        $('#modelchild_count').val(child - 1);
        $('#modelmsgbox').text('');
        $("#modeladult_plus").css("pointer-events", "auto");
        $('#modelchild_plus').css("pointer-events", "auto");
        }
        $('.tour-count-val').text(+$('#modeladult_count').val() + +$('#modelchild_count').val() + +$('#modelinfant_count').val());
      })

      //Infant
      $(document).on("click","#modelinfant_plus",function() {
        var current = $('#modelinfant_count').val();
        if($('#modeladult_count').val() > current){
       $('#modelinfant_count').val(+ current + +1);
        }
        $('.tour-count-val').text(+$('#modeladult_count').val() + +$('#modelchild_count').val() + +$('#modelinfant_count').val());
      });
      $(document).on("click","#modelinfant_minus",function() {
        var current = $('#modelinfant_count').val();
        if(current>0){
        $('#modelinfant_count').val(current - 1);
        }
        $('.tour-count-val').text(+$('#modeladult_count').val() + +$('#modelchild_count').val() + +$('#modelinfant_count').val());
      });
 
   });
  
   </script>

<script>

$(document).on("click","#departdate",function() {
  $( "#departdate" ).datepicker();
})
 
 
  </script>
  <script>
  $('#footer-border').hide();
  var firstprice = 0;
  var secondprice = 0;
  var total = 0;
  var resultindexst ='';
  var resultindex ='';
  var searchindex ='';
  $(document).on("click",".getlist",function() {
    $('#footer-border').show();
    $('.ones').show();
    var fligtname =  $(this).next().children().children().children('.flight-logo').children().attr('src');
    var duration = $(this).next().find('.flight-Bdur').text();
    var depart = $(this).next().children().children('.flight-Bdepart').text();
    var arraive = $(this).next().children().children('.flight-Bariv').text();
     getprice =  $(this).next().children().children('.flight-Bprice-hidden').val();
     resultindexst = $(this).next().next().val();
     //alert(fligtname);
    firstprice = getprice.substring(2);
    
    total = +firstprice+ + +secondprice;
    // alert(total);
    $('#depart').text(depart);
    $('#arrive').text(arraive);
    $('#duration').text(duration);
    $('#totalprice').text(total);
    $('#flightlogo').attr('src',fligtname);
})
$('#booknow').parent().hide();
$(document).on("click",".returnlist",function() {
  $('.two').show()
  $('#footer-border').show();
  $('#booknow').parent().show();
    var rduration = $(this).next().find('.flight-Bdur').text();
    var rdepart = $(this).next().children().children('.flight-Bdepart').text();
    var rarraive = $(this).next().children().children('.flight-Bariv').text();
    var rfligtname =  $(this).next().children().children().children('.flight-logo').children().attr('src');
    gotprice = $(this).next().children().children('.flight-Bprice-hidden').val()
    resultindex = $(this).next().next().val();
    searchindex = $(this).next().next().next().val();
    
    secondprice = gotprice.substring(2);
    total = +firstprice+ + +secondprice;
    // alert(firstprice);
    // alert(secondprice);
     //alert(rfligtname);
    $('#rdepart').text(rdepart);
    $('#rarrive').text(rarraive);
    $('#rduration').text(rduration);
    $('#totalprice').text(total);
    $('#rflightlogo').attr('src',rfligtname);
    
    $(document).on("click","#booknow",function() {
    var url = window.location.origin+"/book-now?searchIndex="+searchindex+"&itemId="+resultindexst+','+resultindex;
    window.location.href=url;
    
    // $('#resultsindex').attr('ng-click="bookNow('+resultindex+));
})
});




  </script>

  <script>
   $('#airlineSliderss').owlCarousel({
                loop: true,
                margin: 10,
                nav:true,
                dots:false,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 2,
                    nav: true,
                    dots:false,
                  },
                  600: {
                    items: 3,
                    nav: true,
                    dots:false,
                  },
                  1000: {
                    items: 5,
                    nav: true,
                    loop: true,
                    margin: 20
                  }
                }
              });   


    $(document).on("click",".getcheckbox",function() {  
      
      //$('input[type="checkbox"]').each(function(){ $(this).prop('checked',false).trigger( "click" )})
      var id = $(this).children().val();
     // alert(id);
     $('#'+id).trigger( "click" );
    });  
  </script>
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
<script>
 $(document).on("click","#showcommision",function() {
    var inputs = $(".commision");
    var common=[];
   // alert("{{ url('/ajax/getcomission') }}")
    //console.log(inputs);
    for(var i = 0; i < inputs.length; i++){
   // console.log($(inputs[i]).val());
    common.push($(inputs[i]).val());
     }
    //console.log(common);
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
       url : "{{ url('/ajax/getcomission') }}",
      type: "POST",
      data: {'key':common},     
      success: function(data) {
      console.log(data);
    },
    error:function(error){
      console.log('error');
    }
  })
 });
</script>
<script>
  $(document).on("click",".farequotes",function() {
    var rindex = $(this).data("resultindex");
    $.ajax({
      url : "{{ url('/farequote') }}",
      type: "POST",
      data: {'rindex':rindex},     
      success: function(data) {
        response = JSON.parse(data).Response;
         //console.log(response.FareRules[0]);
        
        //var resp = (data);
        $('.fareq').html(response.FareRules[0].FareRuleDetail);
       //console.log(resp['Response']);
      }
    });
  });
</script>
<script>
      $(window).on("load", function(){
       var mainHH = $('.mainHeader').outerHeight();
       var footH = $('footer').outerHeight();
       var hfHeight = mainHH+ + +footH;
       var windowH = $(window).height();
       $('.contentWrapper').css("min-height", windowH - hfHeight);
      });
    </script>
    <script>
    
    
    $(document).on('change','.baggages',function(){
      var bagamount = 0 ;
      var bag = 0;
      $('.baggages').each(function(i){
        bag =  $('option:selected',this).text().split("-").pop();
        if(bag != '')
        {
          bagamount  += parseInt(bag.split("₹").pop());
        }else{
          bagamount += 0;
        }
       
        
      });
      //alert(bagamount);
     
     var totalpay = parseInt($('#hidenpay').text().split("₹").pop());
     
     //alert(totalpay);
     var totalpayamont = totalpay+bagamount
     $('.Totalpay').text("₹" + totalpayamont);
     $('#bag').html('<div class = "col-8"><div class="base">Baggage</div></div><div class = "col-4"><div class="base-fare">₹'+bagamount+'</div></div>');
      
    })
    </script>

    @yield ('footer_scripts')

</body>
</html>