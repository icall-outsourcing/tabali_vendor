<?php
namespace App\Http\Controllers\Setting;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Input;
use Auth;
use DB;
use GoogleCloudPrint;        
class PrinterController  extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model    = new \App\Printer;
        $datatable = \App\Printer::orderBy('id','desc')->paginate(10);
        return view('Setting.Printer.index',compact('model','datatable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $form   = new \App\Printer;
        $create = 'create';
        $route  = 'Printer.store';
        return view('Setting.Printer.create',compact('form','create','route'));
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
        $this->validate($request, ['printer_name' => 'required|unique:printers','printer_key' => 'required|unique:printers']);
        //$url        = url('http://www.episcenter.psu.edu/sites/default/files/Presentations/empty.pdf');
        //$print      = @GoogleCloudPrint::asPdf()->url($url)->printer($request->printer_key)->send();
        //if($print->message){return redirect()->back()->withErrors(['message', $print->message]);}
        $request->request->add(['created_by' => Auth::user()->id]);
        $BankBranch = \App\Printer::create($request->all());        
        return redirect()->route('Printer.index');
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
        $form       = new \App\Printer;
        $create     = 'edit';
        $route      = 'Printer.update';
        $EditData   = \App\Printer::find($id);
        return view('Setting.Printer.edit',compact('form','create','route','EditData'));
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
        $this->validate($request, ['printer_name' => 'required|unique:printers,printer_name,'.$id,'printer_key' => 'required|unique:printers,printer_key,'.$id]);
        //$url        = url('http://www.episcenter.psu.edu/sites/default/files/Presentations/empty.pdf');
        //$print      = @GoogleCloudPrint::asPdf()->url($url)->printer($request->printer_key)->send();
        //if($print->message){return redirect()->back()->withErrors(['message', $print->message]);}
        $printers = \App\Printer::find($id);            
        $Printer = $printers->update($request->all());
        $printers->sections()->sync($request->sections);
        return redirect()->route('Printer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('Printer.index');    
        // \App\Branch::whereId($id)->delete($id);
        // return Response()->json($id);
    }
}
