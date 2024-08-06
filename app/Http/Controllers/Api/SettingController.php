<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SettingController extends Controller
{
    public function index()
    {
        $result = DB::table('settings')->get()->toArray();
        $settings = [];
        foreach ($result as $value) 
        {
            $settings[$value->option_name] = $value->option_value;
        }

        return response()->json([
            'settings' => $settings,
        ], 200, ['Content-Type' => 'application/json']);
    }
}
