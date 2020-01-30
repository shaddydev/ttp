$(document).ready(function(){
  var allcitylist = [];
  $(document).on('keyup' , '.hotel-place'  ,function(){
  var index = $(this);
  //alert($(this).val());
  index.css("z-index", "2147483647");
  allcitylist = [];
  $.ajax({
          url: "/hotels/get-city-json",
          type: "GET",
          contentType: "application/json; charset=utf-8",
          data: {keys:$(this).val()},
          // dataType: JSON,
          success: function (data) {
              console.log(data);
              
              $.map(JSON.parse(data), function (el) {
                  var item = {
                      label: el.Destination+' - '+el.country,
                      value: el.Destination + ' - ' +el.country, 
                      cityid : el.cityid,
                      countryid :el.countrycode,
                      cityname: el.Destination,
                  };
                  allcitylist.push(item);
                 
              });
             // console.log(allcitylist);
             
              index.autocomplete({
                  source: allcitylist,
                  select: function (event, ui) {
                      this.value = ui.item.value;
                      event.preventDefault();
                      var destinate  = $('#cityList').val();
                       if ((destinate.length != 0) && (destinate.indexOf('-')>0)){
                         $("input[name=cityid]").val(ui.item.cityid);
                         $("input[name=countryid]").val(ui.item.countryid);
                         $("input[name=cityname]").val(ui.item.cityname);
                        
                        }
                  }
              })
          }
      });
  });

  $('.hotel-place').autocomplete({
      source: allcitylist,
  });

  // Date Picker
 
  // $(document).on("click","#checkIndate",function() {
  //   $("#checkIndate").slideToggle(250);    
  // });
  
  $('#checkIndate').datepicker({
    dateFormat: "dd-M-yy",
    format:"yyyy/mm/dd",
    minDate: 0,
        onSelect: function () 
        {
            var dt2 = $('#checkOutdate');
            var startDate = $(this).datepicker('getDate');
            var minDate = $(this).datepicker('getDate');
            var dt2Date = dt2.datepicker('getDate');
            //difference in days. 86400 seconds in day, 1000 ms in second
            var dateDiff = (dt2Date - minDate)/(86400 * 1000);
            startDate.setDate(startDate.getDate() + 30);
            //sets dt2 maxDate to the last day of 30 days window
            dt2.datepicker('option', 'maxDate', startDate);
            dt2.datepicker('option', 'minDate', minDate);
            //alert(convert(startDate));
           
    }
});



$('#checkOutdate').datepicker({
  dateFormat: "dd-M-yy",
  format:"yyyy/mm/dd",
  minDate: 0,
  onSelect: function () {
    var enddate = convert($(this).datepicker('getDate'));
    var startdate = convert($('#checkIndate').datepicker('getDate'));
    var startDay = new Date(startdate);
    var endDay = new Date(enddate);

    
    var millisecondsPerDay = 1000 * 60 * 60 * 24;

    var millisBetween =  endDay.getTime() - startDay.getTime();
    var days = millisBetween / millisecondsPerDay;
    $('#numberOfNight').val(days);
    // Round down.
    //alert( Math.floor(days));
// this calculates the diff between two dates, which is the number of nights
     
  }
});

function convert(str) {
  var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
  return [date.getFullYear(), mnth, day].join("-");
}


// Date picker on Agent transaction page
$('#datefrom').datepicker({
  dateFormat: "dd-M-yy",
  format:"yyyy/mm/dd",
  maxDate: 0,
      onSelect: function () 
      {
          var dt2 = $('#dateto');
          var startDate = $(this).datepicker('getDate');
          var minDate = $(this).datepicker('getDate');
          var dt2Date = dt2.datepicker('getDate');
          //difference in days. 86400 seconds in day, 1000 ms in second
          var dateDiff = (dt2Date - minDate)/(86400 * 1000);
          startDate.setDate(startDate.getDate() + 30);
          
          //sets dt2 maxDate to the last day of 30 days window
          // dt2.datepicker('option', 'maxDate', startDate);
          dt2.datepicker('option', 'minDate', minDate);
          //alert(convert(startDate));
         
  }
});

$('#dateto').datepicker({
  dateFormat: "dd-M-yy",
  format:"yyyy/mm/dd",
  maxDate: 0,
  
});
var i= 2;

var numchild=0;
var numadult=1; 
$(document).on('click','.add-more',function(){
  if(i == 5) return ; 
  var rooms = '<div class="tour-content1 control-group">';
  rooms+= '<div class="room-no">Room '+i+':</div>';
  rooms+= '<div class="adultroom tour-content">';
  rooms+= '<span class="inputblock"><input name="NoOfAdults[]" class = "nadult" type="text" value="1"/> Adult</span>';
  rooms+= '<div class="signs">';
  rooms+= '<span class="minus aminus" data-type="adultminus">-</span>';
  rooms+= '<span class="plus aplus" data-type="adultplus">+</span>';
  rooms+= '</div>';
  rooms+= '</div>';
  rooms+= '<div class="childroom tour-content">';
  rooms+= '<span class="inputblock"><input name="NoOfChild[]" id="tour_child_count" type="text" value="0"/> Child</span>';
  rooms+= '<div class="signs">';
  rooms+= '<span class="minus aminus" data-type="childminus">-</span>';
  rooms+= '<span class="plus aplus" data-type="childplus">+</span>';
  rooms+= '</div>';
  rooms+= '</div>';
  rooms+= '</div>';
  rooms+= '<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
  i++;
  $(".after-add-more").append(rooms);
  numadult = numadult+1;
  $("#people").text(numadult+numchild);
  // For adult

  // For children
})

$(document).on('click','.aminus',function(){
  numchild = parseInt(numchild);
  numadult = parseInt(numadult);
  var mode = $(this).attr('data-type');
 
  var element =  $(this).parent().siblings('.inputblock').children();
  var value = parseInt(element.val());
  if(value>0)
  {
    if(mode=="adultminus")
    {
      numadult = numadult-1;
    }
    
    if(mode=="childminus")
    {
      numchild = numchild-1;
      $(this).parent().parent().parent().children('.tour-content.age:last').remove();
    }
    $(this).parent().siblings('.inputblock').children().val(value-1);
    $("#people").text(numadult+numchild);
    
  }
});

$(document).on('click','.aplus',function(){
  
  numchild = parseInt(numchild);
  numadult = parseInt(numadult);
  var mode = $(this).attr('data-type');
  var element =  $(this).parent().siblings('.inputblock').children();
  var value = parseInt(element.val());
  if(value>=0)
  {
    if(mode=="adultplus")
    {
      numadult = numadult+1;
    }
    if(mode=="childplus")
    {
      var options = '';
      for(var j = 1; j<13 ; j++){
      options += '<option value = "'+j+'">'+j+'</option>';
      }
      var child = '';
      child+= '<div class="tour-content age">';
      child+= '<span class="inputblock">Child Age </span>';
      child+= '<select class = "child" name = "ChildAge[]">';
      child+= '<option value = "0"> <1 </option>';
      child+= options;
      child+='</select>';
      child+='</div>';
      numchild = numchild+1;
      if(child)
      {
        $(this).parent().parent().parent().append(child);
      }
    }
    $(this).parent().siblings('.inputblock').children().val(value+1);
    $("#people").text(numadult+numchild);
  }
});

$(document).on("click",".remove",function(){ 
  i--;
  numchild = parseInt(numchild);
  numadult = parseInt(numadult);
  var v1 = $(this).prev().children('.adultroom').children('span').children('input').val();
  var v2 = $(this).prev().children('.childroom ').children('span').children('input').val();
  numchild = numchild-v1;
  numadult = numadult-v2;
  $("#people").text(numadult+numchild);
  $(this).prev().remove();
  $(this).remove();
});

})

$(document).ready(function(){
  $("#hoteldetail").click(function(e) {
    //prevent Default functionality
    e.preventDefault();
       // Submit the form
       var adult = [];
       var child = [];
       var age   = [];
       var NoOfAdults   = $("input[name='NoOfAdults[]']");
       var NoOfChild    = $("input[name='NoOfChild[]']");
       var childAge     = $("select[name='ChildAge[]']");
       var NoOfNights   = $("input[name='NoOfNights']").val();
       var checkIndate  = $("input[name='checkIndate']").val();
       var checkOutDate = $("input[name='checkOutDate']").val();
       var cityid       = $("input[name='cityid']").val();
       var cityname     = $("input[name='cityname']").val();
       var countryid    = $("input[name='countryid']").val();
       $(NoOfAdults).each(function() {
        adult.push($(this).val()); 
      });
      $(NoOfChild).each(function() {
        child.push($(this).val()); 
      });
      $(NoOfChild).each(function() {
       // alert($(childAge).val());
        age.push($(childAge).val()); 
      });
      //alert(adult)
      //alert(age); 
     //return;
      var url = '/hotels?NoOfAdults='+adult+'&NoOfChild='+child+'&ChildAge='+age+'&NoOfNights='+NoOfNights+'&checkIndate='+checkIndate+'&checkOutDate='+checkOutDate+'&cityid='+cityid+'&cityname='+cityname+'&countryid='+countryid;
      window.location.href = window.location.origin+url;
   
  });
});

// For Model Box Add More With New Design 

var i= 2;

var numchild=0;
var numadult=1; 
$(document).on('click','.modeladd-more',function(){
 
 if(i>=2){
    $('.modelremove').show();
 }else{
   $('.modelremove').hide()
 }
  if(i == 5) return ; 
  var rooms = '<div class = "col-md-12"><div class= "row  removesection">';
  rooms += '<div class="col-md-12 ">';
  rooms += '<label>Room '+i+' :</label>';
  rooms += '</div>';
  rooms += '<div class="col-md-4 mar-bottom">';
  rooms += '<div class="value-inc"><button class="minus modelminus" data-type="adultminus" type = "button">-</button>';
  rooms += '<span class="inputblock"><input name="NoOfAdults[]" id="adult_count" type="text" value="1"> Adult<br>(above 12 years)</span>';
  rooms += '<button class="plus modelplus"  data-type="adultplus" type = "button">+</button>';
  rooms += '</div>';
  rooms += '</div>';
  rooms += '<div class="col-md-4 mar-bottom">';
  rooms += '<div class="value-inc"><button class="minus modelminus" data-type="childminus" type = "button">-</button>';
  rooms += '<span class="inputblock"><input name="NoOfChild[]" id="adult_count" type="text" value="0"> Children<br>(below 12 years)</span>';
  rooms += '<button class="plus modelplus" data-type="childplus" type = "button">+</button>';
  rooms += '</div>  <div class="tour-content age"> <span class="inputblock">Child Age </span></div>';
  rooms += '</div></div></div>';
 
  i++;
  $(".after-add-more").append(rooms);
 
  numadult = numadult+1;
  $("#people").text(numadult+numchild);
  // For adult
  
  // For children
})

$(document).on("click",".modelremove",function(){ 
  
  i--;
  numchild = parseInt(numchild);
  numadult = parseInt(numadult);
  var v1 = $(this).prev().children('.adultroom').children('span').children('input').val();
  var v2 = $(this).prev().children('.childroom ').children('span').children('input').val();
  numchild = numchild-v1;
  numadult = numadult-v2;
  $("#people").text(numadult+numchild);
  $(this).parent().parent().siblings().children().children('.removesection').last().remove();
  if(i>2){
    $('.modelremove').show();
 }else{
   $('.modelremove').hide()
 }
});



$(document).on('click','.modelplus',function(){
  
  numchild = parseInt(numchild);
  numadult = parseInt(numadult);
  var mode = $(this).attr('data-type');
  var element =  $(this).parent().children().children();
  var value = parseInt(element.val());

  if(value>=0)
  {
    
    if(mode=="adultplus")
    {
      numadult = numadult+1;
      var adultlimit = $(this).parent().children().children().val();
      if(adultlimit == 3){
        $(this).parent().children().next().next().attr("disabled", true);
      }
      else{
       
        $(this).parent().children().first().removeAttr("disabled");
      }
    }
    if(mode=="childplus")
    { 
      
      var options = '';
      for(var j = 1; j<13 ; j++){
      options += '<option value = "'+j+'">'+j+'</option>';
      }
      
      var child = '';
      child+= '<select class = "child" name = "ChildAge[]">';
      child+= '<option value = "0"> <1 </option>';
      child+=  options;
      child+= '</select>';
     
      numchild = numchild+1;
      if(child)
      { 
        
        $(this).parent().parent().children().next().children().parent().children().append(child);
      }
      var childlimit = $(this).parent().children().children().val();
     
      if(childlimit == 2){
        $(this).parent().children().next().next().attr("disabled", true);
      }
      else{
       
        $(this).parent().children().next().next().removeAttr("disabled");;
      }
    }
    $(this).parent().children().children().val(value+1);
    $("#people").text(numadult+numchild);
  }
});

$(document).on('click','.modelminus',function(){
  numchild = parseInt(numchild);
  numadult = parseInt(numadult);
  var mode = $(this).attr('data-type');
 
  var element =  $(this).parent().children().children();
  var value = parseInt(element.val());
  if(value>0)
  { 
    if(mode=="adultminus")
    {
     
      numadult = numadult-1;
     
      
      var adultlimit = $(this).parent().children().children().val();
     
      if(adultlimit == 2){
        
        $(this).parent().children().first().attr("disabled", true);
      }
      else{
        $(this).parent().children().next().next().removeAttr("disabled");
      }
    }
    
    if(mode=="childminus")
    {
      numchild = numchild-1;
      //$(this).parent().parent().parent().children('.tour-content.age:last').remove();
      $(this).parent().parent().children().next().children().parent().children().children().last().remove();
      var childlimit = $(this).parent().children().children().val();
     
      $(this).parent().children().next().next().removeAttr("disabled");
    }
    $(this).parent().children().children().val(value-1);
    $("#people").text(numadult+numchild);
    
  }
});