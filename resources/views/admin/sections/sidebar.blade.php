@php
  $segment_2 = Request::segment(2);
  $segment_3 = Request::segment(3);
@endphp

<div id="sidebar-nav" class="sidebar">
  <nav>
    <div class="brand"> <a href="{{url('admin/dashboard')}}"> <img src="{{ siteIcon('site_logo','site-logo.png') }}" alt="{{settingValue('site_title')}}" class="img-responsive logo"> </a> </div>
    <ul class="nav" id="sidebar-nav-menu">
      <li>
        <a  href="{{url('admin/dashboard')}}" class="{{($segment_2 == 'dashboard') ? 'active' : ''}}" >
          <i class="ti-dashboard"></i> <span class="title">Dashboard</span>
        </a>
      </li>
      <li>
        <a  href="{{url('admin/wallets')}}" class="{{($segment_2 == 'wallets') ? 'active' : ''}}">
          <i class="ti-wallet"></i> <span class="title">Wallets</span>
        </a>
      </li>
      <li>
        <a  href="{{url('admin/messages')}}" class="{{($segment_2 == 'messages') ? 'active' : ''}}">
          <i class="ti-email"></i> <span class="title">Messages</span>
        </a>
      </li>
      <li>
        <a  href="{{url('admin/settings')}}" class="{{($segment_2 == 'settings') ? 'active' : ''}}">
          <i class="ti-settings"></i> <span class="title">Settings</span>
        </a>
      </li>
    </ul>
  </nav>
</div>