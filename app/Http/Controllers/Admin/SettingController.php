<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;
use DB;
use File;
use Storage;

class SettingController extends Controller
{
    public function index()
    {
        $result =   DB::table('settings')->get()->toArray();
        $row = [];
        foreach ($result as $value) 
        {
            $row[$value->option_name] = $value->option_value;
        }
        $data['settings'] = $row;
        return view('admin.settings')->with($data);
    }

    public function updateSettings(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);

        //MAKE DIRECTORY
        $upload_path = 'public/uploads/settings/';
        if (!File::exists(public_path() . '/storage/uploads/settings/')) {
            Storage::makeDirectory($upload_path);
        }

        if (!empty($request->files) && $request->hasFile('site_logo'))
        {
            $file = $request->file('site_logo');
            $type = $file->getClientOriginalExtension();
            if ($type == 'jpg' or $type == 'JPG' or $type == 'PNG' or $type == 'png' or $type == 'jpeg' or $type == 'JPEG')
            {
                $file_temp_name = 'site_logo.' . $type;
                Storage::putFileAs($upload_path, $request->file('site_logo'), $file_temp_name);
                $input['site_logo'] = $file_temp_name; 
            }
        }

        if (!empty($request->files) && $request->hasFile('site_favicon'))
        {
            $file = $request->file('site_favicon');
            $type = $file->getClientOriginalExtension();
            if ($type == 'jpg' or $type == 'JPG' or $type == 'PNG' or $type == 'png' or $type == 'jpeg' or $type == 'JPEG')
            {
                $file_temp_name = 'site_favicon.' . $type;
                Storage::putFileAs($upload_path, $request->file('site_favicon'), $file_temp_name);
                $input['site_favicon'] = $file_temp_name; 
            }
        }

        foreach ($input as $key => $value)
        {
            $result = DB::table('settings')->where('option_name',$key)->get();

            if($result->isEmpty())
            {
                DB::table('settings')->insert(['option_name'=>$key,'option_value' => $value]);
            }
            else
            {
                DB::table('settings')->where('option_name',$key)->update(['option_value' => $value]);
            }
        }
        Session::flash('flash_success', 'Site Settings has been updated successfully.');
        return redirect()->back();
    }
}
