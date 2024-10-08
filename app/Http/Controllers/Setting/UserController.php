<?php

namespace App\Http\Controllers\Setting;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;
use GoogleCloudPrint;        
use Bnb\GoogleCloudPrint\PrintApi;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model    = new \App\User;
        $datatable = \App\User::orderBy('id','desc')->paginate(10);
        return view('Setting.User.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::user()->is('helpdesk')){  
            return redirect()->route('home');
        }else{
            $form   = new \App\User;
            $create = 'create';
            $route  = 'User.store';            
            return view('Setting.User.create',compact('form','create','route','printers'));

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //                
            $this->validate($request, ['name'=>'required','password'=>'required','email'=>'required|email|unique:users,email','roles_list'=>'required','permissions_list'=>'required']);
            $request->request->add(['created_by' => Auth::user()->id]);
            $user = \App\User::create($request->except('roles_list','permissions_list'.'printers'));
            $user->attachRole($request->roles_list);
            $user->printers()->attach($request->printers);
            $user->attachPermission($request->permissions_list);
            return redirect()->route('User.index');
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
        if(Auth::user()->is('admin||helpdesk')){
            $form       = new \App\User;
            $create     = 'edit';
            $route      = 'User.update';
            $EditData   = \App\User::find($id);
            return view('Setting.User.edit',compact('form','create','route','EditData'));
        }
        return redirect()->route('home');
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
        if(Auth::user()->is('helpdesk')){
            if(!empty($request->printers)){
                $user   = \App\User::find($id);
                $user->printers()->sync($request->printers);
            }
            return redirect()->route('User.index');
        }


        if(Auth::user()->is('admin')){
            //
            $this->validate($request, ['name'=>'required','email'=>'required|email|unique:users,email,'.$id,'roles_list'=>'required','permissions_list'=>'required']);
            $user   = \App\User::find($id);
            if(empty($request->password)){
                $update = $user->update($request->except('password','roles_list','permissions_list'));
            }else{
                $update = $user->update($request->except('roles_list','permissions_list','printers'));    
            }
            if(!empty($request->printers)){
                $user->printers()->sync($request->printers);
            }
            $user->roles()->sync($request->roles_list);
            $user->userPermissions()->sync($request->permissions_list);
            return redirect()->route('User.index');
        }
        return redirect()->route('home');        
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
        if(Auth::user()->is('admin')){
            $user = \App\User::find($id)->delete();
            // return response()->json(array('status'=>'success','message '=> $user->id));
            return Response()->json($id);        
        }

        return redirect()->route('home');

    }
    
    
    public function postpassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['password'=>'required|min:3|confirmed','password_confirmation'=>'required|min:3'],
            ['password.required'=> 'يجب ادخال الباسورد','password_confirmation.required'=> 'يجب تاكيد ادخال الباسورد','password.confirmed'=> 'يرجى التاكد من تظابق الباسورد',]
        );
        // return $request->password;
        $validator->after(function($validator) use($request) {
            $password               = $password = $request['password'];
            $password_confirmation  = $password_confirmation = $request['password_confirmation'];
        });
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ];
        }else{
            $user = \App\User::find(Auth::user()->id);
            $user->password = $request->password;
            $user->save();
            auth()->logout();
            return redirect('/');
            
        }
    }
}
