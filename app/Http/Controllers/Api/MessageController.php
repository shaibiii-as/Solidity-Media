<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Hashids;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $message = new Message();
        $message->fill($request->input());
        $message->save();
  
        return response()->json([
            'id' => Hashids::encode($message->id),
        ], 200, ['Content-Type' => 'application/json']);
    }
}
