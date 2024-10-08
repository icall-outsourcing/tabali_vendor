<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class OrderItem extends Model
{
    //Main Table 
        protected $table    = 'order_items';
        protected $casts    = ['version','order_id','extra_items','product_id','weight','quantity','uprice','tprice','last_status','item_comment','created_by','updated_by','deleted_by'];
        protected $fillable = ['version','order_id','extra_items','product_id','weight','quantity','uprice','tprice','last_status','item_comment','flagtoprint','updateorder','printeraction','oldid','created_by','updated_by','deleted_by','voucher'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'OrderItem';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from order_items'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function order()     {return $this->belongsTo('App\Order');}
        public function product()   {return $this->belongsTo('App\Product');}
    //report
        public function scopeGetAllQuery($query)
        {
            return $query
                ->join('orders'  , 'orders.id'  ,'=', 'order_items.order_id')
                ->join('products'  , 'products.id'  ,'=', 'order_items.product_id')
                ->whereRaw('orders.version = order_items.version')
                ->selectRaw('orders.id as "رقم الطلب"')
                ->selectRaw('extra')
                ->selectRaw('section_name')
                ->selectRaw('ar_name')
                ->selectRaw('quantity')
                ->selectRaw('tprice')
                ->groupBy('order_items.id');
        }
}