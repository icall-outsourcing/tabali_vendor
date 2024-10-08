<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $from =Carbon::today();
        // $to = 'ss'; 
        // return $from;
        if ( substr( date("H"), 0, 1 ) == 0 ) {$date = substr( date("H"), 1 );}else{$date = date("H");}
        if( $date < 5){
            $StartDate  = date("Y-m-d", time() - 86400).' 07:00:00';
            $EndDate    = date("Y-m-d").' 03:00:00';
        }else{
            $StartDate  = date("Y-m-d").' 07:00:00 ';
            $EndDate    = date("Y-m-d", time() + 86400).' 03:00:00';
        }

        if (Auth::user()->is('admin|branch|teamleader|supervisor|tabaliadmin|account')) {
            $Branch = \App\Order::selectRaw("branchs.name  as branch_name,
                count(branchs.name)  as totalorder,
                SUM(if(orders.status = 'canceled', 1, 0)) AS canceled,
                SUM(if(orders.status != 'canceled', ((orders.total - IF(orders.discount > 0 ,(orders.total * (orders.discount  / 100 )), 0))     + orders.taxfees), 0)) AS total,                
                SUM(if(orders.status != 'canceled', deliveryfees, 0)) AS deliveryfees
                ")->join('branchs' , 'branchs.id','=','orders.branch_id')
            // ->whereRaw('DATE(orders.created_at) = CURDATE()')
            ->whereRaw("orders.created_at BETWEEN '$StartDate' AND '$EndDate'")
            ->whereIn('branch_id',array_values(Auth::user()->PermissionsList))
            ->groupBy('orders.branch_id')
            ->get();


            return view('admin',compact('Branch'));
        }else{
            return view('home');
        }
    }
    public function authrole()
    {
        return view('errors.role');
    }
    
}
