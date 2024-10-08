<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Governorate extends Model
{
    //Main Table 
        protected $table    = 'governorates';
        protected $casts    = ['name','created_by','updated_by'];
        protected $fillable = ['name','created_by','updated_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Governorate';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from governorates'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
	//Relationship
    	public function districts() {return $this->hasMany('App\District');} 
}
