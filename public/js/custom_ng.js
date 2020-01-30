var ngapp = angular.module('travelTrip', ['angular.filter','ngMaterial', 'ngMessages','rzSlider']
    , ['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    }]);
  ngapp.searchIndex = "";

var getParams = function (url) {
    var params = {};
    var parser = document.createElement('a');
    parser.href = url;
    var query = parser.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        params[pair[0]] = decodeURIComponent(pair[1]);
    }
    return params;
  };

ngapp.timeFormatText = function(n) {
    var num = n;
    var hours = (num / 60);
    var rhours = Math.floor(hours);
    var minutes = (hours - rhours) * 60;
    var rminutes = Math.round(minutes);
    return rhours + "h " + rminutes + "m";
};

ngapp.dateFormattext = function(n) {
  var format = new Date(n);
  var months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
  var days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
  var disp =  days[format.getDay()]+','+months[format.getMonth()]+' '+format.getDate();
  return disp;
};

ngapp.timeSlotDisplay = function(hour) {
  var slot = '';
   if(hour <= '06'){
      slot = 'early_morning';
   } else if(hour >= '06' && hour < '12' ){
     slot = 'morning';
   }else if(hour >= '12' && hour < '18' ){
     slot = 'afternoon';
   } else if(hour >= '18' && hour < '24' ){
     slot = 'night';
   }
   return slot;
};

ngapp.dateFormatInput = function(n) {
   var format = new Date(n);
   var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
   var disp =  format.getDate()+'-'+months[format.getMonth()]+'-'+format.getFullYear();
   return disp;
};

ngapp.dateFormatdateMonth = function(n) {
   var format = new Date(n);
   var months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
   var disp =  months[format.getMonth()]+' '+format.getDate();
   return disp;
};


ngapp.priceDisplay = function(price){
   return "₹ "+parseInt(Math.round(price));
}

ngapp.calculateCommission = function(x,y){
  //get the commission value
  var a = (x*y)/100;
  //deduct GST based on 18%
  return (a-((a*18)/100));
}

ngapp.calculateTDS = function(x){
  //TDS 5%
  var a = (x*5)/100;
  return a;
}

ngapp.remarkDisplay = function(content){
  var display  = '';
  /*
    if(content.includes("SME")){
      display = 'SME FARE';
    } else if(content.includes("Flexi")){
      display = 'FLEXI FARE';
    }else if(content.includes("hand bag")){
      display = 'HAND BAG FARE';
    }else if(content==='***'){
      display = 'COUPON FARE';
    }else if(content==='*'){
      display = 'SPECIAL FARE';
    }
    */
    return content;
}

ngapp.controller('flightsController', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {
          $scope.flights = [];
          $scope.calenderFare = [];
          $scope.postData = [];
          $scope.searchResponse = 0;
          $scope.Filter = {};
          $scope.apiError = {};
          $scope.hasError = 0;
          $scope.package_commission = [];
          $scope.timeFormatText = ngapp.timeFormatText;
          $scope.priceDisplay = ngapp.priceDisplay;
          $scope.calculateCommission = ngapp.calculateCommission;
          $scope.calculateTDS = ngapp.calculateTDS;
          $scope.remarkDisplay = ngapp.remarkDisplay;
          $scope.dateFormatdateMonth = ngapp.dateFormatdateMonth;
          $scope.dateFormatInput = ngapp.dateFormatInput;
          $scope.timeSlotDisplay = ngapp.timeSlotDisplay;
          $scope.dateFormattext = ngapp.dateFormattext;
          $rootScope.indexdata = {};
          $scope.service_charge = 0;
          $scope.service_charge_gst = 0;
          $scope.Filter.Price = {};
          
          // List flights
           $scope.loadFlights = function (param,url) {

              $http.post('/flights/search',param).then(function success(e) {
                
                if(e.data.flights.Response.Error.ErrorCode!==0){
                  $scope.hasError = 1;
                  $scope.apiError.errorcode = e.data.flights.Response.Error.ErrorCode;
                  $scope.apiError.errorMessage = e.data.flights.Response.Error.ErrorMessage;
                }

                $scope.flights = e.data.flights;
                $scope.calenderFare = e.data.calenderFare;
                $scope.postData = e.data.postData;
                $scope.service_charge = e.data.fix_services.service_charge;
                $scope.service_charge_gst = e.data.fix_services.service_charge*18/100;
                $scope.searchResponse = 1;
                $scope.orderProperty = "flight.Fare.PublishedFare";
                $scope.flightFilter = '';
                ngapp.searchIndex = e.data.flights.Response.TraceId;
                $scope.package_commission = e.data.package_detail;

                // update calender slider
              
                /*
                var max_index = e.data.flights.Response.Results[0].length-1;
                var  minval = e.data.flights.Response.Results[0][0].Fare.PublishedFare+$scope.service_charge+$scope.service_charge_gst;
                var  maxval = e.data.flights.Response.Results[0][max_index].Fare.PublishedFare+$scope.service_charge+$scope.service_charge_gst;
                */

               var values = [];
               e.data.flights.Response.Results[0].forEach(function (item) {
                     values.push(item.Fare.PublishedFare);
               });
               var  minval = Math.min.apply(Math, values)+$scope.service_charge+$scope.service_charge_gst;
               var  maxval = Math.max.apply(Math, values)+$scope.service_charge+$scope.service_charge_gst;


                $scope.Filter.Price.min = parseInt(minval);
                $scope.Filter.Price.max = parseInt(maxval);

                $scope.priceSlider = {
                  min: minval,
                  max: maxval,
                  options: {
                    id: 'range-slider',
                    floor: minval,
                    ceil: maxval,
                    hideLimitLabels:true,
                     onChange: function(val, minVal, maxVal) {
                      $scope.Filter.Price.min = minVal;
                      $scope.Filter.Price.max = maxVal;
                      $scope.filterFunction(e.data.flights.Response.Results[0][0]);
                     },
                  },
                }

                $(document).ready(function() {

                  $('#monthSlider').owlCarousel({
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
                          items: 2,
                          nav: false,
                          dots:false,
                        },
                        1000: {
                          items: 7,
                          nav: true,
                          loop: true,
                          margin: 20
                        }
                      }
                  });
                  $('#airlineSlider').owlCarousel({
                    loop: true,
                    margin: 10,
                    
                    responsiveClass: true,
                    responsive: {
                      0: {
                        items: 2,
                        
                      },
                      600: {
                        items: 2,
                      
                      },
                      1000: {
                        items: 7,
                      
                        margin: 20
                      }
                    }
                  });
               

                  // date picker
                   $("#chooseDateBtn").on('click',function(){
                    
                   });
                   
                   $("#regularBHD").css("display","block");
                     $("#chooseDateBtn1").on('click',function(){
                   });
                   $("#regularBHD").css("display","block");
                   

                   $( "#datepicker" ).datepicker({
                    numberOfMonths: 1,
                    minDate: 0,
                    dateFormat: "dd-M-yy",
                    onSelect: function (d) {
                    $('#depart_date').val(d);
                    var startDate = Date.parse($('#depart_date').val());
                    var endDate = Date.parse($('#return_date').val());
                    var triptype =  $('input[name=triptype]:checked').val();
                    if(triptype == 'roundtrip'){
                      if (startDate > endDate){
                          $('#reuiredmsg').show();
                          $('#reuiredmsg').text('please choose return date');
                          $('#return_date').val('');
                          $('#return_date').attr('required','required');
                          $('.modify-search').trigger('click');
                      }
                    }
                   $('#datepicker').slideToggle(250);
                    var dt2 = $('#datepicker1');
                    var startDate = $(this).datepicker('getDate');
                    var minDate = $(this).datepicker('getDate');
                    var dt2Date = dt2.datepicker('getDate');
                    //difference in days. 86400 seconds in day, 1000 ms in second
                    var dateDiff = (dt2Date - minDate)/(86400 * 1000);
                    startDate.setDate(startDate.getDate() + 30);
                    //sets dt2 maxDate to the last day of 30 days window
                    dt2.datepicker('option', 'maxDate', startDate);
                    dt2.datepicker('option', 'minDate', minDate);
                    $('.modify').trigger('click');
                     
                }
               
               
                    });

                   // Model popup start
                   $("#modelchooseDateBtn").on('click',function(){
                    
                    $('#modeldepartdate').show();
                   
                   });
                  
                   $("#modelchooseDateBtn1").on('click',function(){
                     $('#modelreturndate').show();
                    
                   });

                   var dateToday = new Date(); 
                   
                $( "#modeldepartdate" ).datepicker({
                    numberOfMonths: 1,
                    minDate: 0,
                    dateFormat: "dd-M-yy",
                    onSelect: function (d) {

                        $('#depart_date').val(d);
                          $('#modeldepartdate').slideToggle(250);
                          var startDate = Date.parse($('#depart_date').val());
                            var endDate = Date.parse($('#return_date').val());
                            var triptype =  $('input[name=triptype]:checked').val();
                            if(triptype == 'roundtrip'){
                              if (startDate > endDate){
                                  $('#reuiredmsg').show();
                                  $('#reuiredmsg').text('please choose return date');
                                  $('#return_date').val('');
                                  $('#return_date').attr('required','required');
                              }
                            }
                            
                            var dt2 = $('#modelreturndate');
                            var startDate = $(this).datepicker('getDate');
                            var minDate = $(this).datepicker('getDate');
                            var dt2Date = dt2.datepicker('getDate');
                            //difference in days. 86400 seconds in day, 1000 ms in second
                            var dateDiff = (dt2Date - minDate)/(86400 * 1000);
                            startDate.setDate(startDate.getDate() + 30);
                            //sets dt2 maxDate to the last day of 30 days window
                            dt2.datepicker('option', 'maxDate', startDate);
                            dt2.datepicker('option', 'minDate', minDate);
                        }
                    });
           
                ///
                var dateToday = new Date(); 
                $( "#modelreturndate" ).datepicker({
                    numberOfMonths: 1,
                    minDate: $('#depart_date').val(),
                  
                dateFormat: "dd-M-yy",
                onSelect: function (d) {
                  $('#return_date').val(d);
                  var startDate = Date.parse($('#depart_date').val());
                    var endDate = Date.parse($('#return_date').val());
                    var triptype =  $('input[name=triptype]:checked').val();
                    if(triptype == 'roundtrip'){
                      if (startDate > endDate){
                          $('#reuiredmsg').show();
                          $('#reuiredmsg').text('Return date can not be less than departure date ');
                        }
                      }
                    $('#modelreturndate').slideToggle(250);
                  }
                });
                
                 // End Model popup

                  var dateToday = new Date(); 
                  $( "#datepicker1" ).datepicker({
                      numberOfMonths: 1,
                      minDate: $('#depart_date').val(),
                      dateFormat: "dd-M-yy",
                      onSelect: function (d) {
                          $('#return_date').val(d);
                          $('.modify').trigger('click');
                          $('#datepicker1').slideToggle(250);
                        }

                  });

                 

                   // Next date
                  $('#nextdate').click(function(){

                  var date = new Date($('#start_date').text());
                  var d = date.getDate() ;
                  var m = date.getMonth() + 1;
                  var y = date.getFullYear();
                  var currentdate = y+'-'+m+'-'+d;
                  //alert(currentdate);
                  var days = 2;
                  var result = new Date(new Date(currentdate).setDate(new Date(currentdate).getDate() + days)); 
                  var newdates =  result.toISOString().substr(0, 10)
                  var mydate = new Date(newdates);
                  var day = mydate.getDate();
                  var month = mydate.getMonth(); // month (in integer 0-11)
                  var year = mydate.getFullYear();
                  var months = ['Jan', 'Feb', 'Mar', 'Apr','May', 'Jun','Jul','Aug','Sept','Oct','Nov','Dec'];
                  var nextday =  day+'-'+months[month] + '-' + year;
                  $('#depart_date').val(nextday);
                  var startDate = Date.parse($('#depart_date').val());
                  var endDate = Date.parse($('#return_date').val());
                  var triptype =  $('input[name=triptype]:checked').val();
                  if(triptype == 'roundtrip'){
                    if (startDate > endDate){
                        $('#reuiredmsg').show();
                        $('#reuiredmsg').text('please choose return date');
                        $('#return_date').val('');
                        $('#return_date').attr('required','required');
                        $('.modify-search').trigger('click');
                    }
                  }
                  $('.modify').trigger('click');
                  //$('#start_date').text(nextday)
                  }) 
                  // Previous date 
                  $('#previous').click(function(){

                  var date = new Date($('#preview_date').text());
                  var d = date.getDate() ;
                  var m = date.getMonth() + 1;
                  var y = date.getFullYear();
                  var currentdate = y+'-'+m+'-'+d;
                  //alert(currentdate);
                  var days = 1;
                  var result = new Date(new Date(currentdate).setDate(new Date(currentdate).getDate() - days)); 
                  var newdates =  result.toISOString().substr(0, 10)
                  var mydate = new Date(newdates);
                  var day = mydate.getDate();
                  var month = mydate.getMonth(); // month (in integer 0-11)
                  var year = mydate.getFullYear();
                  var months = ['Jan', 'Feb', 'Mar', 'Apr','May', 'Jun','Jul','Aug','Sept','Oct','Nov','Dec'];
                  var nextday =  day+'-'+months[month] + '-' + year;

                  $('#return_date').val(nextday);
                  var startDate = Date.parse($('#depart_date').val());
                  var endDate = Date.parse($('#return_date').val());
                  var triptype =  $('input[name=triptype]:checked').val();
                  if(triptype == 'roundtrip'){
                  if (startDate > endDate){
                      $('#reuiredmsg').show();
                      $('#reuiredmsg').text('please choose return date');
                      $('#return_date').val('');
                      $('#return_date').attr('required','required');
                      $('.modify-search').trigger('click');
                  }
                  }
                  $('.modify').trigger('click');
                  //$('#start_date').text(nextday)
                  }) 

                  // Next One 

                  $('#next1').click(function(){

                  var date = new Date($('#preview_date').text());
                  var d = date.getDate() ;
                  var m = date.getMonth() + 1;
                  var y = date.getFullYear();
                  var currentdate = y+'-'+m+'-'+d;
                  //alert(currentdate);
                  var days = 1;
                  var result = new Date(new Date(currentdate).setDate(new Date(currentdate).getDate() + days)); 
                  var newdates =  result.toISOString().substr(0, 10)
                  var mydate = new Date(newdates);
                  var day = mydate.getDate();
                  var month = mydate.getMonth(); // month (in integer 0-11)
                  var year = mydate.getFullYear();
                  var months = ['Jan', 'Feb', 'Mar', 'Apr','May', 'Jun','Jul','Aug','Sept','Oct','Nov','Dec'];
                  var nextday =  day+'-'+months[month] + '-' + year;
                  //alert(nextday);

                  $('#return_date').val(nextday);
                  var startDate = Date.parse($('#depart_date').val());
                  var endDate = Date.parse($('#return_date').val());
                  var triptype =  $('input[name=triptype]:checked').val();
                  if(triptype == 'roundtrip'){
                  if (startDate > endDate){
                    $('#reuiredmsg').show();
                    $('#reuiredmsg').text('please choose return date');
                    $('#return_date').val('');
                    $('#return_date').attr('required','required');
                    $('.modify-search').trigger('click');
                  }
                  }
                  $('.modify').trigger('click');
                  //$('#start_date').text(nextday)
                  }) 
                  // model popup

                  $('#trip').change(function(){
                  var triptype =  $( 'input[name=triptype]:checked' ).val()
                 
                  if(triptype == 'oneway'){
                  $('#return_date').val('');
                  $('#return_date').removeAttr('required');
                  $('#reuiredmsg').hide();
                   $('#roundtripdate').hide();
                  }
                  else{

                  $('#return_date').attr('required','required');
                  $('#return_date').parent().parent().append('');
                  if(($('#return_date').val()) == ''){
                    $('#reuiredmsg').show();
                    $('#roundtripdate').show();
                  }
                  }
                  })

                  // Remove color No. of Stops
                  $('.stop-number').each(function(){
                     $(this).click(function(){
                      if($(this).next().hasClass('ng-not-empty'))
                      {
                          $(this).css({'background':'#ddd','color':'#919191'});
                      }
                      else
                      {
                        $(this).css({'background':'#ff9d02','color':'#fff'})
                      }
                     })
                  })


                  $('.timeSlot').each(function(){
                    $(this).click(function(){
                     if($(this).next().hasClass('ng-not-empty'))
                     {
                       $(this).removeClass('current');
                     }
                     else
                     {
                       $(this).addClass('current');
                     }
                    })
                 })

                  //Departure time

                  $('[data-toggle="tooltip"]').tooltip({html:true}); 

                  // Show Commsion on click 
                  $('.showdatacomission').click(function(){
                      if($(this).prop("checked") == true){
                        $('.showflightcommision').show()
                    }
                    else if($(this).prop("checked") == false){
                      $('.showflightcommision').hide()
                    }
                  });
                  $('.airline-check').click(function(){
                    if($('.showdatacomission').prop('checked') == true){

                      $('.showdatacomission').prop('checked',false);
                     

                      $('.showdatacomission').trigger('click');
                    }
                    else{
                      
                    }
                  });
                });
                    
            }, function error(error) {
            });
         
           };

        var datavals = getParams(window.location.href);
        $scope.loadFlights(datavals,window.location.href);


        //set order 
        $scope.setOrderProperty = function(propertyName) {
            if ($scope.orderProperty === propertyName) {
                $scope.orderProperty = '-' + propertyName;
                console.log('original'+propertyName);
            } else if ($scope.orderProperty === '-' + propertyName) {
                $scope.orderProperty = propertyName;
            } else {
                $scope.orderProperty = propertyName;
            }
        };
  // column to sort
  //$scope.column = propertyName;
  
  // sort ordering (Ascending or Descending). Set true for desending
  $scope.reverse = false;   
  
  // called on header click
  $scope.sortColumn = function(col){
      $scope.column = col;
      
      if($scope.reverse){
          $scope.reverse = false;
          $scope.reverseclass = 'arrow-up';
      }else{
          $scope.reverse = true;
          $scope.reverseclass = 'arrow-down';
      }
  };
  
  // remove and change class
  $scope.sortClass = function(col){
      if($scope.column == col ){
          if($scope.reverse){
              return 'arrow-down';    
          }else{
              return 'arrow-up';
          }
      }else{
          return '';
      }
  } 
        


    $scope.sortType     = ''; // set the default sort type
    $scope.sortReverse  = false;  // set the default sort order
    //$scope.searchFish   = '';     // set the default search/filter term
    // create the list of sushi rolls 
   
 

        $scope.filterFunction = function(element) {
          //check if no flight selected
          if(Object.keys($scope.Filter).length===0)
            return true;
          var airlineFilter = ("AirlineCode" in $scope.Filter)?($scope.Filter.AirlineCode.hasOwnProperty(element.Segments[0][0].Airline.AirlineCode) && $scope.Filter.AirlineCode[element.Segments[0][0].Airline.AirlineCode]===true):true;
          var stopFilter = ("Stops" in $scope.Filter)?($scope.Filter.Stops.hasOwnProperty(element.Segments[0].length-1) && $scope.Filter.Stops[element.Segments[0].length-1]===true ):true;

          var timeSlot = ("TimeSlot" in $scope.Filter)?($scope.Filter.TimeSlot.hasOwnProperty($scope.timeSlotDisplay(element.Segments[0][0].Origin.DepTime.substr(11,2))) && $scope.Filter.TimeSlot[$scope.timeSlotDisplay(element.Segments[0][0].Origin.DepTime.substr(11,2))]===true ):true;

          var flightFare = element.Fare.PublishedFare+$scope.service_charge+$scope.service_charge_gst;

          var priceRange = (flightFare > $scope.Filter.Price.min && flightFare <  $scope.Filter.Price.max);

          //console.log(element);

          return ( airlineFilter && stopFilter && timeSlot && priceRange )  ? true : false;
        };

        

        $scope.filterFlights = function(type) {
          for (var key in $scope.Filter) {
            if ($scope.Filter.hasOwnProperty(key)) {
              var val = $scope.Filter[key];
              for (var keyChild in val) {
                if (val.hasOwnProperty(keyChild) &&  val[keyChild]==false ) {
                  delete  val[keyChild];
                }
              }
              if(Object.keys(val).length === 0)
                 delete $scope.Filter[key];
            }
          }
         
        };

        $scope.calenderSearch = function(d){
          var url = new URL(window.location.href);
          var query_string = url.search;
          var search_params = new URLSearchParams(query_string); 
          search_params.set('date_up',d);
          url.search = search_params.toString();
          var new_url = url.toString();
          window.location = new_url;
      };

        $scope.bookNow = function(i){
           var searchIndex = ngapp.searchIndex;
           window.location = window.location.origin+'/book-now?searchIndex='+searchIndex+'&itemId='+i;
        };

}]);




// Hotel section

ngapp.controller('HotelsController', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {

  $scope.timeFormatText = ngapp.timeFormatText;
  $scope.priceDisplay = ngapp.priceDisplay;
  $scope.dateFormatdateMonth = ngapp.dateFormatdateMonth;
  $scope.dateFormatInput = ngapp.dateFormatInput;
  $scope.timeSlotDisplay = ngapp.timeSlotDisplay;
  $scope.dateFormattext = ngapp.dateFormattext;
  $rootScope.indexdata = {};
  $scope.HotelSearchResult = [];

  
  // List flights
   $scope.loadHotels = function (url) {
     
      $http.post('/hotels/search',url).then(function success(e) {
      $scope.HotelSearchResult = e.data.HotelSearchResult;

      $(document).ready(function() {
                // Date Picker of model box
        $("#modelchooseDateBtn").on('click',function(){
         
          $('#modeldepartdate').show();
            });
          $("#modelchooseDateBtn1").on('click',function(){
          $('#modelreturndate').show();
            });
          var dateToday = new Date(); 
          $( "#modeldepartdate" ).datepicker({
          numberOfMonths: 1,
          minDate: 0,
          dateFormat: "dd-M-yy",
          onSelect: function (d) {
            $('#depart_date').val(d);
                $('#modeldepartdate').slideToggle(250);
                var startDate = Date.parse($('#depart_date').val());
                  var endDate = Date.parse($('#return_date').val());
                  var triptype =  $('input[name=triptype]:checked').val();
                  if(triptype == 'roundtrip'){
                    if (startDate > endDate){
                        $('#reuiredmsg').show();
                        $('#reuiredmsg').text('please choose return date');
                        $('#return_date').val('');
                        $('#return_date').attr('required','required');
                    }
                  }
                  var dt2 = $('#modelreturndate');
                  var startDate = $(this).datepicker('getDate');
                  var minDate = $(this).datepicker('getDate');
                  var dt2Date = dt2.datepicker('getDate');
                  //difference in days. 86400 seconds in day, 1000 ms in second
                  var dateDiff = (dt2Date - minDate)/(86400 * 1000);
                  startDate.setDate(startDate.getDate() + 30);
                  //sets dt2 maxDate to the last day of 30 days window
                  dt2.datepicker('option', 'maxDate', startDate);
                  dt2.datepicker('option', 'minDate', minDate);
              }
            });
          var dateToday = new Date(); 
          $( "#modelreturndate" ).datepicker({
              numberOfMonths: 1,
              minDate: $('#depart_date').val(),
          dateFormat: "dd-M-yy",
          onSelect: function (d) {
            $('#return_date').val(d);
            var startDate = Date.parse($('#depart_date').val());
            var endDate = Date.parse($('#return_date').val());
            var triptype =  $('input[name=triptype]:checked').val();
              if(triptype == 'roundtrip'){
                if (startDate > endDate){
                  $('#reuiredmsg').show();
                  $('#reuiredmsg').text('Return date can not be less than departure date ');
                  }
                }
              $('#modelreturndate').slideToggle(250);
            }
          });
      })
      $scope.orderProperty = "HotelSearchResult.HotelResults[0].Price.PublishedPriceRoundedOff";
      $scope.flightFilter = '';
    }, function error(error) {
    });
 
};

var datavalues = getParams(window.location.href);
$scope.loadHotels(datavalues);

// Sort Function 
$scope.reverse = false;   
  
// called on header click
$scope.sortColumn = function(col){
    $scope.column = col;
    
    if($scope.reverse){
        $scope.reverse = false;
        $scope.reverseclass = 'arrow-up';
    }else{
        $scope.reverse = true;
        $scope.reverseclass = 'arrow-down';
    }
};

// remove and change class
$scope.sortClass = function(col){
    if($scope.column == col ){
        if($scope.reverse){
            return 'arrow-down';    
        }else{
            return 'arrow-up';
        }
    }else{
        return '';
    }
} 
      


  $scope.sortType     = ''; // set the default sort type
  $scope.sortReverse  = false;  // set the default sort order
  $scope.searchFish   = '';     // set the default search/filter term
  
  
// End Sort Function 
$scope.viewdetail = function(i,j,k,str){
  var searchIndex = ngapp.searchIndex;
  
  window.location =   window.location.origin+'/hotel/detail?ResultIndex='+i+'&HotelCode='+j+'&TraceId='+k+'&'+str;
  
};

// Search hotel by name
$scope.query = {}
$scope.queryBy = 'HotelName'

// Filter by Rating 
$scope.filterRating = function() {
  $scope.searchBy= 'StarRating';
};

}]);
// Hotel Detail 

ngapp.controller('HotelsDetailController', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {

  $scope.timeFormatText = ngapp.timeFormatText;
  $scope.priceDisplay = ngapp.priceDisplay;
  $scope.dateFormatdateMonth = ngapp.dateFormatdateMonth;
  $scope.dateFormatInput = ngapp.dateFormatInput;
  $scope.timeSlotDisplay = ngapp.timeSlotDisplay;
  $scope.dateFormattext = ngapp.dateFormattext;
  $rootScope.indexdata = {};
  $scope.HotelInfoResult = [];
  $scope.GetHotelRoomResult = []; 
  
  // List flights
   $scope.loadHotels = function (url) {
    $http.post('/hotel/info',url).then(function success(e) {
    $scope.HotelInfoResult = e.data.HotelInfoResult;
    $(document).ready(function() {
        // Date Picker of model box
        $("#modelchooseDateBtn").on('click',function(){
        $('#modeldepartdate').show();
          });
        $("#modelchooseDateBtn1").on('click',function(){
        $('#modelreturndate').show();
          });
        var dateToday = new Date(); 
        $( "#modeldepartdate" ).datepicker({
        numberOfMonths: 1,
        minDate: 0,
        dateFormat: "dd-M-yy",
        onSelect: function (d) {
          $('#depart_date').val(d);
              $('#modeldepartdate').slideToggle(250);
              var startDate = Date.parse($('#depart_date').val());
                var endDate = Date.parse($('#return_date').val());
                var triptype =  $('input[name=triptype]:checked').val();
                if(triptype == 'roundtrip'){
                  if (startDate > endDate){
                      $('#reuiredmsg').show();
                      $('#reuiredmsg').text('please choose return date');
                      $('#return_date').val('');
                      $('#return_date').attr('required','required');
                  }
                }
                var dt2 = $('#modelreturndate');
                var startDate = $(this).datepicker('getDate');
                var minDate = $(this).datepicker('getDate');
                var dt2Date = dt2.datepicker('getDate');
                //difference in days. 86400 seconds in day, 1000 ms in second
                var dateDiff = (dt2Date - minDate)/(86400 * 1000);
                startDate.setDate(startDate.getDate() + 30);
                //sets dt2 maxDate to the last day of 30 days window
                dt2.datepicker('option', 'maxDate', startDate);
                dt2.datepicker('option', 'minDate', minDate);
            }
          });
        var dateToday = new Date(); 
        $( "#modelreturndate" ).datepicker({
            numberOfMonths: 1,
            minDate: $('#depart_date').val(),
        dateFormat: "dd-M-yy",
        onSelect: function (d) {
          $('#return_date').val(d);
          var startDate = Date.parse($('#depart_date').val());
          var endDate = Date.parse($('#return_date').val());
          var triptype =  $('input[name=triptype]:checked').val();
            if(triptype == 'roundtrip'){
              if (startDate > endDate){
                $('#reuiredmsg').show();
                $('#reuiredmsg').text('Return date can not be less than departure date ');
                }
              }
            $('#modelreturndate').slideToggle(250);
          }
        });
        if(e.data.HotelInfoResult.ResponseStatus == 1){
          $('#hotelSlider').owlCarousel({
              loop: true,
              margin: 10,
              nav:true,
              dots:true,
              responsiveClass: true,
              responsive: {
                0: {
                  items: 1,
                  nav: false,
                  dots:true,
                },
                600: {
                  items: 2,
                  nav: false,
                  dots:true,
                },
                1000: {
                  items:1,
                  nav: true,
                  loop: true,
                  dots:true,
                  margin: 20
                }
              }
            });
            $('body').scrollspy({target: ".navbar", offset: 50});   

            // Add smooth scrolling on all links inside the navbar
            $("#myNavbar a").on('click', function(event) {
              // Make sure this.hash has a value before overriding default behavior
              if (this.hash !== "") {
                // Prevent default anchor click behavior
              event.preventDefault();
              // Store hash
              var hash = this.hash;
              // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
              $('html, body').animate({
              scrollTop: $(hash).offset().top
              }, 800, function(){
              // Add hash (#) to URL when done scrolling (default click behavior)
              window.location.hash = hash;
              });
              }  // End if
            });
            var infowindow = new google.maps.InfoWindow();
            var lat=$scope.HotelInfoResult.HotelDetails.Latitude;
            var long=$scope.HotelInfoResult.HotelDetails.Longitude;
            var name =$scope.HotelInfoResult.HotelDetails.HotelName;
            var mapOptions = {
                center:new google.maps.LatLng(lat,long),
                zoom:10
              }
            var map = new google.maps.Map(document.getElementById("googleMap"),mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, long),
                map: map,
              });
              google.maps.event.addListener(marker, 'mouseover', function() {
                infowindow.setContent(name);
                infowindow.open(map, this);
              });
            }
          });
     },function error(error) {
    });
    $http.post('/hotel/room',url).then(function success(e) {
      $scope.GetHotelRoomResult = e.data.GetHotelRoomResult;
      
    },function error(error) {

   
  });

  $scope.roomdetail = function(qry,hn,key){
    var searchIndex = ngapp.searchIndex;
   
    window.location =   window.location.origin+'/hotel/checkout?'+qry+'&HotelName='+hn+'&roomkey='+key;
    
  };

 
 
};

var datavalues = getParams(window.location.href);
$scope.loadHotels(datavalues);




}]);


ngapp.controller('CheckoutController', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {

  $scope.timeFormatText = ngapp.timeFormatText;
  $scope.priceDisplay = ngapp.priceDisplay;
  $scope.dateFormatdateMonth = ngapp.dateFormatdateMonth;
  $scope.dateFormatInput = ngapp.dateFormatInput;
  $scope.timeSlotDisplay = ngapp.timeSlotDisplay;
  $scope.dateFormattext = ngapp.dateFormattext;
  $rootScope.indexdata = {};
  $scope.HotelSearchResult = [];

  
  //  Room Detail 
   $scope.loadHotels = function (url) {
      $http.post('/hotel/roomdetail',url).then(function success(e) {
        
      $scope.BlockRoomResult = e.data.BlockRoomResult;
      $scope.flightFilter = '';
    }, function error(error) {
    });
 
};

$scope.payNow = function (formValid){
  
  $scope.submitted = true;
  $scope.response = {};
  $scope.data = {};
  if(formValid) {
   var postData = {Email:$scope.Email,
                   Phoneno:$scope.Phoneno,
                   Title:$scope.Title,
                   FirstName:$scope.FirstName,
                   LastName:$scope.LastName,

                  };
          
  $http.post('/hotel/submit-booking-details',JSON.stringify(postData)).then(function success(e) {
    window.location = window.location.origin+'/payment/flight';
    },  function error(error) {
      
    }); 
 }
}

var datavalues = getParams(window.location.href);
$scope.loadHotels(datavalues);




}]);
// End Hotel section

ngapp.controller('bookingController', ['$scope', '$http','$rootScope','$anchorScroll', function ($scope, $http,$rootScope,$anchorScroll) {
  // List flights
    $scope.searchResponse = 0;
    $scope.apiError = {};
    $scope.hasError = 0;
    $scope.responseData = {};
    $scope.timeFormatText = ngapp.timeFormatText;
    $scope.priceDisplay = ngapp.priceDisplay;
    $scope.dateFormatdateMonth = ngapp.dateFormatdateMonth;
    $scope.dateFormatInput = ngapp.dateFormatInput;
    $scope.timeSlotDisplay = ngapp.timeSlotDisplay;
    $scope.dateFormattext = ngapp.dateFormattext;
    $scope.user = {};
    $scope.user.ticket = [];
    $scope.indexdata = $rootScope.indexdata;
    $scope.totalPassengerCount = 0;

    $scope.priceDetails = {};
    $scope.priceDetails.TotalBaseFare = 0;
    $scope.priceDetails.TotalFeeAndSurcharges = 0;
    $scope.priceDetails.AirLineCharges = 0;
    $scope.priceDetails.OtherCharges = 0;
    $scope.priceDetails.serviceCharges = 0;
    $scope.priceDetails.totalGST = 0;
    $scope.priceDetails.TDS = 0;
    $scope.priceDetails.Taxes = 0;
    $scope.priceDetails.GrandTotal = 0;
    $scope.priceDetails.totalCommission = 0;
    $scope.priceDetails.totalCommissionGST = 0;
    $scope.priceDetails.trips = {};
    $scope.flightssr = {};
    $scope.isGstMandatory = false;

    $scope.hasAirIndia = false;
    

    $scope.loadFlightDetails = function (url) {

          $http.post('/flights/details',url).then(function success(e) {

          $scope.myDate = new Date();
          $scope.minDate = {};
          $scope.maxDate = {};

          $scope.passportExpiry = {};

          $scope.passportExpiry.min = new Date($scope.myDate.getFullYear(),$scope.myDate.getMonth(),$scope.myDate.getDate());

          $scope.passportExpiry.max = new Date($scope.myDate.getFullYear()+20,$scope.myDate.getMonth(),$scope.myDate.getDate());

          $scope.minDate.adult = new Date($scope.myDate.getFullYear()-100,$scope.myDate.getMonth(),$scope.myDate.getDate());
        
          $scope.maxDate.adult = new Date($scope.myDate.getFullYear()-18,$scope.myDate.getMonth(),$scope.myDate.getDate());

          $scope.minDate.child = new Date($scope.myDate.getFullYear()-18,$scope.myDate.getMonth(),$scope.myDate.getDate());
        
          $scope.maxDate.child = new Date($scope.myDate.getFullYear()-2,$scope.myDate.getMonth(),$scope.myDate.getDate());

          $scope.minDate.infant = new Date($scope.myDate.getFullYear()-2,$scope.myDate.getMonth(),$scope.myDate.getDate());
        
          $scope.maxDate.infant = new Date($scope.myDate.getFullYear(),$scope.myDate.getMonth(),$scope.myDate.getDate()-1);
      

          if(e.data.fareQuote[0].Response.Error.ErrorCode!==0){
              $scope.hasError = 1;
              $scope.apiError.errorcode = 2;
              $scope.apiError.errorMessage = "Looks like your session id has expired";
            } else {
              var totalPassengerCount = 0;
              for (i = 0; i < e.data.fareQuote[0].Response.Results.FareBreakdown.length; i++) {  //loop through the array
                  totalPassengerCount += e.data.fareQuote[0].Response.Results.FareBreakdown[i].PassengerCount;  //Do the math!
              }
              $scope.totalPassengerCount = totalPassengerCount;
              $scope.responseData = e.data;

              for (i = 0; i < e.data.fareQuote.length; i++) {  //loop through the array

                  $scope.priceDetails.TotalBaseFare  += e.data.fareQuote[i].Response.Results.Fare.BaseFare;
                  
                  $scope.priceDetails.AirLineCharges  += e.data.fareQuote[i].Response.Results.Fare.YQTax;

                  $scope.priceDetails.Taxes  += e.data.fareQuote[i].Response.Results.Fare.Tax-e.data.fareQuote[i].Response.Results.Fare.YQTax;

                  $scope.priceDetails.OtherCharges  += e.data.fareQuote[i].Response.Results.Fare.OtherCharges+e.data.corporate_service_charge;

                  $scope.priceDetails.TotalFeeAndSurcharges  += e.data.fareQuote[i].Response.Results.Fare.Tax+$scope.priceDetails.OtherCharges;

                  $scope.priceDetails.GrandTotal  += e.data.fareQuote[i].Response.Results.Fare.PublishedFare+e.data.corporate_service_charge;

                  $scope.priceDetails.serviceCharges  += e.data.fix_services.service_charge;
                  
                  $scope.priceDetails.totalGST  += e.data.fix_services.service_charge*18/100;

                  if(e.data.fareQuote[i].Response.Results.IsGSTMandatory==true)
                     $scope.isGstMandatory = true;

                  if(e.data.fareQuote[i].Response.Results.AirlineCode =='I5')
                    $scope.hasAirIndia = true;

                  }

                $scope.priceDetails.totalCommission = e.data.total_commission;
                $scope.priceDetails.totalCommissionGST = e.data.total_commission*18/100;
                $scope.priceDetails.TDS = e.data.total_commission*5/100;

                if(e.data.userInfo!==''){
                  $scope.user.emailId = e.data.userInfo.email;
                  $scope.user.countryCode = e.data.userInfo.countrycode;
                  $scope.user.mobileNo = parseInt(e.data.userInfo.mobile);
                }
            }
            
            $scope.searchResponse = 1;
            $('#confirm').modal("hide");
          }, function error(error) {
      });
    };

      $scope.locationRefresh = function(){
        location.href =  window.location.href;
      }

      $scope.goBackToSearch = function(){
         window.history.go(-1);
      }

      $scope.doLogin = function (){
        $scope.loginSubmitted = true;
        $scope.response = {};
        $scope.data = {};
        var postData = {
                        email: $scope.user.email,
                        password: $scope.user.password
                      };
        $http.post('/agent/auth',JSON.stringify(postData)).then(function success(e) {
          if(e.data.response.length!==0){
            $scope.response = e.data.response;
            $scope.response.type = e.data.response.type;
          }else {
           $scope.data = e.data;
          }
         }, function error(error) {
           
        });
      }


      $scope.payNow = function (formValid){
        $scope.submitted = true;
        $scope.response = {};
        $scope.data = {};
        $anchorScroll('traveller-details');
        if(formValid) {
           $('#confirmPassengers').modal("show");
        }
      }


      $scope.submitBookingDetails = function (){
        $scope.response = {};
        $scope.data = {};
       // $scope.flightssr.Passenger = {};
        $anchorScroll('traveller-details');
        
              if(typeof $scope.flightssr.Passenger === "undefined"){
                var postData = {
                  emailId: $scope.user.emailId,
                  countryCode: $scope.user.countryCode,
                  GSTno: $scope.user.GSTno,
                  mobileNo: $scope.user.mobileNo,
                  companyEmail: $scope.user.companyEmail,
                  companyName: $scope.user.companyName,
                  companyMobileCode: $scope.user.companyMobileCode,
                  companyMobile: $scope.user.companyMobile,
                  companyAddress : $scope.user.companyAddress,
                  ticket: $scope.user.ticket,
                 
                };
              }else{
                var postData = {
                  emailId: $scope.user.emailId,
                  countryCode: $scope.user.countryCode,
                  GSTno: $scope.user.GSTno,
                  mobileNo: $scope.user.mobileNo,
                  companyEmail: $scope.user.companyEmail,
                  companyName: $scope.user.companyName,
                  companyMobileCode: $scope.user.companyMobileCode,
                  companyMobile: $scope.user.companyMobile,
                  companyAddress : $scope.user.companyAddress,
                  ticket: $scope.user.ticket,
                  Baggage : $scope.flightssr.Passenger,
                };
              }
              //console.log(postData);
                       
          $http.post('/flights/submit-booking-details',JSON.stringify(postData)).then(function success(e) {
             window.location = window.location.origin+'/payment/flight';
         },  function error(error) {
           
        });
      }

    
      $scope.submitBooking = function (){
        $scope.submitted = true;
        $scope.response = {};
        $scope.data = {};
        $anchorScroll('traveller-details');
        var postData = {
                        emailId: $scope.user.emailId,
                        countryCode: $scope.user.countryCode,
                        mobileNo: $scope.user.mobileNo,
                        ticket: $scope.user.ticket
                      };
                         
        $http.post('/flights/submit-booking',JSON.stringify(postData)).then(function success(e) {
          if(e.data.response.length!==0){
            $scope.response = e.data.response;
            $scope.response.type = e.data.response.type;
          }else {
           $scope.data = e.data;
          }
         }, function error(error) {
           
        });
      }

    var datavals = getParams(window.location.href);
    $scope.loadFlightDetails(datavals);

}]);




