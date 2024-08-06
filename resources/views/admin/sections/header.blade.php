<!-- NAVBAR -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div id="navbar-menu">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="{{checkImage(asset(env('PUBLIC_PREFIX').'storage/uploads/users/' . Hashids::encode(Auth::user()->id) . '/' . Auth::user()->profile_image),'user.png')}}" alt="Avatar"> <span>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span> </a>
          <ul class="dropdown-menu logged-user-menu">
            <li><a href="{{ route('admin.profile') }}"><i class="ti-user"></i> <span>My Profile</span></a></li>
            <li>
                <a href="{{ route('admin.auth.logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="ti-power-off"></i> <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('admin.auth.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
          </ul>
        </li>
        <li>
          <div id="tour-fullwidth" class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="ti-arrow-circle-left"></i></button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- END NAVBAR --> 