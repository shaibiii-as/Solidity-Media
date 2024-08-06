<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;
use Hashids;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = Wallet::all();
        return view('admin.wallets.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model'] = new Wallet();
        $data['action'] = "Add";
        return view('admin.wallets.form')->with($data);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if($input['action'] == 'Add')
        {
            $validator = Validator::make($request->all(), [
                'type' => ['required','string',Rule::unique('wallets')],
                'address' => ['required','string',Rule::unique('wallets')],
            ]);
            
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }

            $model = new Wallet();
            $model->fill($input);
            $model->save();
            $request->session()->flash('flash_success', 'Wallet has been added successfully.');
            return redirect('admin/wallets');
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'type' => ['required','string',Rule::unique('wallets')->ignore($input['id'])],
                'address' => ['required','string',Rule::unique('wallets')->ignore($input['id'])],
            ]);

            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }

            $model = Wallet::findOrFail($input['id']);
            $model->fill($input);
            $model->save();
            $request->session()->flash('flash_success', 'Wallet has been updated successfully.');
            return redirect('admin/wallets/'.Hashids::encode($input['id']).'/edit');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Hashids::decode($id)[0];
        $data['action'] = "Edit";
        $data['model'] = Wallet::findOrFail($id);
        return view('admin.wallets.form')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Hashids::decode($id)[0];
        Wallet::destroy($id);
        Session::flash('flash_success', 'Wallet has been deleted successfully.');
        return redirect('admin/wallets');
    }
}
