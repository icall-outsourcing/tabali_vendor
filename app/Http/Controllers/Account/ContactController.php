<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Basic
            $form       = new \App\Contact;
            $create     = 'create';
            $route      = 'Contact.store';        
        return view('Account.Contact.create',compact('form','create','route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
            $this->validate($request, ['contactphone.*'=>'required|unique:phones,phone'],['contactphone.*'=>'This phone number has already been taken']);
        //append Request
            $request->request->add(['created_by' => Auth::user()->id]);
        //create Contact
            $Contact = \App\Contact::create($request->all());
        //Create Phone for Contact
            if(!empty($request->contactphone)){foreach ($request->contactphone as $phone) {\App\Phone::create(['phone'=> $phone,'contact_id'=> $Contact->id]);}};
        //attached with acounts
            $Contact->accounts()->attach($request->account_id);
        // return redirect()->route('Customer.index');
            $phone = \App\Phone::where('contact_id',$Contact->id)->get();
        return Response()->json(array($phone,$Contact));
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
        $model      = new \App\Contact;        
        return view('Account.Contact.create',compact('model'));
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
        $form       = new \App\Contact;
        $create     = 'edit';
        $route      = 'Contact.update';
        $EditData   = \App\Contact::find($id);
        return view('Account.Contact.edit',compact('form','create','route','EditData'));

       //return redirect()->route('Account.create');
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
        $this->validate($request, ['contact_name'=>'required','phone_number'=>'required']);
        $Contact = \App\Contact::find($id);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Contact = $Contact->update($request->all()/*except(['phone_number'])/* $request->all()*/);
        return redirect()->route('Search',array('search' => $request->phone_number));
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

    public function linkcontact(Request $request)
    {
        // search 
            $Account    =  \App\Account::find($request->account);
            $Phone      =  \App\Phone::where('phone',$request->phone)->first();
            
        //check route
            if(!empty($Phone)){
                if($request->link == 'unlink'){
                    if(Auth::user()->is('admin')){
                        
                        $Account->contacts()->detach($request->remove);
                        return Response()->json(array($request->remove,$Account->id,'remove'));
                    }else{
                        return Response()->json('fail');
                    }
                }else{
                    $Contact    =  $Phone->contact;
                    // $Account->contacts()->detach($Contact->id);
                    $Account->contacts()->attach($Contact->id);
                    return Response()->json(array($Contact,$Phone,'success'));
                }
            }else{
                return Response()->json('fail');                
            } 
    }
}
