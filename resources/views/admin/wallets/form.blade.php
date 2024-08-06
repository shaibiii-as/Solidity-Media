@extends('admin.layouts.app')

@section('title', 'Wallets')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Wallets</h1>
      <p class="page-subtitle">{{$action}} Wallet</p>
    </div>
    <ul class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{url('admin/wallets')}}"><i class="fa fa-address-card"></i> Wallets</a></li>
      <li>{{$action}}</li>
    </ul>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">{{$action}} Wallet</h3>
          </div>
          <div class="panel-body">
            @include('admin.messages')
            <form id="wallet-form" class="form-horizontal label-left" action="{{url('admin/wallets')}}" enctype="multipart/form-data" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="action" value="{{$action}}" />
              <input name="id" type="hidden" value="{{ $model->id }}"/>

              <div class="form-group">
                <label class="col-sm-3 control-label">Type*</label>
                <div class="col-sm-9">
                  <select class="form-control" name="type" required="">
                    <option value="">Select Type</option>
                    @foreach(walletTypes() as $key => $value)

                      <option value="{{$key}}" <?php echo ($key == $model->type) ? 'selected' : '' ?>>{{$value}}</option>

                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Ticker*</label>
                <div class="col-sm-9">
                  <input type="text" name="ticker" class="form-control" required="" value="{{$model->ticker}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Symbol*</label>
                <div class="col-sm-9">
                  <input type="text" name="symbol" class="form-control" required="" value="{{$model->symbol}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Address*</label>
                <div class="col-sm-9">
                  <input type="text" name="address" class="form-control" required="" value="{{$model->address}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Status</label>
                <div class="col-sm-9">
                  <label class="fancy-radio">
                    <input name="status" value="1" type="radio" <?php echo ($model->status == 1) ? 'checked' : '' ?>>
                    <span><i></i>Active</span>
                  </label>
                  <label class="fancy-radio">
                    <input name="status" value="0" type="radio" <?php echo ($model->status == 0) ? 'checked' : '' ?>>
                    <span><i></i>In-Active</span>
                  </label>
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
        $('#wallet-form').validate({
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