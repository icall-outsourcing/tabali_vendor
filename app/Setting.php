<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Setting extends Model
{
    //Main Table 
        protected $table    = 'settings';
        protected $casts    = ['district_id','name','created_by','updated_by'];
        protected $fillable = ['district_id','name','created_by','updated_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Setting';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from settings'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
}
