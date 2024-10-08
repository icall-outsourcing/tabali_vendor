<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Address extends Model
{
    //Main Table 
        protected $table    = 'addresses';
        protected $casts    = ['account_id','area_id','branch_id','governorate','district','subdistrict','area','address','landmark','building_number','floor','apartment','email','address_comment','created_by','updated_by','deleted_by'];
        protected $fillable = ['account_id','discount_id','address_type','area_id','branch_id','governorate','district','subdistrict','area','address','landmark','building_number','floor','apartment','email','address_comment','created_by','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Address';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from addresses'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function Account()	{return $this->belongsTo('App\Account');}
        public function branch()    {return $this->belongsTo('App\Branch');}
        public function orders()    {return $this->hasMany('App\Order');}
        public function discount()  {return $this->hasOne('App\Discount', 'id', 'discount_id');}
}   
