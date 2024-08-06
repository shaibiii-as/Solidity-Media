@extends('admin.layouts.app')

@section('title', 'Wallets')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Wallets</h1>
      <p class="page-subtitle">Listing</p>
    </div>
    <ul class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
      <li>Wallets</li>
    </ul>
</div>
<div class="container-fluid">
  
  <div class="row">
    <div class="col-md-12">
      <a href="{{url('admin/wallets/create')}}" class="pull-right">
        <button type="button" class="btn btn-primary btn-lg btn-fullrounded">
          <span>Add</span>
        </button>
      </a>
    </div>
  </div>
  <br>
  @include('admin.messages')
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">Wallets Listing</h3>
    </div>
    <div class="panel-body">
      <table id="featured-datatable" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Symbol</th>
            <th>Ticker</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($models as $model)
            <tr>
              <td>{{$model->id}}</td>
              <td>{{walletTypes()[$model->type]}}</td>
              <td>{{$model->symbol}}</td>
              <td>{{$model->ticker}}</td>
              <td>{{$model->address}}</td>
              <td>
                @if($model->status == 0)
                  <span class="label label-danger">In-Active</span>
                @else
                  <span class="label label-success">Active</span>
                @endif
              </td>
              <td>
                <span class="actions">
                  <a href="{{url('admin/wallets/' . Hashids::encode($model->id) . '/edit')}}"><i class="fa fa-pencil"></i></a>
                  <form method="POST" action="{{url('admin/wallets/'.Hashids::encode($model->id)) }}" accept-charset="UTF-8" style="display:inline">
                      <input type="hidden" name="_method" value="DELETE">
                      <input name="_token" type="hidden" value="{{csrf_token()}}">
                      <button class="btn-link" style="cursor: pointer;color:#BD0D11" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                      </button>
                  </form>
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('js')

<script>
    $(function()
    {
      $('#featured-datatable').dataTable(
      {
        sDom: "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        order: [ 0, 'desc' ]
      });
    });
</script>

@endsection