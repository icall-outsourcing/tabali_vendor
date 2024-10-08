<?php

namespace App\Http\Controllers;
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;
use DB;
use Auth;
use PDF;
class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        
        return view('Report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $from       =  $request->startdate;
        $to         =  $request->enddate;
        $branch_id  =  $request->branch_id;
        $report_type=  $request->report_type;
        $driver_id  =  $request->driver_id;
	    // return $report_type;
	    //error_reporting(E_ALL);
	    //ini_set('display_errors', 1);
	    //    
        $Account    = \App\Account::whereBetween('orders.created_at', array($from, $to));
        $Orders     = \App\Order::whereIn('orders.branch_id',$branch_id)->whereBetween('orders.created_at', array($from, $to));
        $Items      = \App\OrderItem::whereBetween('orders.created_at', array($from, $to));
        // Orders
        if ($report_type == 1) {
            $Orders     = $Orders->getOrdersExport()->get();
            Excel::create('OLDORDERSEXPORT', function($excel) use ($Orders) {
                $excel->sheet('Orders', function($sheet) use($Orders) {$sheet->fromArray($Orders);});
            })->export('xlsx');
            
        //Deilvered Orders By Driver
        }elseif ($report_type == 2) {
            /*if (Auth::user()->is('admin')) {return view('Report.Deilvered Orders By Driver for branch',compact('from','to','reports'));}*/            
            // Excel::create('DeilveredOrdersByDriver', function($excel) use ($from, $to,$reports ) {
                //     $excel->sheet('DeilveredOrdersByDriver', function($sheet) use ($from, $to,$reports ) {
                    //         $sheet->loadView('Report.Deilvered Orders By Driver',compact('from','to','reports'));
                    //         $sheet->getProtection()->setPassword('password');
                    //         $sheet->getProtection()->setSheet(true);
                    //         $sheet->setOrientation('landscape');
                    //     });
            // })->export('xlsx');
            $reports     = $Orders->where('orders.status','closed')->getOrderByDriversExport()->get();
            $data = ['from'=>$from,'to'=>$to,'reports'=>$reports];
            $pdf = PDF::loadView('pdf.Deilvered Orders By Driver', $data);
            return $pdf->stream('Deilvered Orders By Driver.pdf');



        //Deilvered Orders Rest
        }elseif ($report_type == 3) {
            $Delivery    = \App\Order::whereIn('orders.branch_id',$branch_id)->whereBetween('orders.created_at', array($from, $to))->where('orders.payment_type','Delivery')->getDeilveredOrdersRestExport()->get();
            $HotSpot     = \App\Order::whereIn('orders.branch_id',$branch_id)->whereBetween('orders.created_at', array($from, $to))->where('orders.payment_type','HotSpot' )->getDeilveredOrdersRestExport()->get();
            // return view('Report.Deilvered Orders Rest',compact('from','to','Delivery','HotSpot'));
            Excel::create('DeilveredOrdersRest', function($excel) use ($from, $to,$HotSpot,$Delivery ) {
                $excel->sheet('DeilveredOrdersRest', function($sheet) use ($from, $to,$HotSpot,$Delivery ) {
                    $sheet->loadView('Report.Deilvered Orders Rest',compact('from','to','Delivery','HotSpot'));
                    $sheet->setOrientation('landscape');
                });
            })->export('xlsx');
        //Sales Orders RestStatus
        }elseif ($report_type == 4) {
            $branch_Delivery   = \App\Order::whereIn('orders.branch_id',$branch_id)->whereBetween('orders.created_at', array($from, $to))->where('payment_type','Delivery')->lists('branch_id','branch_id')->toArray();
            $branch_HotSpot   = \App\Order::whereIn('orders.branch_id',$branch_id)->whereBetween('orders.created_at', array($from, $to))->where('payment_type','HotSpot')->lists('branch_id','branch_id')->toArray();
            // return view('Report.Sales Orders RestStatus',compact('from','to','branch_Delivery','branch_HotSpot'));
            Excel::create('DeilveredOrdersRest', function($excel) use ($from, $to,$branch_HotSpot,$branch_Delivery ) {
                $excel->sheet('DeilveredOrdersRest', function($sheet) use ($from, $to,$branch_HotSpot,$branch_Delivery ) {
                    $sheet->loadView('Report.Sales Orders RestStatus',compact('from','to','branch_HotSpot','branch_Delivery'));
                    $sheet->setOrientation('landscape');
                });
            })->export('xlsx');
        //Complaint
        }elseif ($report_type == 5) {
            $complaints     = \App\Complaint::whereIn('complaints.branch_id',$branch_id)->whereBetween('complaints.created_at', array($from, $to))->getComplaint()->get();
            Excel::create('Complaint', function($excel) use ($complaints) {
                $excel->sheet('complaints', function($sheet) use($complaints) {$sheet->fromArray($complaints);});
            })->export('xlsx');
        //Total Menu sales
        }elseif ($report_type == 6) {
            $arrbranch_id = implode (", ", $branch_id);
            $branch_name = \App\Branch::select('name')->whereIn('id',$branch_id)->get();
            $reports = DB::select(DB::raw("select  products.item_group_name as name ,sum(quantity) as quantity,uprice,sum(tprice) as tprice , products.section_name as section  from `order_items`  join products on products.id = order_items.product_id inner join `orders` on `orders`.`id` = `order_items`.`order_id` and `orders`.`version` = order_items.version and `orders`.`branch_id` in ($arrbranch_id) where `orders`.`created_at` between '$from' and '$to'  and `orders`.`status` = 'closed'   group by `products`.`item_group_name`"));
            $total = \App\Order::selectRaw('sum(IF(orders.discount > 0 AND orders.`status`="closed" ,(orders.total * (orders.discount  / 100 )), 0)) AS totaldiscount')->selectRaw('SUM(orders.total) AS total')->selectRaw('SUM(orders.taxfees) AS taxfees')->selectRaw('SUM(orders.deliveryfees) AS deliveryfees')->selectRaw('(SUM(orders.total) + SUM(orders.taxfees) + SUM(orders.deliveryfees)) AS total_amount')->whereIn('branch_id',$branch_id)->whereBetween('created_at', array($from, $to))->where('status','closed')->first();        
            $SumOrder = \App\Order::
            selectRaw('SUM(case when `STATUS` = "closed" AND  payment_method= "Cash" then (total + taxfees + deliveryfees) else 0 end) as cash')
            ->selectRaw('SUM(case when `STATUS` = "canceled"  then (total + taxfees + deliveryfees) else 0 end) as void')
            ->selectRaw('SUM(case when `STATUS` = "closed" AND  payment_method= "paid" then (total + taxfees + deliveryfees) else 0 end) as on_line')
            ->selectRaw('SUM(case when `STATUS` = "closed" AND  payment_method= "Cash" then 1 else 0 end) as Tcash')
            ->selectRaw('SUM(case when `STATUS` = "closed" AND  payment_method= "paid" then 1 else 0 end) as Ton_line')
            ->selectRaw('SUM(case when `STATUS` = "canceled"  then 1 else 0 end) as Tvoid')
            ->selectRaw('SUM(case when `STATUS` = "closed" AND  payment_method= "Cash" AND discount > 0 then (total * (discount / 100 )) else 0 end) as cashDiscount')
            ->selectRaw('SUM(case when `STATUS` = "closed" AND  payment_method= "paid" AND discount > 0 then (total * (discount / 100 )) else 0 end) as on_lineDiscount')            
            ->whereIn('branch_id',$branch_id)->whereBetween('created_at', array($from, $to))->first();
            $data = ['from'=>$from,'to'=>$to,'reports'=>$reports,'branch_name'=>$branch_name,'total'=>$total,'SumOrder'=>$SumOrder];
            $pdf = PDF::loadView('pdf.Total Menu Sales', $data);
            return $pdf->stream('Report.Total Menu Sales.pdf');
        
        
        
        // Driver Report
        }elseif ($report_type == 7) {
            $reports     = $Orders->where('orders.status','closed')->where('driver_id',$driver_id)->getDriversReport()->get();
            $data = ['from'=>$from,'to'=>$to,'reports'=>$reports];
            $pdf = PDF::loadView('pdf.Driver Report', $data);
            return $pdf->stream('Driver Report.pdf');
        }elseif ($report_type == 8) {
            return 'Count for menu item';			
        }elseif ($report_type == 9) {
            $Orders     = $Orders->where('source','!=','Phone')->getOrdersExport()->get();
            Excel::create('OLDORDERSEXPORT', function($excel) use ($Orders) {
                $excel->sheet('Orders', function($sheet) use($Orders) {$sheet->fromArray($Orders);});
            })->export('xlsx');
        }else{
        //icall Report        
            $Account    = $Account->whereIn('accounts.branch_id',$branch_id)->getAllQuery()->get();
            $Orders     = $Orders->whereIn('orders.branch_id',$branch_id)->getAllQuery()->get();
            $Items      = $Items->whereIn('orders.branch_id',$branch_id)->getAllQuery()->get();
            // return  'ok';
            Excel::create('Report', function($excel) use($Account,$Orders,$Items) 
            {
                $excel->sheet('Account', function($sheet) use($Account) {$sheet->fromArray($Account);});
                $excel->sheet('Orders', function($sheet) use($Orders) {$sheet->fromArray($Orders);});
                $excel->sheet('Items', function($sheet) use($Items) {
                $sheet->fromArray($Items); $sheet->setAutoFilter(); });
            })->export('xlsx');
        }




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