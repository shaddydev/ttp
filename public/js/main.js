$(document).ready(function() {
	$(".main-menu-bar").click(function(e){
		e.preventDefault();
		$(".main-menu").animate({width: "toggle"});
		$('.mOverlay').addClass('active');
	});

	$(".mOverlay").click(function(e){
		e.preventDefault();
		$('.mOverlay').removeClass('active');
		$(".main-menu").animate({width: "toggle"});
	});
$(".panel-button").click(function(e){
    e.preventDefault();
    $("#sidebar-container").animate({width: "toggle"});
    $('.mOverlay1').addClass('active');
  });

  $(".mOverlay1").click(function(e){
    e.preventDefault();
    $('.mOverlay1').removeClass('active');
    $("#sidebar-container").animate({width: "toggle"});
  });

  $('.navbar .dropdown-item.dropdown').on('click', function (e) {
    var $el = $(this).children('.dropdown-toggle');
    if ($el.length > 0 && $(e.target).hasClass('dropdown-toggle')) {
        var $parent = $el.offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if (!$parent.parent().hasClass('navbar-nav')) {
            if ($parent.hasClass('show')) {
                $parent.removeClass('show');
                $el.next().removeClass('show');
                $el.next().css({"top": -999, "left": -999});
            } else {
                $parent.parent().find('.show').removeClass('show');
                $parent.addClass('show');
                $el.next().addClass('show');
                $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }
            e.preventDefault();
            e.stopPropagation();
        }
        return;
    }
});

$('.navbar .dropdown').on('hidden.bs.dropdown', function () {
    $(this).find('li.dropdown').removeClass('show open');
    $(this).find('ul.dropdown-menu').removeClass('show open');
});

$('#productSlider').owlCarousel({
  loop: true,
  margin: 10,
  nav:true,
  dots:true,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: true
    },
    600: {
      items: 2,
      nav: false
    },
    1000: {
      items: 3,
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
      items: 3,
     
    },
    1000: {
      items: 5,
    
      loop: true,
      margin: 20
    }
  }
});   

  $(document).on("click",".month-content",function() {
    $(".month-content1").slideToggle();
  });

$(document).on("click",".month-content",function() {
    $(this).toggleClass('ButtonClicked');
});


 





  $(document).on("click",".filter-btn",function() {
    $(".search-filter").addClass("filter-left");
  });

  $(document).on("click",".filter-close",function() {
    $(".search-filter").removeClass("filter-left");
  });





  $(document).on("click","#flip",function() {
    $(".hidden-content").slideToggle();
  });
  $(document).on("click","#flip1",function() {
    $(".hidden-content1").slideToggle();
  });

  $(document).on("click","#flip2",function() {
    $(".hidden-content2").slideToggle();
  });

  $(document).on("click",".seat-select",function(e) {
        e.preventDefault();
        var dataindex = $(this).attr('data-index');
        $(".seatside_panel_"+dataindex).animate({
            width: "toggle"
        })
        $(".overlay_"+dataindex).fadeIn(500);
    });
 


$(document).on("click",".dismiss-menu",function(e) {
        e.preventDefault();
        var dataindex = $(this).attr('data-index');
        $(".seatside_panel_"+dataindex).animate({
            width: "toggle"
        })
        $(".overlay_"+dataindex).fadeOut(500);
    });




  $(document).on("click",".toggle",function(e) {
    $(this).toggleClass("expanded");
    $(".content").slideToggle();
  });

  
  $(document).on("click","#chooseDateBtn",function() {
    $("#datepicker").slideToggle(250);    
  });
  
  $("#regularBHD").css("display","block");

  $(document).on("click","#chooseDateBtn1",function() {
    $("#datepicker1").slideToggle(250);    
  });
  
  $("#regularBHD").css("display","block");

});


var dateToday = new Date(); 
$(function() {
    $( "#datepicker" ).datepicker({
        numberOfMonths: 1,
        minDate: dateToday,
    dateFormat: "dd, MM, yy",
    onSelect: function (d) {
        $('#preview_date').text(d);
    $('#datepicker').slideToggle(250);
    }
    });

    var timeFormatText = function(n) {
      var minutes = Math.floor(n / 60);
      var seconds = n - minutes * 60;
      return minutes + "m " + seconds + "s";
     };

    var start = 600;
    setInterval(function() {
        $('.Timer').html(timeFormatText(start));
        start--;
    }, 1000);

});

var dateToday = new Date(); 
$(function() {
    $( "#datepicker1" ).datepicker({
        numberOfMonths: 1,
        minDate: dateToday,
    dateFormat: "dd, MM, yy",
    onSelect: function (d) {
        $('#preview_date').text(d);
    $('#datepicker1').slideToggle(250);
    }
    });
});


var dateToday = new Date(); 
$(function() {
    $( "#departdate" ).datepicker({
        numberOfMonths: 1,
        minDate: dateToday,
    dateFormat: "dd, MM, yy",
    onSelect: function (d) {       
    $('#departdate').slideToggle(250);
    alert();
    }
    });
});

$(document).ready(function(){

  $(document).on("click","#tour-count",function() {
    $(".touriests_count").toggle();
  });
  $(document).on("click","#tour-count1",function() {
    $(".touriests_count1").toggle();
  });
  $(document).on("click",".select-seat",function() {
    $(".seat-div").toggle(1000);
  });
  $(document).on("click",".add-meal",function() {
    $(".meal-add").toggle(1000);
  });
  $(document).on("click",".add-baggage",function() {
    $(".baggage-add").toggle(1000);
  });

  $(document).on("click",".show-commission",function() {
    $(".commission-area").toggle('slow');
  });


  $(document).on("click",".open",function() {
    
       $('.showpanel').slideToggle('slow');
       if($(this).text() == 'View Less')
       {
           $(this).text('View More');
       }
       else
       {
           $(this).text('View Less');
       }
           });
    
  
$(document).on("click","#travel-account",function() {
    if( $(this).is(':checked')) {
        $("#password").show();
        $("#phone-numb").hide();
    } else {
       $("#password").hide();
        $("#phone-numb").show();
    }
});     

});

// Hide submenus
$('#body-row .collapse').collapse('hide'); 

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left'); 

// Collapse click
$(document).on("click","[data-toggle=sidebar-colapse]",function() {
    SidebarCollapse();
});

function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
    
    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }
    
    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fas-angle-double-left fas-angle-double-right');
}
  

function checkOffset() {
    if($('.roundbook').offset().top + $('.roundbook').height()>= $('footer').offset().top - 10)
        $('.roundbook').css('position', 'static');
    if($(document).scrollTop() + window.innerHeight < $('footer').offset().top)
        $('.roundbook').css('position', 'fixed'); // restore when you scroll up
    $('roundbook').text($(document).scrollTop() + window.innerHeight);
}
$(document).scroll(function() {
    //checkOffset();
});


$(document).ready(function(){
  $(document).on("click","#edit_btn",function() {
    $(".edit-profile-form").slideToggle("slow");
  });

  $(document).on("click","#edit_btn1",function() {
    $(".content").slideToggle("slow");
  });
});


var windw = this;

$.fn.followTo = function ( pos ) {
    var $this = this,
        $window = $(windw);
    
    $window.scroll(function(e){
        if ($window.scrollTop() > pos) {
            $this.css({
                position: 'sticky',
                top: 0
            });
        } else {
            $this.css({
                position: 'relative',
                top: 0
            });
        }
    });
};

var v_top  = $(".filter-area").position();

var h_height = parseInt(v_top.top);

$('.sidebar-ad').followTo(h_height);


$(document).ready(function(){
  $(".menuIcon").click(function(){
    $(".main-menu1 .navbar-nav").slideToggle();
  });
});