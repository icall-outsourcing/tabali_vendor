<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;
use Mail;


class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model    = new \App\Complaint;
        $datatable = \App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->orderBy('id','desc')->paginate(10);
        return view('Complaint.index',compact('model','datatable'));
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
            $branch     = \App\Branch::find(Input::get('branch'));
            $form       = new \App\Complaint;
            $create     = 'create';
            $route      = 'Complaint.store';
            return view('Complaint.create',compact('form','create','route','account','contact','branch'));
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
        $this->validate($request, ['account_id' => 'required','contact_id' => 'required','follow_up_phone'=>'required','complaint_type'=>'required','complain_comment'=>'required']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $Complaint= \App\Complaint::create($request->all());
        #$this->sendmail($Complaint->id);
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
        $form       = new \App\Complaint;
        $create     = 'edit';
        $route      = 'Complaint.show';
        $ShowData   = \App\Complaint::find($id);
        return view('Complaint.show',compact('form','create','route','ShowData'));
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
        $form       = new \App\Complaint;
        $create     = 'edit';
        $route      = 'Complaint.update';
        $EditData   = \App\Complaint::find($id);
        return view('Complaint.edit',compact('form','create','route','EditData'));
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
        $this->validate($request, ['close_complain_comment'=>'required']);
        $Complaint = \App\Complaint::find($id);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Complaint->close_complain_comment =  $request->close_complain_comment;
        $Complaint->status =  $request->status;
        $Complaint->save();
        return redirect()->route('Complaint.index');
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
  
    public function sendmail($id){
       $data   = \App\Complaint::with('branch')->with('contact')->with('created_name')->find($id);
       Mail::send('Emails.Complaint', ['data' => $data], function ($message) use ($data) {
                $message->from(Auth::user()->email, Auth::user()->name);
                $message->to('ahmed.sabry@gadfood.net')
                ->to('sabrya958@gmail.com')
                ->to('amrgad9@hotmail.com')
                ->to('amr.gad@gadfood.net')
                ->to('mohamed.asaad@gadfood.net')
                ->to('hanyoohalim@yahoo.com')
                ->subject($data->branch->name.' / '.$data->complaint_type .'Ticket ID#'.$data->id);
                
                });
            
    }

}
