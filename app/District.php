<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class District extends Model
{
    //Main Table 
        protected $table    = 'districts';
        protected $casts    = ['governorate_id','name','created_by','updated_by'];
        protected $fillable = ['governorate_id','name','created_by','updated_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'District';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from districts'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function subdistricts()     {return $this->hasMany('App\Subdistrict');}
}