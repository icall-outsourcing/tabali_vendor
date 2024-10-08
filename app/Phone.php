<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Phone extends Model
{
    //Main Table 
        protected $table    = 'phones';
        protected $casts    = ['contact_id','phone','created_by','updated_by','deleted_by'];
        protected $fillable = ['contact_id','phone','created_by','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Phone';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from phones'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function contact()	{return $this->belongsTo('App\Contact');}
}
