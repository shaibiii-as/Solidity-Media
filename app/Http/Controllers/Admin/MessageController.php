<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Message;
use App\Models\Admin\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Hashids;
use DB;
use Session;
use View;

class MessageController extends Controller
{
    public function index()
    {
        $data['unverified_messages'] = Message::where('is_verified',0)->get();
        $data['verified_messages'] = Message::where('is_verified',1)->get();
        return view('admin.messages.index',$data);
    }

    public function show($id)
    {
        $id = Hashids::decode($id)[0];
        $data['model'] = Message::findOrFail($id);
        $data['transaction'] = $data['model']->transaction;
        return view('admin.messages.show')->with($data);
    }

    public function transactions_verification()
    {
        $messages = Message::where('is_verified',0)->get();
        $flag = false;
        foreach ($messages as $message) 
        {
            if($message->transaction)
            {
                $url = '';
                $wallet = Wallet::where('id',$message->transaction->wallet_id)->first();
                if($wallet->ticker == 'BTC')
                {
                    $url = BLOCKCYPHER_BTC_TEST_TX_API.$message->transaction->transaction_hash;
                }
                else if($wallet->ticker == 'ETH')
                {
                    $url =  ETHERSCAN_TEST_TX_API.$message->transaction->transaction_hash.'&apikey='.ETHERSCAN_API_KEY;
                }
                
                if(!empty($url))
                {
                    // Get cURL resource
                    $curl = curl_init();
                    // Set some options - we are passing in a useragent too here
                    curl_setopt_array($curl, [
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => $url,
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
                    ]);
                    // Send the request & save response to $resp
                    $resp = curl_exec($curl);
                    $resp = json_decode($resp,true);
                    // Close request to clear up some resources
                    curl_close($curl);
                    
                    if(!empty($resp))
                    {
                        if($wallet->ticker == 'BTC')
                        {
                            if(!array_key_exists('error',$resp))
                            {
                                $flag = true;
                                DB::table('messages')->where('id',$message->id)->update(['is_verified' => 1]);
                            }
                        }
                        else if($wallet->ticker == 'ETH')
                        {
                            if($resp['result']['status'])
                            {
                                $flag = true;
                                DB::table('messages')->where('id',$message->id)->update(['is_verified' => 1]);
                            }
                        }
                    }
                }
            }
        }
        if($flag)
            Session::flash('flash_success', 'Messages with valid transaction have been verified successfully.');
        else
            Session::flash('flash_warning', 'No valid transaction found for verification.');
        return redirect()->back();
    }

    public function moveToUnverify($id)
    {
        $id = Hashids::decode($id)[0];
        $message = Message::findOrFail($id);
        $message->is_verified = 0;
        $message->save();
        Session::flash('flash_success', 'Message status has been updated successfully.');
        return redirect()->back();
    }

    public function pushedToBlockchain($id = NULL)
    {
        if(!empty($id))
        {
            $id = Hashids::decode($id)[0];
            $message = Message::findOrFail($id);
            $message->on_blockchain = 1;
            $message->save();
        }
        else
        {
            $messages = Message::where(['is_verified' => 1,'on_blockchain' => 0])->get();

            foreach ($messages as $message)
            {
                $record = Message::findOrFail($message->id);
                $record->on_blockchain = 1;
                $record->save();
            }
        }
    }

    public function pushToBlockchain($id = NULL)
    {
        $singleMessage = '';
        $multipleMessages = '';
        $ajax_url = url('admin/messages/pushed-to-blockchain/');
        if(!empty($id))
        {
            $ajax_url .= '/'.$id;
            $id = Hashids::decode($id)[0];
            $message = Message::findOrFail($id);
            $messageArr = [
                'text'      => !empty($message->text) ? $message->text : '',
                'file_name' => !empty($message->file_name) ? $message->file_name : '',
                'file_type' => !empty($message->file_type) ? $message->file_type : '',
                'file_hash' => !empty($message->file_hash) ? $message->file_hash : '',
                'size'      => !empty($message->size) ? $message->size : '',
                'datetime'  => date('d M, Y H:i:s')
            ];
            $singleMessage = json_encode($messageArr);
        }
        else
        {
            $messages = Message::where(['is_verified' => 1,'on_blockchain' => 0])->get();
            if(count($messages) == 0)
            {
                Session::flash('flash_warning', 'No valid message found for push to Blockchain.');
                return redirect('admin/messages');
            }
            $messageArr = [
                'text'      => [],
                'file_name' => [],
                'file_type' => [],
                'file_hash' => [],
                'size'      => [],
                'datetime'  => date('d M, Y H:i:s')
            ];

            foreach ($messages as $message) {
                $messageArr['text'][] = !empty($message->text) ? $message->text : '';
                $messageArr['file_name'][] = !empty($message->file_name) ? $message->file_name : '';
                $messageArr['file_type'][] = !empty($message->file_type) ? $message->file_type : '';
                $messageArr['file_hash'][] = !empty($message->file_hash) ? $message->file_hash : '';
                $messageArr['size'][] = !empty($message->size) ? $message->size : '';
            }

            $multipleMessages = json_encode($messageArr);
        }
        echo View::make('admin.messages.ptb_header')->render();
        ?>
        <script type="text/javascript">
            $(document).ready(function(){

                var singleMessage = '<?php echo $singleMessage ?>';
                var multipleMessages = '<?php echo $multipleMessages ?>';
                var ajax_url = '<?php echo $ajax_url ?>';

                var progress = '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div>';

                $('#content-wrapper').html('<div class="right_col" role="main"><div><div class="row"><div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12" id="BitcoinPool"><div class="x_panel" style="box-shadow: 0px 0px 10px #000;border-radius: 4px;"><div class="x_content"><div class=""><h1 style="text-align: center;">Push Message To Blockchain</h1>'
                    + '<div class="table-responsive"><table class="table table-bordered table-hover"><tbody id="main_table">'
                    + '<tr><th width="20%">Transaction Hash</th><td id="transaction_hash">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Block Hash</th><td id="block_hash">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Block Number</th><td id="block_number">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Cumulative Gas Used</th><td id="cumulative_gas_used">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Gas Used</th><td id="gas_used">' + progress + '</td></tr>'
                    + '<tr><th width="20%">From</th><td id="from">' + progress + '</td></tr>'
                    + '<tr><th width="20%">To</th><td id="to">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Transaction Index</th><td id="transaction_index">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Confirmations</th><td id="confirmations">' + progress + '</td></tr>'
                    + '<tr><th width="20%">Status</th><td id="status">pending ...</td></tr>'
                    + '</tbody></table></div></div><div class="col-xs-12" id="buttons"></div></div></div></div></div></div></div>');

                var ADMIN_URL = '<?php echo url("admin") ?>';
                var transfer = null;

                if(singleMessage !== '')
                {
                    singleMessage = JSON.parse(singleMessage);
                    console.log('multiple messages',singleMessage);
                    transfer = contract.methods.addMessage(singleMessage.text,singleMessage.file_name,singleMessage.file_type,singleMessage.file_hash,singleMessage.size,singleMessage.datetime);
                }
                else
                {
                    multipleMessages = JSON.parse(multipleMessages);
                    console.log('multiple messages',multipleMessages);
                    transfer = contract.methods.addMultipleMessages(multipleMessages.text,multipleMessages.file_name,multipleMessages.file_type,multipleMessages.file_hash,multipleMessages.size,multipleMessages.datetime);
                }

                var encodedABI = transfer.encodeABI();

                console.log('encodedABI',encodedABI);
                var tx = {
                    from: from_address,
                    to: contract_address,
                    gas: 2000000,
                    data: encodedABI
                };

                web3.eth.sendTransaction(tx)
                .on('confirmation', (confirmationNumber, receipt) => {
                    $("#confirmations").html('<span class="label label-success">' + confirmationNumber + '</span>');
                    })
                .on('transactionHash', hash => {
                    console.log(hash);
                    $('#transaction_hash').html(hash);
                })
                .on('receipt', receipt => {
                    console.log(receipt);
                    $('#block_hash').html(receipt.blockHash);
                    $('#block_number').html(receipt.blockNumber);
                    $('#cumulative_gas_used').html(receipt.cumulativeGasUsed);
                    $('#gas_used').html(receipt.gasUsed);
                    $('#from').html(receipt.from);
                    $('#to').html(receipt.to);
                    $('#transaction_index').html(receipt.transactionIndex);
                    if (receipt.status == "0x1")
                    {
                        console.log('success');
                        $('#status').html("<span style='color: green; '>Success</span>");

                        $.ajax({
                            url: ajax_url,
                            type: "get",
                            success: function (response) {
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                            }
                        });
                    }
                    else
                    {
                        $('#status').html("<span style='color: red; '>Fail</span>");
                    }
                    $('#buttons').html('<br><br><a href="<?php echo url('admin/dashboard'); ?>" class="btn btn-primary">Go To Dashboard</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo url('admin/messages'); ?>" class="btn btn-success">Go Back</a>');
                })
                .on('error', (error) => {
                    error = error.toString();
                    if (error.trim() == 'Error: Returned error: Error: MetaMask Tx Signature: User denied transaction signature.')
                    {
                        error = error.replace('Error: Returned error: Error: MetaMask Tx Signature: ', '').trim();
                        $('.container h1').html('<span style="color:red;">' + error + '</span><br><small>Going back in 5 seconds.</small>');
                        setTimeout(function(){history.back(); }, 5000);
                    }
                    else
                    {
                        alert('Some Error Occured !! May be Metamask is not working.');
                        //window.location.href = ADMIN_URL + '/dashboard';
                    }
                });
            });

        </script>
    <?php
    }
}
