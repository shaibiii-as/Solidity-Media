@extends('admin.layouts.app')

@section('title', 'Messages')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Messages</h1>
      <p class="page-subtitle">Listing</p>
    </div>
    <ul class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
      <li>Messages</li>
    </ul>
</div>
<div class="container-fluid">

  @include('admin.messages')
  
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">Unverified Messages Listing</h3>
      <a href="{{url('admin/messages/transactions-verification')}}" class="pull-right">
        <button type="button" class="btn btn-primary btn-sm btn-fullrounded">
          <span><i class="fa fa-refresh" aria-hidden="true"></i> Transactions Verification</span>
        </button>
      </a>
    </div>
    <div class="panel-body">
      <table id="unverified-datatable" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Size</th>
            <th>Cost ETH</th>
            <th>Cost BTC</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($unverified_messages as $message)
            <tr>
                <td>{{$message->id}}</td>
                <td>
                    @if(!empty($message->file_type))
                        {{$message->file_type}}
                    @else
                        text/plain
                    @endif
                </td>
                <td>{{$message->size}} KiB</td>
                <td>{{$message->cost}}</td>
                <td>{{$message->cost_btc}}</td>
                <td>
                    <span class="actions">
                    <a href="{{url('admin/messages/' . Hashids::encode($message->id))}}"><i class="fa fa-eye"></i></a>
                    </span>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">Verified Messages Listing</h3>
      <a href="{{url('admin/messages/push-to-blockchain')}}" class="pull-right">
        <button type="button" class="btn btn-primary btn-sm btn-fullrounded">
          <span><i class="fa fa-paper-plane" aria-hidden="true"></i> Push To BlockChain</span>
        </button>
      </a>
    </div>
    <div class="panel-body">
      <table id="verified-datatable" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Size</th>
            <th>Cost ETH</th>
            <th>Cost BTC</th>
            <th>On BlockChain</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($verified_messages as $message)
            <tr>
                <td>{{$message->id}}</td>
                <td>
                    @if(!empty($message->file_type))
                        {{$message->file_type}}
                    @else
                        text/plain
                    @endif
                </td>
                <td>{{$message->size}} KiB</td>
                <td>{{$message->cost}}</td>
                <td>{{$message->cost_btc}}</td>
                <td>
                  @if($message->on_blockchain)
                    <span class="label label-success">Yes</span>
                  @else
                    <span class="label label-danger">No</span>
                  @endif
                </td>
                <td>
                    <span class="actions">
                      <a title="View" href="{{url('admin/messages/' . Hashids::encode($message->id))}}"><i class="fa fa-eye"></i></a>

                      @if(!$message->on_blockchain)
                        <a title="Move To Unverify Listing" href="{{url('admin/messages/move-to-unverify/' . Hashids::encode($message->id))}}"><i class="fa fa-times"></i></a>
                        <a title="Push To Blockchain" href="{{url('admin/messages/push-to-blockchain/' . Hashids::encode($message->id))}}"><i class="fa fa-paper-plane"></i></a>
                      @endif
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
      $('#unverified-datatable').dataTable(
      {
        sDom: "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        order: [ 0, 'desc' ]
      });

      $('#verified-datatable').dataTable(
      {
        sDom: "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        order: [ 0, 'desc' ]
      });
    });
</script>

@endsection