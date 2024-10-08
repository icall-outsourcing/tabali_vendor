<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Branch extends Model
{
    //Main Table 
        protected $table    = 'branchs';
        protected $casts    = ['id','name','branch_address','branch_phone','close_on'];
        protected $fillable = ['auto_increment','start_number','name','branch_address','branch_phone','branch_note','created_by','close_time','close_on','backup_branch','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Branch';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from branchs'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
        
        public function items(){ return $this->belongsToMany('App\Product','branch_products', 'product_id','branch_id')->withPivot('available','branch_price','id');}


    //Relationship
        public function addresses() {return $this->hasMany('App\Address');} 
}
