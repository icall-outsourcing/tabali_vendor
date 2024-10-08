<?php
namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;
use Response ;

class AddressController extends Controller
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
			$accountId 	=  $_GET['id'];
            $form       = new \App\Address;
            $create     = 'create';
            $route      = 'Address.store';        
        return view('Account.Address.create',compact('form','create','route','accountId'));
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
            $this->validate($request, ['address_type'=>'required','account_id'=>'required','building_number'=>'required','area'=>'required','address'=>'required','branch_id'=>'required']);        
        //append Request
            $area = explode('/', $request->area);
            $request->request->add(['governorate' => $area[0]]);
            $request->request->add(['district' => $area[1]]);
            $request->request->add(['area' => $area[2]]);
            $request->request->add(['created_by' => Auth::user()->id]);
        //create Contact
            $Address = \App\Address::create($request->all());
            return Response()->json('success');
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
        $model      = new \App\Account;        
        return view('Account.Account.create',compact('model'));
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
        $form       = new \App\Address;
        $create     = 'edit';
        $route      = 'Address.update';
        $EditData   = \App\Address::find($id);
        return view('Account.Address.edit',compact('form','create','route','EditData'));
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
        
         //Validation
            $this->validate($request, ['address_type'=>'required','building_number'=>'required','area'=>'required','address'=>'required','branch_id'=>'required']);        
            $Address    = \App\Address::find($id);
            //append Request
            $area = explode('/', $request->area);
            $request->request->add(['governorate' => $area[0]]);
            $request->request->add(['district' => $area[1]]);
            $request->request->add(['area' => $area[2]]);
            $request->request->add(['updated_by' => Auth::user()->id]);
            $Address = $Address->update($request->all());
            $Address    = \App\Address::find($id);        
            $Area       = \App\Area::find($Address->area_id);
            if($Address->discount_id > 0){
                $Discount   = \App\Discount::find(@$Address->discount_id);
            }
            $UpdateOrder= \App\Order::where('address_id',$id)->whereIn('status', ['opened','viewed','processing','ondelivery'])->update(['deliveryfees' => $Area->dlivery_fees,'discount' => @$Discount->dicount]);
            return Response()->json('success');

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
        if (Auth::user()->is('admin')) {
            $Address = \App\Address::find($id)->orders()->get();
            if (count($Address) > 0 ) { 
                return Response()->json(count($Address));
            }else{
                \App\Address::find($id)->delete();
                return Response()->json('success');
                
            }
        }
    }

    public function linkcontact(Request $request)
    {
        // search 
            $Account    =  \App\Account::find($request->account);
            $Phone      =  \App\Phone::where('phone',$request->phone)->first();
        //check route
            if(!empty($Phone)){
                $Contact    =  $Phone->contact;
                $Account->contacts()->detach($Contact->id);
                $Account->contacts()->attach($Contact->id);
                return Response()->json(array($Contact,$Phone,'success'));
            }else{
                return Response()->json('fail');                
            } 
    }
    public function find($id)
    {
        //

        $data = \App\Area::getSearch($id)->get();
        return Response::json($data);
        
        
    }
}
