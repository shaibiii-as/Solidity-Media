@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Settings</h1>
      <p class="page-subtitle">Site Settings</p>
    </div>
    <ul class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
      <li>Settings</li>
    </ul>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Settings</h3>
            </div>
          <div class="panel-body">
            @include('admin.messages')
            <form id="settings-form" class="form-horizontal label-left" action="{{url('admin/settings')}}" enctype="multipart/form-data" method="POST">
              {{ csrf_field() }}

              <div class="form-group">
                <label class="col-sm-3 control-label">Per Kb Cost (Wei)</label>
                <div class="col-sm-9">
                  <input type="number" name="per_kb_cost" class="form-control" value="{{isset($settings['per_kb_cost']) ? $settings['per_kb_cost'] : ''}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Commission (%)</label>
                <div class="col-sm-9">
                  <input type="number" name="commission" class="form-control" value="{{isset($settings['commission']) ? $settings['commission'] : ''}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Site Title</label>
                <div class="col-sm-9">
                  <input type="text" name="site_title" class="form-control" value="{{isset($settings['site_title']) ? $settings['site_title'] : ''}}" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Site Logo</label>
                <div class="col-sm-9">
                    @if(isset($settings['site_logo']) && !empty($settings['site_logo']) && file_exists(public_path() . '/storage/uploads/settings/'.$settings['site_logo']))
                      <img src="{{asset(env('PUBLIC_PREFIX').'storage/uploads/settings/'.$settings['site_logo'])}}" class="rounded-circle" alt="logo" />
                    @endif
                  <input type="file" name="site_logo" class="form-control">
                  <span class="label label-info">Info:</span> Recommended size 200 x 160
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Site Favicon</label>
                <div class="col-sm-9">
                    @if(isset($settings['site_favicon']) && !empty($settings['site_favicon']) && file_exists(public_path() . '/storage/uploads/settings/'.$settings['site_favicon']))
                      <img src="{{asset(env('PUBLIC_PREFIX').'storage/uploads/settings/'.$settings['site_favicon'])}}" class="rounded-circle" alt="favicon" />
                    @endif
                  <input type="file" name="site_favicon" class="form-control">
                  <span class="label label-info">Info:</span> Recommended size 35 x 35
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg btn-fullrounded center-block"><i class="fa fa-check-circle"></i>
                <span>Save</span>
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
        $('#settings-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            
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