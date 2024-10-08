<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use App\Product;

class ProductController extends Controller
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
    public function index()
    {
        //
        $BranchsList =  Auth::User()->BranchsList;
        $model    = new \App\Product;
	$datatable = \App\Product::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->orderBy('id','desc')->paginate(10);	
        return view('Setting.Product.index',compact('model','datatable'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$form   = new \App\Product;
        //$create = 'create';
	//$route  = 'Product.store';
	$section_name	= Product::where('id','!=',0)->groupBy('sectionid')->lists('sectiongroup','sectionid')->toArray();
	$extragroup  	= Product::where('sectionid','!=','9')->groupBy('sectionid')->lists('sectiongroup','sectionid')->toArray();
	$item_group_name= Product::where('id','!=',0)->groupBy('item_group_name')->lists('item_group_name','sectionid')->toArray();
	$available      = array('ON'=>'مفعل','OFF'=>'غير مفعل');
	$extraornot     = array('1'=>'اضافه','0'=>'ليست أضافه');
        return view('Setting.Product.create',compact('section_name','extragroup','item_group_name','available','extraornot'));
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
	$this->validate($request, ['section_name'=> 'required','sectiongroup'=> 'required','sectionid'=> 'required','ar_name' => 'required','en_name'=> 'required','branch_id'=>'required','price'=>'required','available' => 'required']);
        $item_code =DB::select( DB::raw("SELECT * FROM products GROUP BY id DESC LIMIT 1") );
        $item_code=$item_code[0]->item_code;
        $item_code=substr($item_code, 1);
        $item_code++;
        $item_code_final= "I$item_code";
        $request->request->add(['item_code' => $item_code_final]);
        $request->request->add(['created_by' => Auth::user()->id]);
        foreach ($request->branch_id as $branch){
            $request->request->add(['branch_id' => $branch]);
            $Product = \App\Product::create($request->all());
        }
        return redirect()->back()->with('message', 'Item has been added successfully');
	    
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
        return $id;
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
	$addHours = [1,2,4];	  
	if(in_array($request->available,$addHours)){
		$available	= 'OFF';
		$open_at    	= Carbon::now()->addHours($request->available);
	}elseif($request->available == 'next_day'){
		$available      = 'OFF';
		$open_at 	= date('Y-m-d 4:00:00', strtotime( date('Y-m-d') . ' +1 day'));
	}elseif($request->available == 'OFF'){
		$available      = 'OFF';
		$open_at 	= null ;
	}else{
		$available      = 'ON';
                $open_at        = null ;

	}
	
        if(Auth::user()->is('admin|tabaliadmin')){
            $Product = \App\Product::find($id)->update(['available' => $available,'open_at'=>$open_at,'price' => $request->price]);
        }else{
            $Product = \App\Product::find($id)->update(['available' => $available,'open_at'=>$open_at]);
        }

        return Response()->json('success');
     }


    public function editall($id)
    {
        //
	$Product	= Product::find($id);
	$section_name  	= Product::where('id','!=',0)->groupBy('sectionid')->lists('sectiongroup','sectionid')->toArray();
	$item_group_name= Product::where('id','!=',0)->groupBy('item_group_name')->lists('item_group_name','sectionid')->toArray();
	$available      = array('ON'=>'مفعل','OFF'=>'غير مفعل');
	$extraornot  	= array('1'=>'اضافه','0'=>'ليست أضافه');
        return view('Setting.Product.edit',compact('Product','section_name','item_group_name','available','extraornot'));

    }


    public function updateall(Request $request, $id)
    {
        //

        $Product=\App\Product::find($id);
        $Product->ar_name = $request->input('ar_name');
        $Product->en_name = $request->input('en_name');
        $Product->price = $request->input('price');
        $Product->description = $request->input('description');
        $Product->available = $request->input('available');
        $Product->item_group_name = $request->input('item_group_name');
        $Product->updated_by = Auth::user()->name;
        $Product->update();

        return redirect()->back()->with('message', 'Item has been updated successfully');


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
