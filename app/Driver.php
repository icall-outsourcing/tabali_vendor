<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Driver extends Model
{
    //Main Table 
        protected $table    = 'drivers';
        protected $casts    = ['name','phone_number','branch_id','status',/*'collected_invoices',*/'created_at'];
        protected $fillable = ['name','phone_number','id_number','branch_id','collected_invoices','status','created_by','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        protected $nullable = ['phone_number','id_number'];
        public function getModelNameAttribute(){ return 'Driver';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from drivers'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function branch()    {return $this->belongsTo('App\Branch');}

    //Deletes
        use SoftDeletes;
        protected $dates    = ['deleted_at'];
        //Relationship
    	public function orders()    {return $this->belongsToMany('App\Order');} 
        //Null Able
        /**
        * Listen for save event.
        */
        protected static function boot()
        {
            parent::boot();
            static::saving(function ($model) {
                $model->setNullables();
            });
        }
        /**
        * Set empty nullable fields to null.
        *
        * @param object $model
        */
        protected function setNullables()
        {
            foreach ($this->nullable as $field) {
                if (empty($this->attributes[$field])) {
                    $this->attributes[$field] = null;
                }
            }
        }
}