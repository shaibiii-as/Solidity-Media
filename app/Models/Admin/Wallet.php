<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
    
    protected $fillable = ['type','ticker','symbol','address','status'];
}