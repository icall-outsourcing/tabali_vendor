<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use Validator;
use Carbon\Carbon;
use GoogleCloudPrint;        
use Bnb\GoogleCloudPrint\PrintApi;
class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function find(Request $request){
        $data  = \App\Product::getSearch(explode(' ', $request->q))->Where('branch_id',$request->branch)->Where('available','ON')->whereNull('extragroup')->get();
        return Response::json($data);        
        
    }

    public function transfer(Request $request, $id){
      
         $request->transferTo;
         $order = \App\Order::find($id)->update(['branch_id' => $request->transferTo,'printed'=>'N']);
         $Item  = \App\OrderItem::where('order_id',$id)->update(['flagtoprint' => 'N','updateorder'=>'pending','printeraction'=>'new']);
         return response()->json(['message'=>'Success']);
    }

    public function statusget($id){
        if (Auth::user()->is('admin|branch|tabaliadmin|teamleader')) {
            /*
            $BranchsList = Auth::User()->BranchsList;
            $Complaint  = \App\Complaint::whereIn('branch_id', array_keys($BranchsList))->where('status','!=','closed')->count();
            */
            $order = \App\Order::find($id);
            return view('Order.Order.action',compact('order','id'));
        }
    }

    public function statuspost(Request $request, $id){
        if (Auth::user()->is('admin|branch|tabaliadmin|teamleader')) {
            if ($request->type == 'canceled') {
                $Order  = \App\Order::find($id);
                $Order->confirm_cancellation    = 'Y';		
		$Order->save();
                return Response()->json($Order);
            }else{
                $find = \App\Order::find($id);    
                $request->request->add(['updated_by' => Auth::user()->id]);
                if($request->status == 'processing'){
                    $request->request->add(['processing_at' => date("Y-m-d H:i:s")]);
                    }elseif($request->status == 'ondelivery'){
                        $this->validate($request, ['driver_id' => 'required']);
                        $request->request->add(['ondelivery_at' => date("Y-m-d H:i:s")]);
                        $driver = \App\Driver::find($request->driver_id);
                        $driver->collected_invoices    = $find->total + $driver->collected_invoices;
                        $driver->save();
                    }elseif($request->status == 'closed'){
                        $this->validate($request, ['delivered_at' => 'required']);
			$request->request->add(['closed_at' => date("Y-m-d H:i:s")]);			
                        $driver = \App\Driver::find($find->driver_id);
                        $driver->collected_invoices    = $driver->collected_invoices - $find->total;
                        $driver->save();
                    }elseif($request->status == 'canceled'){
			    $request->request->add(['canceled_at' => date("Y-m-d H:i:s")]);			  
                        if ($find->driver_id) {
                            $driver = \App\Driver::find($find->driver_id);
                            $driver->collected_invoices    = $driver->collected_invoices - $find->total;
                            $driver->save();
                        }
                }
                $order = $find->update($request->all());
                $data = \App\Order::find($id);
                return Response()->json($data);
            }
        }
    }

    public function extraItems(){
        $id = Input::get('sectionid');
        $branch_id  = Input::get('branch_id');
        $Product    = \App\Product::where("sectionid",$id)->first();        
        if($Product->extratype == 'composite'){
            $ExtraItems = \App\Product::where("extragroup",$id)->where("branch_id",$branch_id)->where("available","ON")->where("extra","1")->orderBy('groupsectionby')->get();
        }else{
            $ExtraItems = \App\Product::where(function ($query) use ($id) {$query->Where('extratype', 'all')->orWhere('extragroup',$id);})->where("branch_id",$branch_id)->where("available","ON")->where("extra","1")->orderBy('price')->get();
        }
        return view('Order.Order.extraItems',compact('ExtraItems','Product'));
    }

    public function driverget($id){
        if (Auth::user()->is('admin|branch')) {
            $order = \App\Order::find($id);
            return view('Order.Order.driver',compact('order','id'));
        }
    }

    public function driverpost(Request $request, $id){
        if (Auth::user()->is('admin|branch')) {
            $find = \App\Order::find($id);   
            $request->request->add(['updated_by' => Auth::user()->id]);
            if($find->status != 'closed' || $find->status != 'canceled'){
                $this->validate($request, ['driver_id' => 'required']);
                $find->driver_id    = $request->driver_id;
                $find->save();
            }
            $data = \App\Order::select('orders.id','drivers.name')->join('drivers','orders.driver_id','=','drivers.id')->find($id);
            return Response()->json($data);
        }
    }

    public function autoPrint(){
        $carbon         = new Carbon();  
        $on_hold_time   = $carbon->addMinutes(45);         
        if(Input::get('order_id')){
            $driver = 'driver';
            // dd('d');
            if (Auth::user()->is('branch') && Auth::User()->print == 'Y'){
                $BranchsList = Auth::User()->BranchsList;
                $needPrint  = \App\Order::where('id',Input::get('order_id'))->whereIn('branch_id', array_keys($BranchsList))->get();
                if ($needPrint->count() < 1){return 'empty';}
                //Handel printer from here 
                    $printerId  = Auth::User()->print_for_driver;
                    // $printerId  = 'acbfc03c-afce-3d08-6d7c-9248ece27c72';
                    /*
                    if($printerId){
                        $url        = url('autoprint/'.Input::get('order_id').'/driver/'.$printerId.'.pdf');                    
                        $print      = GoogleCloudPrint::asPdf()->url($url)->printer($printerId)->send();
                    }
                    */

                // REDA
                return 'Printed';                 
            }
            return 'empty';
        }else{
            $driver = 'notdriver';
            if (Auth::user()->is('branch') && Auth::User()->print == 'Y'){
                $BranchsList = Auth::User()->BranchsList;                
                $needPrint  = \App\Order::where('printed','N')->whereRaw('(on_hold_time < "'.$on_hold_time.'" or on_hold_time is null)')->whereIn('branch_id', array_keys($BranchsList))->get(['id'])->toArray();
                if (count($needPrint) < 1){return 'empty';}                                
                foreach($needPrint as $array){$uids[$array['id']] =  $array['id'];};               
                $ids = implode(",",$uids);
                //hadnel printer from here 
                /*
                    foreach(Auth::User()->printers as $sendprinter){                        
                        $printerId  = $sendprinter->printer_key;
                        $url        = url('autoprint/'.$ids.'/notdriver/'.$printerId.'.pdf');                    
                        $print      = GoogleCloudPrint::asPdf()->url($url)->printer($printerId)->send();
                    }
                */
                //OK 
                // $Order      = \App\Order::whereIn('id', $uids)->update(['printed' => 'Y']);
                // $OrderItem  = \App\OrderItem::whereIn('order_id', $uids)->update(['flagtoprint' => 'Y','updateorder'=>'printed']);                        
                return 'Printed';                
                
                    
            }
            return 'empty';
       }
    }
    
    public function index(){
        
        // $print      = GoogleCloudPrint::getAccessToken();
        // $print      = PrintApi::search(GoogleCloudPrint::getAccessToken());
        // return  dd($print);
        // return dd(json_decode($print)->printers);
        $carbon = new Carbon();  
        $on_hold_time = $carbon->addMinutes(45);    
        if (Auth::user()->is('admin|branch||teamleader|tabaliadmin')) {
                //return array_values(Auth::user()->PermissionsList);            
            $model      = new \App\Order;
            $datatable  = \App\Order::where('confirm_cancellation','N')->whereNotIn('status', ['closed'])->whereIn('branch_id',array_values(Auth::user()->PermissionsList))->orderBy('id','desc')->paginate(20);
            return view('Order.Order.index',compact('model','datatable'));
        }
        return redirect()->route('home');
    }
    
    public function canceled(){
        $carbon = new Carbon();  
        $on_hold_time = $carbon->addMinutes(45);    
        if (Auth::user()->is('admin|branch|tabaliadmin|teamleader')) {
            if ( substr( date("H"), 0, 1 ) == 0 ) {$date = substr( date("H"), 1 );}else{$date = date("H");}
            if( $date < 5){
               $StartDate  = date("Y-m-d", time() - 86400).' 07:00:00';
               $EndDate    = date("Y-m-d").' 03:00:00';
            }else{
               $StartDate  = date("Y-m-d").' 07:00:00 ';
               $EndDate    = date("Y-m-d", time() + 86400).' 03:00:00';
            }
            $model      = new \App\Order;
            $datatable  = \App\Order::where('status','canceled')->whereIn('branch_id',array_values(Auth::user()->PermissionsList))->whereBetween('created_at', [$StartDate, $EndDate])->get();
            return view('Order.Order.canceled',compact('model','datatable'));
        }
        return redirect()->route('home');
    }

    public function closed(){
        $carbon = new Carbon();  
        $on_hold_time = $carbon->addMinutes(45);    
        if (Auth::user()->is('admin|branch|tabaliadmin|teamleader')) {
            if ( substr( date("H"), 0, 1 ) == 0 ) {$date = substr( date("H"), 1 );}else{$date = date("H");}
            if( $date < 5){
               $StartDate  = date("Y-m-d", time() - 86400).' 07:00:00';
               $EndDate    = date("Y-m-d").' 03:00:00';
            }else{
               $StartDate  = date("Y-m-d").' 07:00:00 ';
               $EndDate    = date("Y-m-d", time() + 86400).' 03:00:00';
            }
            $model      = new \App\Order;
            $datatable  = \App\Order::where('status','closed')->whereIn('branch_id',array_values(Auth::user()->PermissionsList))->whereBetween('created_at', [$StartDate, $EndDate])->get();
            return view('Order.Order.closed',compact('model','datatable'));
        }
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
        $account    = \App\Account::find(Input::get('account'));
        $contact    = \App\Contact::find(Input::get('contact'));
        $branch     = \App\Branch::find(Input::get('branch'));
        $address    = \App\Address::find(Input::get('address'));
        $area       = \App\Area::find($address->area_id);
        return view('Order.Order.create',compact('account','branch','contact','address','area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), ['account_id' => 'required','address_id' => 'required','branch_id' => 'required','contact_id' => 'required','follow_up_phone' => 'required','total' => 'required','item_id' => 'required']);
        if ($validator->fails()) {return response()->json(['message'=>'Error','errors'=>$validator->errors()]);}
        if($request->payment_type == 'OnHold') {$request->request->add(['on_hold_time' => $request->OnHold]);}
        $branchTime = \App\Branch::find($request->branch_id);
	if( date('H:i:s') > $branchTime->close_on && $branchTime->backup_branch > 0){	
            $orderid = \App\Branch::find($branchTime->backup_branch);
            $request->request->add(['master_branch' => $request->branch_id]);
            $request->request->add(['branch_id' => $branchTime->backup_branch]);            
        }else{
            $orderid = \App\Branch::find($request->branch_id);            
        }        
        $request->request->add(['created_by'=> Auth::user()->id]);
        $carbon = new Carbon();  
        $carbon = $carbon->subHours(4);
        if ($carbon->toDateString() == date("Y-m-d", strtotime($orderid->close_time)) ) {
            $request->request->add(['orderid'   => $orderid->auto_increment+1]);
        }else{
            $Branch = \App\Branch::find($request->branch_id)->update(['auto_increment' => $orderid->start_number,'close_time'=>$carbon]);
            $request->request->add(['orderid'   => $orderid->start_number+1]);
        }
        $items = count($request->item_id);
        $total = 0;
        for ($i=0; $i < $items ; $i++) {$total += ($request->uprice[$i] * $request->quantity[$i]);}
        $request->request->add(['total'  => number_format($total, 2, '.' ,'')]);
        if($request->voucher_id){
            $today = Carbon::now();
            $today =  $today->toDateTimeString();        
            $Voucher = \App\Voucher::where('id',$request->voucher_id)->where('active','Y')->where('status','open')->whereDate('expire_at','>',$today)->first();             
            if($Voucher){
                $gift   = $Voucher->gift;
                if($Voucher->voucher_use == 'once'){
                    $Voucher->update(['status' => 'used']);
                }
                switch ($gift->type) {
                    case 'amount':
                        $request->request->add(['voucher_amount' => $gift->amount]);
                    break;            
                    case 'item':
                        $request->request->add(['voucher_item' => $gift->item]);                                                
                    break;
                    case 'discount':
                        $discount=$gift->discount + $request->discount;
                        $request->request->add(['discount' => $discount ]);                        
                    break;                    
                }

            }
        }
        if($request->payment_type == 'HotSpot'){
            $request->merge(['deliveryfees' => 0]);
            $request->merge(['taxfees' => number_format($total * 0.14, 2, '.' ,'') ]);
        }
        if($request->source       == 'Marsool'){
            $request->merge(['deliveryfees' => 0]);
            $request->merge(['taxfees' => number_format($total * 0.14, 2, '.' ,'') ]);
        }
        $order = \App\Order::create($request->all());
        for ($i=0; $i < $items ; $i++) { 
            if ($request->extraitem_id[$i] != 'Yes') {
                $item = new \App\OrderItem;
                $item->order_id     = $order->id;
                $item->product_id   = $request->item_id[$i];
                $item->quantity     = $request->quantity[$i];
                $item->uprice       = $request->uprice[$i];
                $item->tprice       = ($request->uprice[$i] * $request->quantity[$i]);
                $item->item_comment = $request->item_comment[$i];
                $item->flagtoprint  = 'N';
                $item->created_by   = $request->created_by;
                $item->save();
            }else{
                $extra              = new \App\OrderItem;
                $extra->order_id    = $order->id;
                $extra->product_id  = $request->item_id[$i];
                $extra->quantity    = $request->quantity[$i];
                $extra->uprice      = $request->uprice[$i];
                $extra->tprice      = ($request->uprice[$i] * $request->quantity[$i]);
                $extra->extra_items = $item->id;
                $item->flagtoprint  = 'N';
                $item->created_by   = $request->created_by;
                $extra->save();
            }            
            //DB::rollBack();
            //$request->session()->flash('oldRequest', $request->all());
            //$rquest->session()->flash('error', 'الكمية في المخزن لا تسمح');
        }
        if ($request->voucher_item) {
            foreach(json_decode($order->voucher_item) as $giftQ){                
                $GProduct = \App\Product::where('branch_id',$request->branch_id)->where('item_code',$giftQ->item_code)->first();
                if($GProduct){
                    $gitem = new \App\OrderItem;
                    $gitem->order_id     = $order->id;            
                    $gitem->product_id   = $GProduct->id;
                    $gitem->quantity     = $giftQ->quantity;
                    $gitem->uprice       = 0;
                    $gitem->tprice       = 0;            
                    $gitem->flagtoprint  = 'N';
                    $gitem->created_by   = $request->created_by;
                    $gitem->voucher      = 'Y';
                    $gitem->save();
                }
            }

        }
        $Branch = \App\Branch::find($order->branch_id)->update(['auto_increment' => $order->orderid,'close_time'=>$carbon]);
        return response()->json(['message'=>'Success','success'=>'<center><p>your Order has created with ID</p> <h1>#'.$order->id.'</h1></center>']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
        $order = \App\Order::find($id);
        if (Auth::user()->is('branch')) {
            if($order->viewed_at == null){
                $order->viewed_at = date("Y-m-d H:i:s");
                $order->save();
            }
            if ($order->status == 'opened') {
                $order->status = 'viewed';
                $order->save();
            }
        }
        return view('Order.Order.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
        $data = \App\Order::find($id);
        $account    = \App\Account::find($data->account_id);
        $contact    = \App\Contact::find($data->contact_id);
        $branch     = \App\Branch::find($data->branch_id);
        $address    = \App\Address::find($data->address_id);
        $area       = \App\Area::find($address->area_id);
        $OrderItem  = \App\OrderItem::where('order_id',$id)->where('updateorder','processing')->update(['flagtoprint' => '','updateorder'=> 'printed']);
        return view('Order.Order.edit',compact('data','account','contact','branch','address','area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
         $orderStatus = \App\Order::find($id);

	if ($request->under_change == "N"&& $request->cancelupdate="Y") {
            $under_change   = \App\Order::find($id)->update(['under_change' => 'N']);
            return response()->json(['message'=>'Success','success'=>'<center><p>there is no updated on Order</p> <h1>#'.$id.'</h1></center>']);
        }


        if($orderStatus->status == 'closed' ||  $orderStatus->status == 'ondelivery' || $orderStatus->status == 'processing'){
            $orderStatus->payment_method       = $request->payment_method;
            $orderStatus->source               = $request->source;                
            $orderStatus->save();
            return response()->json(['message'=>'Success','success'=>'<center><p>your payment Method has been updated ID</p> <h1>#'.$id.'</h1></center>']);
        }

        $validator = Validator::make($request->all(), ['follow_up_phone' => 'required','item_id' => 'required']);
        if ($validator->fails()) {return response()->json(['message'=>'Error','errors'=>$validator->errors()]);}
        
        


        if($request->payment_type == 'OnHold') {$request->request->add(['on_hold_time' => $request->OnHold]);}

        
        $items = count($request->item_id);
        $total       = 0;
        for ($i=0; $i < $items ; $i++) { $total += $request->tprice[$i];}
        $request->request->add(['total'  => number_format($total, 2, '.' ,'')]);
        $order  = \App\Order::find($id);
        $request->request->add(['status' => 'opened']);
        $request->request->add(['printed' => 'N']);
        $request->request->add(['print_receipt' => 'N']);
        $request->request->add(['under_change' => 'N']);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $remove = \App\OrderItem::where('order_id',$id)->where('version',$order->version)->where('flagtoprint','P')->where('voucher','N')->update(['flagtoprint'=>'N','updateorder'=>'pending','printeraction'=>'remove']);
        $version = ++$order->version;
        $gift   = \App\OrderItem::where('order_id',$id)->where('voucher','Y')->update(['version'=>$version]);
        $request->request->add(['version' => $version]); 
        $request->merge(['discount' => $order->discount ]);  
        
        
        if($request->payment_type == 'HotSpot'){
            $request->merge(['deliveryfees' => 0]);
            $request->merge(['taxfees' => number_format($total * 0.14, 2, '.' ,'') ]);
        }
        if($request->source == 'Marsool'){
            $request->merge(['deliveryfees' => 0]);
            $request->merge(['taxfees' => number_format($total * 0.14, 2, '.' ,'') ]);
        }

        
        $order  = \App\Order::find($id)->update($request->all());            

        for ($i=0; $i < $items ; $i++) {
            if ($request->orderItemId[$i] == 'orderItemId'){
                $flagtoprint    = 'N';
                $updateorder    = 'pending';
                $printeraction  = 'add';
                $oldid          = null;
            }else{
                $orderItem = \App\OrderItem::find($request->orderItemId[$i]);
                if($orderItem && $orderItem->product_id   == $request->item_id[$i] && $orderItem->quantity     == $request->quantity[$i] &&  $orderItem->tprice       == $request->tprice[$i] && $orderItem->item_comment == $request->item_comment[$i] && $orderItem->flagtoprint  == 'Y'){
                    $flagtoprint    = $orderItem->flagtoprint;
                    $updateorder    = $orderItem->updateorder;
                    $printeraction  = 'edit';
                    $oldid          = $orderItem->id;
                }elseif($orderItem && $orderItem->product_id   == $request->item_id[$i] && $orderItem->quantity  != $request->quantity[$i] &&  $orderItem->tprice != $request->tprice[$i] && $orderItem->item_comment == $request->item_comment[$i] && $orderItem->flagtoprint  == 'Y'){
                    $flagtoprint = 'N';
                    $updateorder = 'pending';
                    $printeraction = 'edit';
                    $oldid = $orderItem->id;
                }else{
                    $flagtoprint = 'N';
                    $updateorder = 'pending';
                    $printeraction = 'edit';
                    $oldid = $orderItem->id;
                }
            }
            
            if ($request->extraitem_id[$i] != 'Yes') {
                $item = new \App\OrderItem;
                $item->order_id     = $id;
                $item->version      = $version;
                $item->product_id   = $request->item_id[$i];
                $item->quantity     = $request->quantity[$i];
                $item->uprice       = $request->uprice[$i];
                $item->tprice       = $request->tprice[$i];
                $item->flagtoprint  = $flagtoprint;
                $item->updateorder  = $updateorder;
                $item->printeraction= $printeraction;
                $item->oldid        = $oldid;
                $item->item_comment = $request->item_comment[$i];
                $item->created_by   = Auth::user()->id;
                $item->save();
            }else{
                $extra = new \App\OrderItem;
                $extra->order_id     = $id;
                $extra->version      = $version;
                $extra->product_id   = $request->item_id[$i];
                $extra->quantity     = $request->quantity[$i];
                $extra->uprice       = $request->uprice[$i];
                $extra->tprice       = $request->tprice[$i];
                $extra->extra_items  = $item->id;
                $extra->flagtoprint  = $flagtoprint;
                $extra->updateorder  = $updateorder;
                $extra->printeraction= $printeraction;
                $extra->oldid        = $oldid;
                $extra->created_by   = Auth::user()->id;
                $extra->save();
            }
        }
	 return response()->json(['message'=>'Success','success'=>'<center><p>your Order has been updated ID</p> <h1>#'.$id.'</h1></center>']);
    }

    public function printerUpdate(Request $request, $id){
        if($request->ajax()){
            $OrderItem  = \App\OrderItem::where('id',$request->order_item)->where('version',$request->version)->first();
            $extraItem  = \App\OrderItem::where('order_id',$OrderItem->order_id)->where('extra_items',$OrderItem->id)->where('version',$request->version)->get();
            if($request->flagtoprint == 'P'){
                $OrderItem->update(['flagtoprint' => 'P']);
                if (count($extraItem) > 0) {
                    foreach ($extraItem as $removeextraItem) {
                        $removeextraItem->update(['flagtoprint' => 'P']);
                    }
                }
                return response()->json(['message'=>'Success']);
            }
        }
        return 'Error';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        //
        if (Auth::user()->is('admin|teamleader')) {
            $order = \App\Order::whereId($id)->whereIn('status', ['opened','viewed','processing'])->update(['status' => 'canceled','cancel_note'=> $request->comment,'canceled_at' =>  date('Y-m-d H:t:s'),'updated_by' => Auth::user()->id]);
            if ($order > 0) {
                return Response()->json('success');
            } else {
                return Response()->json('fail');
            }
        } elseif (Auth::user()->is('tabaliadmin')) {
            $order = \App\Order::whereId($id)->whereDate('created_at', '=', Carbon::today())->where('status', 'closed')->update(['status' => 'canceled','cancel_note'=> $request->comment,'canceled_at' =>  date('Y-m-d H:t:s'),'updated_by' => Auth::user()->id]);
            if ($order > 0) {
                return Response()->json('success');
            } else {
                return Response()->json('fail');
            }
        } else {
                return Response()->json('fail');
        }
    }
}
