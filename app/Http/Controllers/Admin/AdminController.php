<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['total_wallets'] = DB::table('wallets')->get()->count();
        $data['total_messages'] = DB::table('messages')->get()->count();
        return view('admin.dashboard')->with($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auth.register');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, [
          'name'          => 'required',
          'email'         => 'required',
          'password'      => 'required'
        ]);
        // store in the database
        $admins = new AdminModel;
        $admins->name = $request->name;
        $admins->email = $request->email;
        $admins->password=bcrypt($request->password);
        $admins->save();
        return redirect()->route('admin.auth.login');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile() 
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $file = $request->file('profile_image');
        $input = $request->all();
        $user = Auth::user();

        //MAKE DIRECTORY 
        $upload_path = 'public/uploads/users/' . Hashids::encode($user->id);
        if (!File::exists(public_path() . '/storage/uploads/users/' . Hashids::encode($user->id))) {
            Storage::makeDirectory($upload_path);
        }

        $validator = Validator::make($request->all(), [
            'email' => ['required','email','string',Rule::unique('admins')->ignore($input['id'])],
        ]);

        if ($validator->fails())
        {
            Session::flash('flash_danger', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
        
        if (!empty($request->files) && $request->hasFile('profile_image'))
        {
            $file = $request->file('profile_image');
            $type = $file->getClientOriginalExtension();
            if ($type == 'jpg' or $type == 'JPG' or $type == 'PNG' or $type == 'png' or $type == 'jpeg' or $type == 'JPEG')
            {
                $file_temp_name = 'profile-image-' . time() . '.' . $type;

                $old_file = public_path() . '/storage/uploads/users/' . Hashids::encode($user->id) . '/' . $user->profile_image;
                if (file_exists($old_file) && !empty($user->profile_image)) 
                {
                    Storage::delete($upload_path . '/' . $user->profile_image);
                }
                $path = Storage::putFileAs($upload_path, $request->file('profile_image'), $file_temp_name);
                $input['profile_image'] = $file_temp_name; 
            }
        }

        $password = $request->input('password');

        if(!empty($password))
        {
            $input['original_password'] = $password;
            $input['password'] = Hash::make($password);
            
        }
        else{
            unset($input['password']);
        }
        
        $user->update($input);
        $request->session()->flash('flash_success', 'Profile has been updated successfully!');
        return redirect('admin/profile');
    }
}