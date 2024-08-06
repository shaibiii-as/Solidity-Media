@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Profile</h1>
    </div>
    <ul class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
      <li>Profile</li>
    </ul>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">My Profile</h3>
          </div>
          <div class="panel-body">
            @include('admin.messages')
            <form id="profile-form" class="form-horizontal label-left" action="{{ route('admin.profile') }}" enctype="multipart/form-data" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{Auth::user()->id}}">
              <div class="form-group">
                <label class="col-sm-3 control-label">First Name*</label>
                <div class="col-sm-9">
                  <input type="text" name="first_name" class="form-control" required="" value="{{Auth::user()->first_name}}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Last Name</label>
                <div class="col-sm-9">
                  <input type="text" name="last_name" class="form-control" value="{{Auth::user()->last_name}}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Email*</label>
                <div class="col-sm-9">
                  <input type="email" name="email" class="form-control" required="" value="{{Auth::user()->email}}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Profile Image</label>
                <div class="col-sm-9">
                  <img src="{{checkImage(asset(env('PUBLIC_PREFIX').'storage/uploads/users/' . Hashids::encode(Auth::user()->id) . '/' . Auth::user()->profile_image),'user.png')}}" width="150" class="rounded-circle" alt="user" />
                  <input type="file" name="profile_image" class="form-control">
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" name="password" id="password" minlength="6" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Confirm Password</label>
                <div class="col-sm-9">
                  <input type="password" name="confirm_password" class="form-control">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-fullrounded center-block"><i class="fa fa-check-circle"></i>
                <span>Update</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $(function(){
        $('#profile-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            
            rules: {
                confirm_password: {
                  equalTo: "#password"
                },
            },
            
            highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');
            $(e).remove();
            },
            errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
            var controls = element.closest('div[class*="col-"]');
            if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
            else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            } else if (element.is('.select2')) {
            error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            } else if (element.is('.chosen-select')) {
            error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else
                    error.insertAfter(element);
            },
            invalidHandler: function (form) {
            }
        });
    });

</script>

@endsection