<?php
namespace App\Http\Controllers\Setting;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;
class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model    = new \App\Driver;
        $datatable = \App\Driver::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->orderBy('id','desc')->paginate(10);
        return view('Setting.Driver.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $form   = new \App\Driver;
        $create = 'create';
        $route  = 'Driver.store';
        return view('Setting.Driver.create',compact('form','create','route'));
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
        $this->validate($request, ['name' => 'required','branch_id' => 'required','phone_number' => 'unique:drivers','id_number' => 'unique:drivers']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $BankBranch = \App\Driver::create($request->all());
        return redirect()->route('Driver.index');
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
        $form       = new \App\Driver;
        $create     = 'edit';
        $route      = 'Driver.update';
        $EditData   = \App\Driver::find($id);
        return view('Setting.Driver.edit',compact('form','create','route','EditData'));
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
        $this->validate($request, ['name' => 'required','branch_id' => 'required','phone_number' => 'unique:drivers,phone_number,'.$id,'id_number' => 'unique:drivers,id_number,'.$id]);
        $Driver = \App\Driver::find($id);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Driver = $Driver->update($request->all());
        return redirect()->route('Driver.index');
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
        \App\Driver::whereId($id)->delete($id);
        return Response()->json($id);
    }
}
