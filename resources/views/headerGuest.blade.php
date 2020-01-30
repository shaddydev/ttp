@if(Request::url() !== URL::to('/') && Request::url() !== URL::to('home'))
  <header class="white-head" >
@else
  <header> 
@endif
  

<div class="navbar navbar-expand-md" role="navigation">
      <div class="container">
         <div class="nav-row">
            <div class="logo">
            <a href="{{ url('') }}"><img src="{{ url('/public/uploads/siteinfo/resizepath/'.$getsitedata['0']->value) }}" alt="logo"></a>
           
            </div>
            <div class="main-menu1">
               <div class="menuIcon"><i class="fa fa-bars"></i></div>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href=""><span><i class="fas fa-plane"></i></span>Flights</a></li>
                    <li class="nav-item"><a href=""><span><i class="fas fa-hotel"></i></span>Hotels</a></li>
                    <li class="nav-item"><a href=""><span><i class="fas fa-bus"></i></span>Bus</a></li>
                    <li class="nav-item"><a href="{{ url('page/about-us') }}"><span><i class="fas fa-user"></i></span>About Us</a></li>
                    <li class="nav-item"><a href="{{ url('contactus') }}" ><span><i class="fas fa-envelope"></i></span>Contact Us</a></li>
                </ul>
            </div>
          
         </div>
      </div>
   </div>

</header>