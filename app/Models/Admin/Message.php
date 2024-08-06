<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    
    protected $fillable = ['text','size','cost','cost_btc','file_name','file_type','file_hash'];

    public function transaction()
    {
        return $this->hasOne('App\Models\Admin\Transaction');
    }
}