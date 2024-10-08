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
use PDF;
use GoogleCloudPrint;
use App\Branch;
class PPrintController extends Controller
{


    
    public function index(Request $request, $id, $driver,$printerId){        
        $ids = explode(',', $id);    
        $needPrint  = \App\Order::whereIn('id',$ids)->get();        
        // $printerSectionId = \App\Printer::where('printer_key',$printerId)->first()->Dbsections();
        $printerSectionId = \App\Printer::where('printer_key','10.0.0.100')->first()->Dbsections();
        // $printerSectionId = \App\Printer::find($printerId)->Dbsections();
        foreach($printerSectionId as $array){$sectiontoprint[$array->sectionid] =  $array->sectionid;};    
        $data = ['needPrint'=>$needPrint,'driver'=>$driver,'printerId'=>$printerId,'printerSectionId'=>$printerSectionId,'sectiontoprint'=>$sectiontoprint];        
        // return view('pdf.Order',$data);
        $pdf = PDF::loadView('pdf.order', $data);
        return $pdf->stream('document.pdf');        
    }
    
    public function autoPrint($url){
        
        // $printerId = 'c908b0bd-87f7-63b8-3ba5-5b22ba7ae06d';
        // GoogleCloudPrint::asHtml()->url('http://localhost/tabali.icall.com.eg/index.php/Order/autoPrint?order_id=5')->printer($printerId)->send();
        
        $data = ['id' => $id];
	    $pdf = PDF::loadView('pdf.order', $data);
        return $pdf->stream('document.pdf');

        return '';
        $carbon = new Carbon();  
        $on_hold_time = $carbon->addMinutes(45);    
        if (Auth::user()->is('admin|branch')) {
                //return array_values(Auth::user()->PermissionsList);            
            $model      = new \App\Order;
            $datatable  = \App\Order::where('confirm_cancellation','N')->whereNotIn('status', ['closed'])->whereIn('branch_id',array_values(Auth::user()->PermissionsList))->orderBy('id','desc')->paginate(20);
            return view('Order.Order.index',compact('model','datatable'));
        }
        return redirect()->route('home');
    }

    public function show($id){
        //                
        $order      = \App\Order::find($id);
        $created    = new Carbon($order->created_at);
        $updated    = new Carbon($order->updated_at);
        $ondelivery = new Carbon($order->ondelivery_at);
        return view('Order.Order.print',compact('order','created','updated','ondelivery'));
    }
    // 1st step get orders need to print 
    public function needToPrintByBranch($brnachID){        
        $Orders = \App\Order::select('id')->where('printed','N')->where('branch_id',$brnachID)->where('confirm_cancellation','N')->whereNotIn('status', ['closed'])->orderBy('id','desc')->get()->toArray();
        $ids    = array_column($Orders, 'id');
        $array  = implode(",", $ids);        
        return $array;

    }
    // 2nd step get Printers 
    public function getPrinterByBranch($brnachID){          
        $Orders = \App\Printer::select('ip')->where('branch_id',$brnachID)->get()->toArray();
        $ips    = array_column($Orders, 'ip');
        $array  = implode(",", $ips);        
        return $array;

    }

    public function printPython($driver,$printerIp, $orderId){
        
        
        $cehckupdate            = \App\Order::whereId($orderId)->where('printed','N')->first();
        if(empty($cehckupdate)){
            return '';
        }

        $countItemsnotPrinted   = \App\OrderItem::where('order_id',$orderId)->where('flagtoprint','N')->where('version',$cehckupdate->version)->count();        
        if($countItemsnotPrinted <= 0 ){            
            $order->update(['printed'=>'Y']);
        }
        $order              = \App\Order::whereId($orderId)->where('printed','N')->first();

        if(empty($order)){
            return '';
        }
        $printer            = \App\Printer::where('ip',$printerIp)->where('branch_id',$order->branch_id)->first();
        $printerSectionId   = $printer->Dbsections();
        foreach($printerSectionId as $array){
            $sectiontoprint[$array->sectionid] =  $array->sectionid;
        };   
        
        
        $itemsprinted = array();
        foreach($order->items->where('version',$order->version)->where('flagtoprint','N') as $key => $vlaue){
            if (in_array($vlaue->product->sectionid, $sectiontoprint)){
                $itemsprinted[$vlaue->id] = $vlaue->id;
                // echo $vlaue->id.':::::'.$vlaue->product->sectionid.'<br/>';
            }
        }        
        if(!empty($itemsprinted)){
            $data = ['created'=>new Carbon($order->created_at),'updated'=>new Carbon($order->updated_at),'ondelivery'=>new Carbon($order->ondelivery_at),'order'=>$order,'driver'=>$driver,'printerId'=>$printer->printer_key,'printerSectionId'=>$printerSectionId,'sectiontoprint'=>$sectiontoprint];
            return view('pdf.pythonorder',$data);
        }
            
        return '';
        
        
        
    }

    public function confirmPrint($printerIp, $orderId){   
        $order      = \App\Order::find($orderId);        
        $printer    = \App\Printer::where('ip',$printerIp)->where('branch_id',$order->branch_id)->first();
        $OrderItem  = \App\OrderItem::where('order_id',$orderId)->where('version',$order->version)->get();        
        $sectionid  = [];
        $itemsprinted   = [];
        foreach ($printer->Dbsections() as $key => $vlaue){
             $sectionid[$vlaue->sectionid] = $vlaue->sectionid;
        }

        foreach($OrderItem as $key => $vlaue){
            if (in_array($vlaue->product->sectionid, $sectionid)){
                $itemsprinted[$vlaue->id] = $vlaue->id;
                // echo $vlaue->id.':::::'.$vlaue->product->sectionid.'<br/>';
            }
        }

        $updateOrderItem        = \App\OrderItem::whereIn('id',$itemsprinted)->update(['flagtoprint'=>'Y','updateorder'=>'printed']);        
        $countItemsnotPrinted  = \App\OrderItem::where('order_id',$orderId)->where('flagtoprint','N')->where('version',$order->version)->count();        
        if($countItemsnotPrinted <= 0 ){            
            $order->update(['printed'=>'Y']);
        }
        if (in_array(0, $sectionid)){
            $order->update(['print_receipt'=>'Y']);
        }        
    }

}
