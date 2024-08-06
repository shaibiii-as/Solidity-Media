@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Dashboard</h1>
    </div>
    <ul class="breadcrumb">
      <li><i class="fa fa-home"></i> Dashboard</li>
    </ul>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-sm-6">
        <div class="widget widget-stat">
          <div class="media">
            <div class="media-left media-middle"> <i class="ti-wallet icon-transparent-area custom-color-purple"></i> </div>
          <div class="media-body"> <span class="title">Wallets</span> <span class="value">{{$total_wallets}}</span> </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="widget widget-stat">
          <div class="media">
            <div class="media-left media-middle"> <i class="ti-email icon-transparent-area custom-color-lightseagreen"></i> </div>
            <div class="media-body"> <span class="title">Messages</span> <span class="value">{{$total_messages}}</span> </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection