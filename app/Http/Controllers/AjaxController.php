<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//adds
use DB;
use Auth;
use Excel;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    //auth
        public function __construct()
        {
            $this->middleware('auth');
        }
    //navbar sarch and API search
        public function Search(Request $request)
        {

            if(empty($request->search) && empty($request->ani)){
             return redirect()->route('home');
             }
            //get the parmeters in Session
              if ( substr($request->ani   , 0, 1 ) == 0 ) {$caller         = substr( $request->ani   , 1 );}else{$caller         = $request->ani   ;}
              if ( substr($request->search, 0, 1 ) == 0 ) {$search         = substr( $request->search, 1 );}else{$search         = $request->search;}
              if ( substr($request->search, 0, 1 ) == 0 ) {$searchphone    = substr( $request->search, 1 );}else{$searchphone    = $request->search;}
             //Session
                if ($request->ani == true) {
                    session()->put('caller',$caller);
                }
                session()->put('search',$search);
                
            //Check if the Caller and phone in Database
                if(!empty($caller) || $caller != 0 || !empty($search) || $search != 0){
                    $findcaller= \App\Phone::where('phone',session()->get('caller'))->first();
                    $search    = \App\Phone::where('phone',session()->get('search'))->first();
                }
           
            //Route according to Search or Aheeva
                if (empty($caller)) {
                    if ($search==true) {

                        return view('Account.Search.search',compact('findcaller','search','searchphone'));
                    }else{
                        $form       = new \App\Account;
                        $titel      = 'Save';
                        $create     = 'create';
                        $route      = 'Account.store';
                        return view('Account.Account.create',compact('form','search','titel','create','route'));
                    }
                }else{
                    if ($findcaller==true) {
                        return view('Account.Search.caller',compact('findcaller','caller','search'));
                    }else{
                        $form       = new \App\Account;
                        $titel      = 'Save';
                        $create     = 'create';
                        $route      = 'Account.store';
                        return view('Account.Account.create',compact('form','caller','titel','create','route'));
                    }
                }
        }









    public function Ajaxcontact(Request $request){
        $phone = \App\Phone::where('phone',$request->phone)->with('phonetable')->first();
        return Response()->json($phone);
    }

    //Search index
    public function Ajaxtable(Request $request)
    {
        if($request->ajax())
        {
            //get element
                $rows       = $request->rows;
                $model      = $request->model;
                $search     = $request->search;
                $orderby    = $request->orderby;
                $ordertype  = $request->ordertype;
                $page       = $request->page;
                $conditions = $request->conditions;
                $columns    = $request->columns;
                $groupby    = $request->groupby;
                $key        = $request->key;
                $path       = $request->path;
                $join       = '';
                $joinsearch = '';
                // $carbon = new Carbon();  
                // $on_hold_time = $carbon->addMinutes(45);   


                //back page and model name
                    $backto     = $path.'.'.$request->model.'.pageid';
                //check the Role & permission path
                    $App        = '\App\\'.$request->model;    
                    $myModal    = new $App;
                    if (method_exists($myModal,'getJoin')) {
                        $join       = $myModal->getJoin();
                        $joinsearch = $myModal->getJoinsearch();
                    }
                   
                    
            //get DataTables

                $DataTable  = $App::orWhere(function ($query) use ($search,$App) 
                    {
                        //Get Table Header
                            $table    = new $App;
                            $table = $table->getFillable();
                            for ($x = 0; $x < count($table) ; $x++) {
                                $query->orWhereRaw('convert('.$table[$x].' using utf8) LIKE ?', ['%' . $search . '%']);
                            }
                    })
                    //conditions Done
                    // ->Where(function ($query) use ($model,$on_hold_time) 
                    ->Where(function ($query) use ($model) 
                    {
                        if($model == 'Complaint' || $model == 'Product'  || $model == 'Driver') {
                            $query->whereIn('branch_id',array_values(Auth::user()->PermissionsList));
                        }elseif ($model == 'Order') {
                            $query->whereNotIn('status',['closed'])->whereIn('branch_id',array_values(Auth::user()->PermissionsList));
                            // $query->whereIn('branch_id',array_values(Auth::user()->PermissionsList));
                            //->whereRaw('(on_hold_time < DATE_ADD(NOW(), INTERVAL 45 MINUTE) or on_hold_time is null)');
                            // ->whereRaw('(on_hold_time < "'.$on_hold_time.'" or on_hold_time is null)');
                            
                        }
                    })

                    ->Where(function ($query) use ($conditions) 
                    {
                        if(!empty($conditions)) {
                            foreach ($conditions as $key => $value) {
                                if($key == 'scheduled_date'){
                                    $query->whereBetween('scheduled_date', array($value['start'], $value['end']));
                                }else{
                                    $query->whereIn($key,explode( ',', $value ));
                                }
                            }
                        }
                    })
                    //Search in columns By columns
                    ->Where(function ($query) use ($columns,$key,$model,$join) 
                    {
                        if(!empty($columns) and $columns != null) {
                            foreach ($columns as $keys => $values) {
                                if(strpos($keys, '_relation') == true){
                                    $keys    = str_replace('_relation','',$keys);
                                    $query->WhereHas($join, function ($q) use($keys,$values) {
                                        $q->where($keys, '=', $values);
                                    }); 


                                }elseif(strpos($keys, '_List') == false){
                                    $query->where($keys, '=', $values);
                                }
                            }
                        }else{$query->whereNotNull($key);}
                    })
                    //Searh by one tow many realtionship
                    ->orWhere(function ($query) use ($join,$joinsearch,$search) {
                        if(!empty($join) and $join != null) {
                            foreach ($joinsearch as $keys) {
                                $query->orWhereHas($join, function ($q) use($keys,$search) {
                                    $q->where($keys, '=', $search);
                                }); 
                            }    
                        }
                    })
                    ->orderBy($orderby,$ordertype)
                    ->paginate($rows);
            //back to view 
                $data   = view($backto,compact($DataTable,'DataTable',$myModal,'myModal'))->render();
                return Response()->json($data);    
        }
    }
    //Save as Excel 
    public function AjaxExcel(Request $request)
    {
        
        //$data  = CallType::whereIn('QUEUE',explode( ',', $listname ))->whereBetween('datamart_queue_resume_event.EVENT_TIME', array($from, $to))->getAllQuery()->groupInterval($interval)->get();
        $tablename    = $request->model;
        $model        = '\App\\'.$tablename;
        if (method_exists($model,'scopeSaveExcel')) {
                $data= $model::SaveExcel()->get();}else {
                $data = $model::all();
            }
        Excel::create($tablename, function($excel) use($data,$tablename) 
        {
            $excel->sheet($tablename, function($sheet) use($data) 
            {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function Ajaxrelationlist(Request $request)
    {
        $id         =   $request->id;
        $App        =   '\App\\'.$request->model;
        $method     =   $request->method;
        //return $request->method;
        $data       =   $App::find($id)->$method;
        return Response()->json($data);
    }

    public function Ajaxrow(Request $request)
    {
        // return dd($request->all());
        $model      = '\App\\'.$request->model;
        if(isset($request->insert) && @$request->insert == 'extra'){
            if(isset($request->comparray)){
                
                $data =  $model::whereIn('id', $request->comparray)->get();
                $inputs='<a id="removeexcomposite" class="label label-danger" href="#" ><i  title="Remove" class="fa fa-trash-o"></i></a><div>';
                foreach ($data as $input){
                    $inputs .= '<span class="label label-default" style="margin: 0 5px 0 5px;">'.$input->ar_name.' '.$input->price.'<b class="extraitemquantity" style="margin:5px"> x'.$input->request.'</b>
                    <input type="hidden" name="item_id[]"       value="'.$input->id.'"      class="item_id">
                    <input type="hidden" name="quantity[]"      value="'.$request->quantity.'"    class="input-table quantity">
                    <input type="hidden" name="uprice[]"        value="'.$input->price.'" class="uprice" id="uprice">
                    <input type="hidden" name="tprice[]"        value="'.(intval($input->price*pow(10,2)) / 100 ).'" class="tprice" id="tprice">
                    <input type="hidden" name="extraitem_id[]"  value="Yes"               class="extraitem_id">
                    <input type="hidden" name="item_comment[]"  value="extra"             class="input-table" >
                    <input type="hidden" class="orderItemId"  id="orderItemId"  name="orderItemId[]"    value="orderItemId">
                    </span>';
                }
                $inputs .='<div>';
            }else{                
                $input =  $model::find($request->id);
                $inputs = '<span class="label label-default" style="margin: 0 5px 0 5px;">'.$input->ar_name.' '.$input->price.'<b class="extraitemquantity" style="margin:5px"> x'.$input->request.'</b><a id="removeexItems" class="label label-danger" href="#" ><i  title="Remove" class="fa fa-trash-o"></i></a>
                <input type="hidden" name="item_id[]"       value="'.$input->id.'"      class="item_id">
                <input type="hidden" name="quantity[]"      value="'.$request->quantity.'"    class="input-table quantity">
                <input type="hidden" name="uprice[]"        value="'.$input->price.'" class="uprice" id="uprice">
                <input type="hidden" name="tprice[]"        value="'.(intval($input->price*pow(10,2)) / 100 ).'" class="tprice" id="tprice">
                <input type="hidden" name="extraitem_id[]"  value="Yes"               class="extraitem_id">
                <input type="hidden" name="item_comment[]"  value="extra"             class="input-table" >
                <input type="hidden" class="orderItemId"  id="orderItemId"  name="orderItemId[]"    value="orderItemId">
                </span>';
            }
            
            return Response()->json($inputs);
            


        }

                                        
                                        
                                        



    return $model::find($request->id);

        
    }
    public function Ajaxdropdown(Request $request)
    {
        //Virables 
            $id         =   $request->id;
            $App        =   '\App\\'.$request->model;
            $method     =   $request->method;
            $search     =   $request->text;
        //Search in all ()
            if($request->model == 'Section'){
                //$items  =   \App\Product::where('sectionid',$id)->get();
                $items  =   \App\Product::where('sectionid',$id)->where('available','ON')->get();
            }
        //dropdown
          
        return Response()->json(array($items));
    }      
}
