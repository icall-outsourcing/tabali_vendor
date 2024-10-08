<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;



class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model    = new \App\Inquiry;
        $datatable = \App\Inquiry::orderBy('id','desc')->paginate(10);
        return view('Inquiry.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Basic
            $account    = \App\Account::find(Input::get('account'));
            $contact    = \App\Contact::find(Input::get('contact'));
            $form       = new \App\Inquiry;
            $create     = 'create';
            $route      = 'Inquiry.store';
			return view('Inquiry.create',compact('form','create','route','account','contact','branch'));
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
        $this->validate($request, ['account_id' => 'required','contact_id' => 'required','follow_up_phone'=>'required','inquiry_type'=>'required','inquiry_comment'=>'required']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $BankBranch = \App\Inquiry::create($request->all());
        return redirect()->route('home');
       
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
        $form       = new \App\Inquiry;
        $create     = 'edit';
        $route      = 'Inquiry.update';
        $EditData   = \App\Inquiry::find($id);
        return view('Inquiry.edit',compact('form','create','route','EditData'));
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
        $this->validate($request, ['close_inquiry_comment'=>'required']);
        $Inquiry = \App\Inquiry::find($id);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Inquiry->close_inquiry_comment =  $request->close_inquiry_comment;
        $Inquiry->status =  $request->status;
        $Inquiry->save();
        return redirect()->route('Inquiry.index');
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
}
