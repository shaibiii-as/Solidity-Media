@extends('admin.layouts.app')

@section('title', 'Wallets')

@section('content')
<div class="content-heading clearfix">
    <div class="heading-left">
      <h1 class="page-title">Messages</h1>
      <p class="page-subtitle">Message Detail</p>
    </div>
    <ul class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{url('admin/messages')}}"><i class="fa fa-address-card"></i> Messages</a></li>
      <li>Detail</li>
    </ul>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">Message Detail</h3>
          </div>
          <div class="panel-body">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <td><strong>Type:</strong></td>
                  <td>
                    @if(!empty($model->file_type))
                        {{$model->file_type}}
                    @else
                        text/plain
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><strong>Size:</strong></td>
                  <td>{{$model->size}} KiB</td>
                </tr>
                <tr>
                  <td><strong>Cost ETH:</strong></td>
                  <td>{{$model->cost}}</td>
                </tr>
                <tr>
                    <td><strong>Cost BTC:</strong></td>
                    <td>{{$model->cost_btc}}</td>
                  </tr>
                <tr>
                  <td><strong>Text:</strong></td>
                  <td>{!!empty($model->text) ? '<i>(Not Set)</i>' : $model->text!!}</td>
                </tr>
                <tr>
                  <td><strong>File:</strong></td>
                  <td>{!!empty($model->file_name) ? '<i>(Not Set)</i>' : $model->file_name!!}</td>
                </tr>
                <tr>
                  <td><strong>Hash:</strong></td>
                  <td>
                    @if(empty($model->file_hash))
                      <i>(Not Set)</i>
                    @else
                      <a href="https://ipfs.io/ipfs/{{$model->file_hash}}" target="_blank">{{$model->file_hash}}</a>
                    @endif
                  </td>
                </tr>
                @if($transaction)
                  <tr>
                    <td><strong>Wallet:</strong></td>
                    <td>{{walletTypes()[$transaction->wallet_id]}}</td>
                  </tr>
                  <tr>
                    <td><strong>Transaction Hash:</strong></td>
                    <td>
                        @if($transaction->wallet_id == 1)
                          <a href="{{BLOCKCYPHER_BTC_TEST_TX.$transaction->transaction_hash}}" target="_blank">{{$transaction->transaction_hash}}</a>
                        @elseif($transaction->wallet_id == 2)
                          <a href="{{ETHERSCAN_TEST_TX.$transaction->transaction_hash}}" target="_blank">{{$transaction->transaction_hash}}</a>
                        @endif
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Deposit Amount:</strong></td>
                    <td>{{$transaction->deposit_amount}}</td>
                  </tr>
                @endif
                <tr>
                  <td><strong>Created At:</strong></td>
                  <td>{{date('d M, Y H:i:s',strtotime($model->created_at))}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection