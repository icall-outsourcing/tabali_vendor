<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Logitem extends Model
{
    //Main Table 
        protected $table    = 'logitems';
        protected $casts    = ['order_id','product_id','weight','quantity','uprice','tprice','last_status','item_comment','created_by','updated_by','deleted_by'];
        protected $fillable = ['order_id','product_id','weight','quantity','uprice','tprice','last_status','item_comment','created_by','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Logitem';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from logitems'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function item()      {return $this->belongsTo('App\OrderItem');}
        public function order()     {return $this->belongsTo('App\Order');}
        public function product()   {return $this->belongsTo('App\Product');}
}
