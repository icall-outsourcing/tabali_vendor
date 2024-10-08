<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Order extends Model
{
    //Main Table 
        protected $table    = 'orders';
        // protected $casts    = ['id','orderid','version','contact_id','follow_up_phone','address_id','branch_id','status','driver_id','total','created_at','updated_at','printed','on_hold_time','payment_type','created_by','updated_by'];
        protected $casts    = ['id','orderid','source','version','follow_up_phone','address_id','branch_id','status','driver_id','total','created_at','updated_at','printed','on_hold_time','payment_type'];
      
        protected $fillable = ['version','discount','source','orderid','contact_id','account_id','branch_id','address_id','driver_id','phone_number','deliveryfees','follow_up_phone','status','printed','print_receipt','confirm_cancellation','cancel_note','total','taxfees','payment_method','on_hold_time','payment_type','order_comment','branch_comment','viewed_at','processing_at','ondelivery_at','delivered_at','closed_at','canceled_at','created_by','updated_by','deleted_by','under_change','voucher_id','voucher_amount','voucher_item','master_branch'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Order';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from orders'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
        //Relationship
        public function contact()   {return $this->belongsTo('App\Contact');}
        public function account()   {return $this->belongsTo('App\Account');}
        public function branch()    {return $this->belongsTo('App\Branch');}
        public function items()     {return $this->hasMany('App\OrderItem');}
        public function driver()    {return $this->belongsTo('App\Driver');}
        public function address()   {return $this->belongsTo('App\Address');}
        public function Voucher()   {return $this->belongsTo('App\Voucher');}
    //report
        public function scopeGetAllQuery($query)
        {
            return $query
                ->join('users'    , 'users.id'    ,'=', 'orders.created_by')
                ->join('accounts' , 'accounts.id' ,'=', 'orders.account_id')
                ->join('branchs'  , 'branchs.id'  ,'=', 'orders.branch_id')
                /*NEW */
                ->join('addresses', 'addresses.id'  ,'=', 'orders.address_id')
                
                
                
                
                
                
                ->selectRaw('DATE(orders.created_at) AS `التاريخ`')
                ->selectRaw('time(orders.created_at) AS `الوقت`')
                /*
                ->selectRaw('governorate as "المحافظه"')
                ->selectRaw('district as "حى"')
                ->selectRaw('area as "المنطقه"')
                */
                /* NEW */
                ->selectRaw('addresses.governorate as "المحافظه"')
                ->selectRaw('addresses.district as "حى"')
                ->selectRaw('addresses.area as "المنطقه"')
                ->selectRaw('orders.id as "رقم الطلب"')
                // ->selectRaw('orders.total as "قيمه الطلب")
                ->selectRaw('orders.total + orders.deliveryfees as "اجمالى قيمة الطلب "')
                ->selectRaw('orders.payment_method as "طريقه الدفع"')
                ->selectRaw('orders.status as "حاله الطلب"')
                ->selectRaw('users.name as "اسم الموظف"')
                ->selectRaw('branchs.name as "الفرع"')
                ->groupBy('orders.id');
        }
        
        
        
        
        
        
        
        
        
        
        public function scopeGetOrdersExport($query)
        {
            return $query
                ->join('users'    , 'users.id'    ,'=', 'orders.created_by')
                ->join('accounts' , 'accounts.id' ,'=', 'orders.account_id')
                ->join('contacts' , 'contacts.id' ,'=', 'orders.contact_id')
                ->join('branchs'  , 'branchs.id'  ,'=', 'orders.branch_id')
                ->leftjoin('drivers'  , 'drivers.id'  ,'=', 'orders.driver_id')
		        ->selectRaw('orders.id as ID')
                ->selectRaw('orders.source as source')
                ->selectRaw('accounts.account_name as "Account Name"')
                ->selectRaw('accounts.id as "Account Number"')
                ->selectRaw('accounts.phone_number as "Account Phones"')
                ->selectRaw('branchs.name as Resturant')
                ->selectRaw('drivers.name as "Rests Drivers Name EN"')
                ->selectRaw('orders.payment_method as "Payment Method"')
                ->selectRaw('orders.payment_type as "Payment Type"')
                ->selectRaw('orders.total + orders.deliveryfees as "Total Price"')
                ->selectRaw('orders.total + orders.deliveryfees as "Sales Without Tax"')
                ->selectRaw('orders.total as "Sales Without Delivery Charge"')
                ->selectRaw('orders.total as "Sales Without Delivery Charge and Tax"')
                ->selectRaw('orders.discount as "discount"')
                ->selectRaw('orders.voucher_amount as "voucher_amount"')
                ->selectRaw('orders.Status as status')
                ->selectRaw('orders.cancel_note as "Cancel Reason"')
                ->selectRaw('orders.order_comment as "Order Note"')
                ->selectRaw('orders.branch_comment as "Branch Note"')
                ->selectRaw('DATE(orders.created_at) AS `Created Date`')
                ->selectRaw('time(orders.created_at) AS `Created Time`')
                ->selectRaw('orders.created_at AS `Created`')
                ->selectRaw('orders.processing_at AS `processing Time`')
                ->selectRaw('orders.ondelivery_at AS `ondelivery Time`')
                ->selectRaw('orders.closed_at    AS `closed Time`')    
		->selectRaw('users.name as "Created By"')
	 	->selectRaw('orders.orderid as ORDERID')
                ->groupBy('orders.id');
        }
        public function scopeGetOrderByDriversExport($query)
        {
            return $query
                ->join('users'    , 'users.id'    ,'=', 'orders.created_by')
                ->join('accounts' , 'accounts.id' ,'=', 'orders.account_id')
                ->join('contacts' , 'contacts.id' ,'=', 'orders.contact_id')
                ->join('branchs'  , 'branchs.id'  ,'=', 'orders.branch_id')
                ->join('drivers'  , 'drivers.id'  ,'=', 'orders.driver_id')
                ->selectRaw('branchs.name as Restaurant')
                ->selectRaw('drivers.name as Driver')
                ->selectRaw('orders.status as Status')
                ->selectRaw('count(*) as TC')

                ->selectRaw('sum(orders.total) + sum(orders.taxfees) as Sales')
                
                
                ->selectRaw('sum(IF(orders.discount > 0 ,(orders.total * (orders.discount  / 100 )), 0)) AS totaldiscount')

                ->selectRaw('sum(orders.deliveryfees) as Delivery')

                ->selectRaw('ROUND(AVG(orders.total) ,2) as "Avg"')
                ->selectRaw('sum(CASE WHEN orders.deliveryfees = "8" THEN 1 ELSE 0 END) as "delivery8"')
                ->selectRaw('sum(CASE WHEN orders.deliveryfees = "10" THEN 1 ELSE 0 END) AS "delivery10"')
                ->selectRaw('sum(CASE WHEN orders.deliveryfees = "15" THEN 1 ELSE 0 END) AS "delivery15"')
                ->selectRaw('sum(CASE WHEN orders.deliveryfees = "20" THEN 1 ELSE 0 END) AS "delivery20"')
                ->selectRaw('sum(CASE WHEN orders.deliveryfees = "21" THEN 1 ELSE 0 END) AS "delivery21"')
                ->selectRaw('sum(CASE WHEN orders.deliveryfees = "25" THEN 1 ELSE 0 END) AS "delivery25"')                
                ->groupBy('drivers.id')
                ->orderBy('orders.branch_id','orders.driver_id');
        }




        public function scopeGetDriversReport($query)
        {
            return $query                
                ->join('branchs'  , 'branchs.id'  ,'=', 'orders.branch_id')
                ->join('drivers'  , 'drivers.id'  ,'=', 'orders.driver_id')
                ->join('addresses','addresses.id' ,'=', 'orders.address_id')            
                ->selectRaw('branchs.name as branch_name')
                ->selectRaw('drivers.name as driver_name')                
                ->selectRaw('orders.orderid as id')
                ->selectRaw('orders.follow_up_phone as tel')
                ->selectRaw('GROUP_CONCAT(addresses.area," - ",addresses.address) as address')                
                ->selectRaw('sum(orders.total) + sum(orders.taxfees) as Sales')                                
                ->selectRaw('((orders.total - IF(orders.discount > 0 ,(orders.total * (orders.discount  / 100 )), 0))     + orders.taxfees + orders.deliveryfees) AS total')                                
                ->selectRaw('if (orders.payment_method in ("paid","Visa Card"), 0,   ((orders.total - IF(orders.discount > 0 ,(orders.total * (orders.discount  / 100 )), 0))     + orders.taxfees + orders.deliveryfees)) AS totalWithoutPaid')
                ->selectRaw('orders.payment_method as Status')                            
                ->groupBy('orders.id');
        }



        
        public function scopeGetDeilveredOrdersRestExport($query){
            return $query
                
                ->join('branchs'  , 'branchs.id'  ,'=', 'orders.branch_id')

                ->selectRaw('branchs.name as Restaurant')
                ->selectRaw('count(*) as TC')
                ->selectRaw('sum(orders.total) as Sales')
                ->selectRaw('ROUND(AVG(orders.total) ,2) as "Avg"')
                ->groupBy('orders.branch_id');
        }
        public function scopeGetSalesOrdersRestStatusExport($query){
            return $query
                
                ->leftjoin('branchs'  , 'branchs.id'  ,'=', 'orders.branch_id')

                ->selectRaw('orders.branch_id as branch_id')
                ->selectRaw('branchs.name as Restaurant')
                ->selectRaw('orders.status as Status')
                ->selectRaw('count(*) as TC')
                ->selectRaw('sum(orders.total) as Sales')
                ->selectRaw('ROUND(AVG(orders.total) ,2) as "Avg"')
                ->groupBy('orders.branch_id','orders.status');
        }
        


        public static function boot()
        {
            parent::boot();
            static::updating(function($order){
                $order->log();        
            });
        }
        public function log()
        {        
            return $this->orderlogs()->attach(Auth::id(),$this->getLog());            
        }
        protected function getLog()
        {
            $changed    = $this->getDirty();
            $before     = json_encode(array_intersect_key($this->fresh()->toArray(),$changed));
            $after      = json_encode($changed);
            $user_id    = Auth::id();
            
            return compact('before','after','user_id');
        }


        public function orderlogs()
        {
            return $this->belongsToMany('App\Orderlog', 'orderlogs')
            ->withTimestamps()
            ->withPivot(['before','after'])
            ->latest('pivot_updated_at');
        }
        
        
        
        
        
}
