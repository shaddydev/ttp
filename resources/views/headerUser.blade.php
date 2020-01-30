<header class="agent-header">
   <div class="navbar navbar-expand-md" role="navigation">
      <div class="container">
         <div class="nav-row">
            <div class="logo">
            @if(Auth::user()->hasRole('user'))
            <a href="{{ url('') }}"><img src="{{ url('/public/uploads/siteinfo/resizepath/'.$getsitedata['0']->value) }}" alt="logo"></a>
            @else
            <a href="{{ url(Auth::user()->role->name) }}"><img src="{{ url('/public/uploads/siteinfo/resizepath/'.$getsitedata['0']->value) }}" alt="logo"></a>
            @endif
            </div>
            <div class="main-menu1">
               <div class="menuIcon"><i class="fa fa-bars"></i></div>
               <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" id="dropdown1-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fas fa-plane"></i></span>Flights</a>
                     <ul class="dropdown-menu" aria-labelledby="dropdown1-1">
                        <li class="nav-item dropdown"><a href="{{url(Auth::user()->role->name.'/allbookings')}} ">Flights Booking</a></li>
                        <!--<li class="dropdown-item"><a href="#">Hold Bookings</a></li>
                        <li class="dropdown-item"><a href="#">Import PNR</a></li>
                        <li class="dropdown-item"><a href="#">Travel Calendar</a></li>-->
                        <li class="dropdown-item"><a href="{{url(Auth::user()->role->name.'/allbookings')}}">Change Request Queue</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" id="dropdown1-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fas fa-hotel"></i></span>Hotels</a>
                     <ul class="dropdown-menu" aria-labelledby="dropdown1-2">
                        <li class="dropdown-item"><a href="{{url(Auth::user()->role->name.'/allbookings')}}" >Hotels Booking</a></li>
                        <li class="dropdown-item"><a href="{{url(Auth::user()->role->name.'/allbookings')}}">Hold Bookings</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" id="dropdown1-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fas fa-bus"></i></span>Bus</a>
                     <ul class="dropdown-menu" aria-labelledby="dropdown1-3">
                        <li class="dropdown-item"><a href="#">Bus Booking</a></li>
                        <li class="dropdown-item"><a href="#">Hold Bookings</a></li>
                     </ul>
                  </li>
                  <li class="nav-item"><a href="{{ url('page/about-us') }}"><span><i class="fas fa-user"></i></span>About Us</a></li>
                  <li class="nav-item"><a href="{{ url('bank/detail') }}"><span><i class="fas fa-user"></i></span>Bank Detail</a></li>
                  <li class="nav-item"><a href="{{ url('contactus') }}" ><span><i class="fas fa-envelope"></i></span>Contact Us</a></li>
               </ul>
            </div>
            <div class="main-menu2">
               <div class="collapse navbar-collapse" id="navbarCollapse1">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown2"  data-toggle="dropdown">Hi {{ Auth::user()->fname }}  {{ Auth::user()->lname }} </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown2">
                           @if(!Auth::user()->hasRole('user'))
                           <li class="dropdown-item">
                              <span><a href="#" >Cash: {{Auth::user()->user_details->cash != "" ? Auth::user()->user_details->cash : 0}}</a></span>/<span><a href="#" >Credit: {{Auth::user()->user_details->credit != '' ? Auth::user()->user_details->credit : 0}}</a></span>
                           </li>
                           <li class="dropdown-item"><a href="#" >{{Auth::user()->user_details->unique_code}}</a></li>
                           <li class="dropdown-item">
                              
                             
                                 <a href="{{ url(Auth::user()->role->name.'/payment-request') }}">Credit Request</a>
                              
                           </li>

                           <li class="dropdown-item">
                              
                             
                              <a href="{{ url(Auth::user()->role->name.'/make-payment') }}">Make Payment</a>
                           
                        </li>

                           <!--<li class="dropdown-item dropdown">
                              <a class="dropdown-toggle" id="dropdown2-2" data-toggle="dropdown" >Other Tools</a>
                              <ul class="dropdown-menu" aria-labelledby="dropdown2-2">
                                 <li class="dropdown-item"><a href="#">Display Markup</a></li>
                                 <li class="dropdown-item"><a href="#">Notice Board</a></li>
                              </ul>
                           </li>-->
                           @endif
                           <li class="dropdown-item"><a href="{{ url(Auth::user()->role->name.'/dashboard') }}" >Profile Settings</a></li>
                           @if(!Auth::user()->hasRole('user'))
                           <li class="dropdown-item"><a href="{{ url(Auth::user()->role->name.'/all-transcation') }}" >Reports</a></li>
                           @endif
                           @if(Auth::user()->hasRole('distributor'))
                           <li class="dropdown-item"><a href="{{url('distributor/manage-agents')}}" class="">
                              
                                Manage Agents
                              
                           </a></li>
                           <li class="dropdown-item"><a href="{{url('distributor/wallet-transaction')}}" class="">
                              Manage Account
                           </a></li>
                           <li class="dropdown-item"><a href="{{url('distributor/credit/request')}}" class="">
                              Credit Request
                           </a></li>
                           @endif
                           <li class="dropdown-item">
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
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</header>