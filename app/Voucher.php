<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //Main Table 
        protected $table    = 'vouchers';
        protected $fillable = ['vouchercode','gift_id','active','status','expire_at','voucher_use','created_by','updated_by'];
        protected $appends  = ['model_name'];
        protected $nullable = ['expire_at'];
        protected $casts    = ['vouchercode','gift_id','active','status','expire_at'];
    //Basic Realtionship
        public function getModelNameAttribute(){ return 'Voucher';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from vouchers'));}
    //Realtionship
        function gift()         { return $this->hasOne('App\Gift', 'id', 'gift_id');}
        function created_name() { return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name() { return $this->hasOne('App\User', 'id', 'updated_by');}





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
