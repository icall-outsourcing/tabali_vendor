<?php
namespace App\Http\Controllers\Setting;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;
use Bican\Roles\Models\Permission;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model    = new \App\Branch;
        $datatable = \App\Branch::orderBy('id','desc')->paginate(10);
        return view('Setting.Branch.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $form   = new \App\Branch;
        $create = 'create';
        $route  = 'Branch.store';        
        $backup_branch  = \App\Branch::all()->lists('name','id')->toArray();
        return view('Setting.Branch.create',compact('form','create','route','backup_branch'));
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
        $this->validate($request, ['name' => 'required|unique:branchs']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $BankBranch = \App\Branch::create($request->all());
        $request->request->add(['id' => $BankBranch->id]);
        $request->request->add(['slug' => $BankBranch->name]);
        $request->request->add(['description' => $BankBranch->branch_note]);
        $permissions = Permission::create($request->all());
        return redirect()->route('Branch.index');
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
        $form           = new \App\Branch;
        $create         = 'edit';
        $route          = 'Branch.update';
        $EditData       = \App\Branch::find($id);        
        $backup_branch  = \App\Branch::where('id','!=',$id)->lists('name','id')->toArray();
        return view('Setting.Branch.edit',compact('form','create','route','EditData','backup_branch'));
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
        $this->validate($request, ['name' => 'required|unique:branchs,name,'.$id]);
        $branch = \App\Branch::find($id);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $Branch = $branch->update($request->all());
        $request->request->add(['slug' => $request->name]);
        $request->request->add(['description' => $request->branch_note]);
        $permission = Permission::find($id);
        $permissions = $permission->update($request->all());
        return redirect()->route('Branch.index');
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
