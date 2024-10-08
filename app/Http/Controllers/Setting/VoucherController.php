<?php
namespace App\Http\Controllers\Setting;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Response;
use Input;
use Auth;
use DB;
use Carbon\Carbon;



class VoucherController extends Controller
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
        $model    = new \App\Voucher;
        $datatable = \App\Voucher::orderBy('id','desc')->paginate(10);
        return view('Setting.Voucher.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return redirect()->route('Voucher.index');

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
        return redirect()->route('Voucher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $vouchercode)
    {
        //        
            $request->request->add(['vouchercode' => $vouchercode]);
            $validator  = Validator::make($request->all(), ['vouchercode' => 'required|exists:vouchers']);
            if ($validator->fails() ||  $request->ajax() == false ) { return response()->json(['error'=>$validator->errors()],422); }
            $today      = Carbon::now();
            $today      = $today->toDateTimeString();
            $Voucher    = \App\Voucher::where('vouchercode',$request->vouchercode)->where('active','Y')->where('status','open')->whereDate('expire_at','>',$today)->first();
            if ($Voucher == false ) { return response()->json(['error'=> array('vouchercode'=>array('The selected vouchercode used or expired'))],422); }
            $gift       = $Voucher->gift;            
            return response()->json(['Voucher'=>$Voucher,'gift'=>$gift],200);        
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
        return redirect()->route('Voucher.index');
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
        return redirect()->route('Voucher.index');
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
        // \App\Branch::whereId($id)->delete($id);
        // return Response()->json($id);
    }
}
