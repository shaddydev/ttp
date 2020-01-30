<div class="sidebar" data-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a class="simple-text logo-normal" href="{{ url('admin/dashboard') }}"><img src="{{ asset('public/images/logo.png') }}" alt="logo"></a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
          @if(Auth::user()->profile_pic==null)
            <img src="{{ asset('public/images/default-avatar.png') }}" />
          @else
            <img src="{{ asset('public/uploads/users/profile')}}/{{Auth::user()->profile_pic}}"/>
          @endif
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
                <span>
                  <span class="sidebar-normal"> {{ Auth::user()->fname }}  {{ Auth::user()->lname }} </span>
                  <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('admin/profile') }}">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                </li>
               
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item <?php if(Request::segment(2) == 'dashboard') echo "active"?>">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
          @if(Auth::User()->hasRole('admin'))
          <li class="nav-item <?php if(Request::segment(2) == 'access') echo "active"?>">
            <a class="nav-link" href="{{ url('admin/access/permission') }}">
              <i class="material-icons">pan_tool</i>
              <p> Assign Permission </p>
            </a>
          </li>
          <li class="nav-item <?php if(Request::segment(2) == 'bankdetail') echo "active"?>">
            <a class="nav-link" href="{{ url('admin/bankdetail') }}">
              <i class="material-icons">account_balance</i>
              <p> Bank Detail </p>
            </a>
          </li>
          <li class="nav-item <?php if(Request::segment(2) == 'payment-receive') echo "active"?>">
            <a class="nav-link" href="{{ url('admin/payment-receive') }}">
              <i class="material-icons">trending_flat</i>
              <p> Payment Receive </p>
            </a>
          </li>
          @endif
          <?php $menus =  getsidebar(Session::get('logRole'));?>
           @foreach($menus as $menu)
           @if(($menu->visiable == 1))
          <li class="nav-item <?php if(Request::segment(2) == $menu->slug) echo "active"?>">
            <a class="nav-link" href="{{ url('admin/').'/'.$menu->slug }}">
              <i class="material-icons">{{$menu->icon}}</i>
              <p> {{$menu->name}}</p>
            </a>
          </li>

          @endif
          @endforeach
         

        </ul>
      </div>
    </div>