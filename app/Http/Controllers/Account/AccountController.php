<?php

namespace App\Http\Controllers\Account;
//use
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Http\Requests;
    use Response;
    use Input;
    use Auth;
    use DB;
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('Account.create');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Basic
            $form       = new \App\Account;
            $create     = 'create';
            $route      = 'Account.store';
        return view('Account.Account.create',compact('form','create','route','caller','phone_number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->validate($request, ['area'=>'required','account_name'=>'required','account_type'=>'required','phone_number'=>'unique:accounts,phone_number','branch_id'=>'required','area_id'=>'required','building_number'=>'required']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $request->request->add(['contact_name'   => $request->account_name]);
        $request->request->add(['contact_comment' => $request->account_comment]);
        $Account = \App\Account::create($request->all());
        $Contact = \App\Contact::create($request->all());
        $request->request->add(['account_id' => $Account->id]);
        $request->request->add(['address_type' => $request->account_type]);
        $area = explode('/', $request->area);
        $request->request->add(['governorate' => $area[0]]);
        $request->request->add(['district' => $area[1]]);
        $request->request->add(['area' => $area[2]]);

        $Address = \App\Address::create($request->except('email'));
        $addphone= \App\Phone::create(['phone'=> $request->phone_number,'contact_id'=> $Contact->id]);
        $Account->contacts()->attach($Contact->id);
        return redirect()->route('Account.show',array($Account->id,'contact' => $Contact->id,'branch' => $Address->branch_id,'address'=>$Address->id));
        
        /*
        //Validation
            $this->validate($request, ['account_name'=>'required','account_type'=>'required','phone_number'=>'unique:accounts,phone_number','governorate'=>'required','district'   =>'required','area'=>'required','address'=>'required','branch_id'=>'required']);
        //append Request
            $request->request->add(['created_by' => Auth::user()->id]);
            $request->request->add(['contact_name'   => $request->account_name]);
            $request->request->add(['contact_comment' => $request->account_comment]);
        //create Account and Contact
            if($request->caller == 'ani' || $request->caller == '0') {
                //ani or 0
                    $this->validate($request, ['phone_number'=>'required']);
                    $Account = \App\Account::create($request->all());
                    $ani = \App\Phone::where('phone',$request->phone_number)->first();
                    //if (!empty($ani)) {
                    //    $Contact = \App\Contact::find($ani->contact_id);
                    //}else{
                        $Contact = \App\Contact::create($request->all());
                    //}
            }elseif($request->caller == 'search') {
                //Search
                    $this->validate($request, ['phone_number'=>'required']);
                    $Account = \App\Account::create($request->all());
                    if(session()->has('caller')){
                        $anicaller = \App\Phone::where('phone',session()->get('caller'))->first();
                        if (!empty($anicaller)) {
                            $Contact = \App\Contact::find($anicaller->contact_id);
                        }else{
                            $Contact = \App\Contact::create($request->all());
                            $addphone  = \App\Phone::create(['phone'=> session()->get('caller'),'contact_id'=> $Contact->id]);
                        }
                    }else{
                        $Contact = \App\Contact::create($request->all());
                    }
            }elseif($request->caller == 'addaccount'){
                //addaccount
                    $Account = \App\Account::create($request->all());
                    if(session()->has('caller')){
                        $addaccount = \App\Phone::where('phone',session()->get('caller'))->first();
                        if (!empty($addaccount)) {
                            $Contact = \App\Contact::find($addaccount->contact_id);
                        }
                    }
            }
        //attached with Contact
            $Account->contacts()->attach($Contact->id);
        //Create Phone for Account
            if ($request->caller != 'addaccount') {
                $phone  = \App\Phone::create(['phone'=> $request->phone_number,'contact_id'=> $Contact->id]);
            }


        return redirect()->route('Account.show',array($Account->id,'contact' => $Contact->id));
        */
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
        $created    = Input::get('created');
        $account    = \App\Account::find($id);
        $branch     = \App\Branch::find(Input::get('branch'));
        $contact    = \App\Contact::find(Input::get('contact'));
        $address    = \App\Address::find(Input::get('address'));
        return view('Account.Account.show',compact('account','created','branch','contact','address'));
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
        $form       = new \App\Account;
        $create     = 'edit';
        $route      = 'Account.update';
        $EditData   = \App\Account::find($id);
        return view('Account.Account.edit',compact('form','create','route','EditData'));

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
    
        $this->validate($request, ['account_name'=>'required','account_type'=>'required','phone_number'=>'required|unique:accounts,phone_number,'.$id]);
        $Account = \App\Account::find($id);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Account = $Account->update($request->all()/*except(['phone_number'])/* $request->all()*/);
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
        return redirect()->route('Account.create');
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function linkaccount(Request $request)
    {
        //
        $Account =  \App\Account::find($request->account);
        if(!empty($Account)){

            if($request->link == 'link'){
                $Account->contacts()->attach($request->contact);
                return Response()->json('linked');
            }else{
                $Account->contacts()->detach($request->contact);
                return Response()->json('unlinked');
            }
        }else{
            return Response()->json('fail');
        }
    }
 public function zone(Request $request)
    {
        //
        $query = DB::select(DB::raw("
                            select areas.id,concat(governorates.name,'/',districts.name,'/',areas.name) as Zone,areas.dlivery_fees from areas 
                            join districts on districts.id = areas.district_id
                            join governorates on governorates.id = districts.governorate_id
                            where areas.name like '%القاهره%' or districts.name like '%القاهره%' or governorates.name like '%القاهره%'
                        group by areas.id
                        order by areas.name asc
                    "));
        return $query;
        
    }

}
