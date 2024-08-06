<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    
    protected $fillable = ['wallet_id','message_id','deposit_amount','transaction_hash'];
}