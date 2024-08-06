<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transaction;
use App\Models\Admin\Message;
use App\Models\Admin\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Hashids;

class TransactionController extends Controller
{
    public function store(Request $request)
    {   
        $transaction = Transaction::where('transaction_hash',$request->input('transaction_hash'))->first();
        if($transaction)
        {
            return response()->json([
                'message' => 'Duplicate transaction hashes are not allowed.',
            ], 200, ['Content-Type' => 'application/json']);
        }
        else
        {
            $message_id = Hashids::decode($request->input('record_id'))[0];
            $message = Message::where('id',$message_id)->first();

            $wallet = Wallet::where('id',$request->input('wallet_id'))->first();
            if($wallet->ticker == 'BTC')
            {
                if($request->input('deposit_amount') < $message->cost_btc)
                {
                    return response()->json([
                        'message' => 'Please enter valid amount. Amount should be match with message cost.',
                    ], 200, ['Content-Type' => 'application/json']);
                }
            }
            else if($wallet->ticker == 'ETH')
            {
                if($request->input('deposit_amount') < $message->cost)
                {
                    return response()->json([
                        'message' => 'Please enter valid amount. Amount should be match with message cost.',
                    ], 200, ['Content-Type' => 'application/json']);
                }
            }

            $transaction = new Transaction();
            $transaction->fill($request->input());
            $transaction->message_id = $message_id;
            $transaction->save();
    
            return response()->json([
                'transaction' => $transaction,
            ], 200, ['Content-Type' => 'application/json']);
        }
        
    }
}
