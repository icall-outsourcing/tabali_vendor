<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gift extends Model
{
    //Main Table 
        protected $table    = 'gifts';
        protected $fillable = ['name','active','type','discount','amount','item','expire_at','created_by','updated_by'];
        protected $casts    = ['name','active','type','discount' , 'amount','item','expire_at'];
        protected $appends  = ['model_name'];
        protected $nullable = ['discount','amount','item','expire_at'];
    //Basic Realtionship
        public function getModelNameAttribute(){ return 'Gift';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from gifts'));}
    //Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}



    //NullAble
        protected static function boot()
        {
            parent::boot();
            static::saving(function ($model) {$model->setNullables();});
        }
        /**
        * Set empty nullable fields to null.
        *
        * @param object $model
        */
        protected function setNullables()
        {
            foreach ($this->nullable as $field) {if (empty($this->attributes[$field])) {$this->attributes[$field] = null;}}
        }
}
