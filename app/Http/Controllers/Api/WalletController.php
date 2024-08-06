<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Hashids;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('status',1)->get();

        foreach ($wallets as $wallet) 
        {
            $wallet['type'] = walletTypes()[$wallet['type']];
        }

        return response()->json([
            'wallets' => $wallets,
        ], 200, ['Content-Type' => 'application/json']);
    }
}
