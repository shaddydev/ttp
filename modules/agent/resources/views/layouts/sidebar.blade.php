<div class="mOverlay1"></div>
    <div id="sidebar-container" class="sidebar-expanded "><!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
        
            <a href="{{url(Auth::user()->role->name.'/dashboard')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-home mr-3"></span>
                    <span class="menu-collapsed">Dashboard <i>{{Auth::user()->user_details->unique_code}}</i></span>
                </div>
            </a>

            <a href="{{url(Auth::user()->role->name.'/allbookings')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-plane  mr-3"></span>
                    <span class="menu-collapsed">All Bookings</span>    
                </div>
            </a>


            <a href="{{ url(Auth::user()->role->name.'/payment-request') }}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-plane  mr-3"></span>
                    <span class="menu-collapsed">Payment Request</span>   
                </div>
            </a>

            <a href="{{ url(Auth::user()->role->name.'/all-transcation') }}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-file-alt mr-3"></span>
                    <span class="menu-collapsed">Report</span>    
                </div>
            </a>



            
            <!--
            <a href="{{url(Auth::user()->role->name.'/allbookings')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-plane  mr-3"></span>
                    <span class="menu-collapsed">All Bookings</span>    
                </div>
            </a>-->

            
            <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-edit mr-3"></span>
                    <span class="menu-collapsed">Wallet Balance</span>
                    <span class="fas fa-angle-down ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            
            <div id='submenu1' class="collapse sidebar-submenu">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Credit Pending : {{Auth::user()->user_details->pending != '' ? Auth::user()->user_details->pending :0}}</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Credit  : {{Auth::user()->user_details->credit != '' ? Auth::user()->user_details->credit :0}}</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Credit Advance: {{Auth::user()->user_details->advance != '' ? Auth::user()->user_details->advance :0}}</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Cash : {{Auth::user()->user_details->cash != '' ? Auth::user()->user_details->cash :0}}</span>
                </a>
            </div>
            

            <!--
            <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-ticket-alt mr-3"></span>
                    <span class="menu-collapsed">Ticket/Vouchers</span>
                    <span class="fas fa-angle-down ml-auto"></span>
                </div>
            </a>
            
            <div id='submenu2' class="collapse sidebar-submenu">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Settings</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Password</span>
                </a>
            </div>            
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-rupee-sign mr-3"></span>
                    <span class="menu-collapsed">Claim Refund/File TDR</span>    
                </div>
            </a>
           -->
           <!--
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-list-ul mr-3"></span>
                    <span class="menu-collapsed">Flight Refund Status</span>    
                </div>
            </a>-->
            
            <!--
              <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-money-bill-alt mr-3"></span>
                    <span class="menu-collapsed">Ecash</span>
                    <span class="fas fa-angle-down ml-auto"></span>
                </div>
            </a>
            <div id='submenu3' class="collapse sidebar-submenu">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Charts</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Reports</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Tables</span>
                </a>
            </div>
           -->

           <a href="{{ url(Auth::user()->role->name.'/dashboard') }}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-user-alt mr-3"></span>
                    <span class="menu-collapsed">Your Profile</span>    
                </div>
            </a>
            <a href="{{ url(Auth::user()->role->name.'/make-payment') }}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-angle-left mr-3"></span>
                    <span class="menu-collapsed">Make Payment</span>    
                </div>
            </a>
           
            @if(Auth::user()->hasRole('distributor'))
            <a href="{{url('distributor/manage-agents')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-user-friends mr-3"></span>
                    <span class="menu-collapsed">Manage Agents</span>    
                </div>
            </a>
            <a href="{{url('distributor/wallet-transaction')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-money-check-alt mr-3"></span>
                    <span class="menu-collapsed">Manage Account</span>    
                </div>
            </a>
            <a href="{{url('distributor/credit/request')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-money-check-alt mr-3"></span>
                    <span class="menu-collapsed">Credit Request</span>    
                </div>
            </a>
            @endif

        <!--
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-pencil-alt mr-3"></span>
                    <span class="menu-collapsed">Your Communication</span>    
                </div>
            </a>
          -->
        </ul>
    </div>