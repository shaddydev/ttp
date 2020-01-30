<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administrator</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link href="{{ asset('public/admin/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/css/material-dashboard.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
    <link href="{{ asset('public/admin/css/custom.css') }}" rel="stylesheet">
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
</head>

<body class="">
  
  <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
          <div class="wrapper ">
                @include('admin::partials.sidebar')
                <div class="main-panel">
                    <!-- Navbar -->
                    @include('admin::partials.topnav')
                    <!-- End Navbar -->
                    @yield('admin::content') 
                    @include('admin::partials.footer')
                </div>
            </div>
        <!-- Scripts --> 
        <script src="{{ asset('public/admin/js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/core/bootstrap-material-design.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('public/admin/js/plugins/moment.min.js') }}"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('public/admin/js/plugins/sweetalert2.js') }}"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('public/admin/js/plugins/jquery.validate.min.js') }}"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('public/admin/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('public/admin/js/plugins/bootstrap-selectpicker.js') }}"></script>
         <!-- Select2 -->
        <script src="{{ asset('public/admin/js/select2.full.min.js') }}"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('public/admin/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('public/admin/js/plugins/jquery.dataTables.min.js') }}"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('public/admin/js/plugins/bootstrap-tagsinput.js') }}"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('public/admin/js/plugins/jasny-bootstrap.min.js') }}"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('public/admin/js/plugins/fullcalendar.min.js') }}"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('public/admin/js/plugins/jquery-jvectormap.js') }}"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('public/admin/js/plugins/nouislider.min.js') }}"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <!--<script src="{{ asset('public/admin/libs/core/js/2.4.1/core.js') }}"></script>-->
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('public/admin/js/plugins/arrive.min.js') }}"></script>
        <!--  Google Maps Plugin    -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="{{ asset('public/admin/js/buttons.js') }}"></script>
        <!-- Chartist JS -->
        <script src="{{ asset('public/admin/js/plugins/chartist.min.js') }}"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('public/admin/js/plugins/bootstrap-notify.js') }}"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('public/admin/js/material-dashboard.min.js?v=2.1.0') }}" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <!--<script src="{{ asset('public/admin/assets/demo/demo.js') }}"></script>-->
        <!-- Image Preview -->
        <script src="{{ asset('public/admin/js/statecity.js') }}"></script>
        <script src="{{ asset('public/admin/js/custom.js') }}"></script>
              <script>
                $(document).ready(function() {
                  $().ready(function() {
                    $sidebar = $('.sidebar');

                    $sidebar_img_container = $sidebar.find('.sidebar-background');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');

                    window_width = $(window).width();

                    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                    if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                      if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                      }

                    }

                    $('.fixed-plugin a').click(function(event) {
                      // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                      if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                          event.stopPropagation();
                        } else if (window.event) {
                          window.event.cancelBubble = true;
                        }
                      }
                    });

                    $('.fixed-plugin .active-color span').click(function() {
                      $full_page_background = $('.full-page-background');

                      $(this).siblings().removeClass('active');
                      $(this).addClass('active');

                      var new_color = $(this).data('color');

                      if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                      }

                      if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                      }

                      if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                      }
                    });

                    $('.fixed-plugin .background-color .badge').click(function() {
                      $(this).siblings().removeClass('active');
                      $(this).addClass('active');

                      var new_color = $(this).data('background-color');

                      if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                      }
                    });

                    $('.fixed-plugin .img-holder').click(function() {
                      $full_page_background = $('.full-page-background');

                      $(this).parent('li').siblings().removeClass('active');
                      $(this).parent('li').addClass('active');


                      var new_image = $(this).find("img").attr('src');

                      if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                          $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                          $sidebar_img_container.fadeIn('fast');
                        });
                      }

                      if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                          $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                          $full_page_background.fadeIn('fast');
                        });
                      }

                      if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                      }

                      if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                      }
                    });

                    $('.switch-sidebar-image input').change(function() {
                      $full_page_background = $('.full-page-background');

                      $input = $(this);

                      if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                          $sidebar_img_container.fadeIn('fast');
                          $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                          $full_page_background.fadeIn('fast');
                          $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                      } else {
                        if ($sidebar_img_container.length != 0) {
                          $sidebar.removeAttr('data-image');
                          $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                          $full_page.removeAttr('data-image', '#');
                          $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                      }
                    });

                    $('.switch-sidebar-mini input').change(function() {
                      $body = $('body');

                      $input = $(this);

                      if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                      } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                          $('body').addClass('sidebar-mini');

                          md.misc.sidebar_mini_active = true;
                        }, 300);
                      }

                      // we simulate the window Resize so the charts will get updated in realtime.
                      var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                      }, 180);

                      // we stop the simulation of Window Resize after the animations are completed
                      setTimeout(function() {
                        clearInterval(simulateWindowResize);
                      }, 1000);

                    });
                  });
                });
              </script>
              <script>
                $(document).ready(function() {
                  // Javascript method's body can be found in assets/js/demos.js
                  md.initDashboardPageCharts();

                  md.initVectorMap();

                });
              </script>
              <script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}
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
   <script src="https://maps.googleapis.com/maps/api/js?key= AIzaSyBPOxoqGdov5Z9xJw1SMVa_behLLSPacVM&libraries=places&callback=initAutocomplete"
        async defer></script>
   <!--end google api -->


   
</body>

</html>

<!-- fetching state and city according to country-->
<script type="text/javascript">
    $(document).ready(function() {
        var _token = $('input[name="_token"]').val();
        $("#countrylist").change(function() {
                var country_id = $(this).val();
                   if (country_id != '') {
                            $.ajax({
                               url: APP_URL+'/ajax/get-state',
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
                                url: APP_URL+'/ajax/get-city',
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


                    $(".api-toggle").click(function(){
                        var group = "input:checkbox[name='"+$(this).attr("name")+"']";
                        $(group).prop('checked',false);
                        $(this).prop('checked',true);
                        $.ajax({
                                url: APP_URL+'/ajax/update-settings-api',
                                method: "POST",
                                dataType: 'html',
                                data: {
                                    api_name: $(this).val(),
                                    _token : _token 
                                },
                                success: function(data) {
                                    if (data != '') {
                                       $('.response').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="material-icons">close</i></button><span><b>Settings updated successfully ! </b></span></div>');
                                    }
                                }
                            });
                    });


                    $(".lcc-toggle").change(function(){
                      var ischecked= $(this).is(':checked');
                      var table= $(this).attr('table');
                      var index= $(this).attr('data-id');
                      var value = 1;
                      if(!ischecked)
                         value =  0;
                        $.ajax({
                                url: APP_URL+'/ajax/update-lcc',
                                method: "POST",
                                dataType: 'html',
                                data: {
                                     table: table,
                                     index: index,
                                     value: value,
                                    _token : _token 
                                },
                                success: function(data) {
                                    if (data != '') {
                                       //md.showNotification('bottom','right');
                                       $('.response').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="material-icons">close</i></button><span><b>Settings updated successfully ! </b></span></div>');
                                    }
                                }
                            });
                    });


                    $("#fix_service_id").change(function() {
                          var service = $(this).val();
                          if(service=='1'){
                              $('#airline').removeAttr('disabled');
                           } else {
                              $('#airline').attr('disabled','disabled');
                          }
                          $('.selectpicker').selectpicker('refresh');
                    });

                });
</script>


   <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $(".updatepassword").click(function(e){
         e.preventDefault();
            var agentid = $("input[name=agentid]").val();
            var newpassword = $("input[name=newpassword]").val();
            var confpass = $("input[name=confpass]").val();
            $.ajax({
                type:'POST',
                url:'/admin/updateagentpassword',
                data:{agentid:agentid, newpassword:newpassword, confpass:confpass},
                success:function(data){
                    //alert(data.status);
                    //alert(data.message);
                    if(data.status == '1'){
                        $(".agentpasswordupdatediv").css("color", "green");
                        $('.agentpasswordupdatediv').html(data.message).fadeIn('slow');
                        $('.agentpasswordupdatediv').delay(10000).fadeOut('slow');
                        //$('#myPasswordchange').modal('dismiss');
                    }else{
                        $(".agentpasswordupdatediv").css("color", "red");
                        $('.agentpasswordupdatediv').html(data.message).fadeIn('slow');
                        $('.agentpasswordupdatediv').delay(10000).fadeOut('slow');
                       // $('#myPasswordchange').modal('dismiss');
                    }
                }
            });
    });
</script>


<!-- slug creating -->
<script type="text/javascript">
 $('#slug').bind('keyup keypress blur', function() {  
  var myStr = $(this).val()
   myStr=myStr.toLowerCase();
   myStr=myStr.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"");   //this one
   myStr=myStr.replace(/\s+/g, "-");
   $('#slugvalue').val(myStr); 
 });
</script>
<!-- change aceess URL from access Permission -->
<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}
</script>
<script>
function movetourl(str){
  //alert()
  window.location.href = APP_URL+'/admin/access/permission/'+str
}
</script>

<!-- seldct 2 -->
<script type="text/javascript">
  $(document).ready(function() {
    $('.formgroupselect').select2();
  });
</script>


<!-- date picker-->
<script type="text/javascript">
 $( function() {
    $( "#filterdate" ).datepicker(
      { 
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        minDate: '0',
       }
    );
    $( "#todate" ).datepicker(
      { dateFormat: 'yy-mm-dd',
        changeYear: true,
        minDate: '-1Y',
        maxDate: '0',
       }
    );
    $( "#fromdate" ).datepicker(
      { 
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        minDate: '-1Y',
        maxDate: '0',
        onSelect: function () 
                {
                    var dt2 = $('#todate');
                    var startDate = $(this).datepicker('getDate');
                    var minDate = $(this).datepicker('getDate');
                    var dt2Date = dt2.datepicker('getDate');
                    var dateDiff = (dt2Date + minDate)/(86400 * 1000);
                    startDate.setDate(startDate.getDate() - 30);
                    dt2.datepicker('option', 'minDate', minDate);
            }

       }
    );
    
    $( "#walletfilterdatefrom" ).datepicker(
      { 
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        maxDate: '0',
       }
    );

    $( "#walletfilterdateto" ).datepicker(
      { 
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        maxDate: '0',
       }
    );

  } );
</script>
<script>
$('.btnvalue').click(function(){
  $('input[name=usersid]').val($(this).data("user"));
})
CKEDITOR.replace( 'ckeditor');
</script>
<script>
$(document).ready(function(){
  $(".viewmore").click(function(){
    $(".userdata").toggle();
  });
});
</script>