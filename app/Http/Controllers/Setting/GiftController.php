<?php
namespace App\Http\Controllers\Setting;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;

class GiftController extends Controller
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
        $model    = new \App\Gift;
        $datatable = \App\Gift::orderBy('id','desc')->paginate(10);
        return view('Setting.Gift.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $form   = new \App\Gift;
        $create = 'create';
        $route  = 'Gift.store';
        return view('Setting.Gift.create',compact('form','create','route'));
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
        $this->validate($request, ['name' => 'required|unique:gifts']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $BankBranch = \App\Gift::create($request->all());        
        return redirect()->route('Gift.index');
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
        $form       = new \App\Gift;
        $create     = 'edit';
        $route      = 'Gift.update';
        $EditData   = \App\Gift::find($id);
        return view('Setting.Gift.edit',compact('form','create','route','EditData'));
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
        $this->validate($request, ['name' => 'required|unique:gifts,name,'.$id]);
        $Gift = \App\Gift::find($id)->update($request->all());         
        return redirect()->route('Gift.index');
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
