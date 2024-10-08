<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Account extends Model
{
    //Main Table 
        protected $table    = 'accounts';
        protected $casts    = ['branch_id','account_name','account_type','phone_number','governorate','district','subdistrict','area','address','landmark','building_number','floor','apartment','email','account_comment','created_by','updated_by','deleted_by'];
        

        protected $fillable = ['branch_id','account_name','account_type','phone_number','governorate','district','subdistrict','area','address','landmark','building_number','floor','apartment','email','account_comment','created_by','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        protected $nullable = ['phone_number','email'];
        public function getModelNameAttribute(){ return 'Account';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from accounts'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function contacts()      {return $this->belongsToMany('App\Contact')->orderBy('id','desc');}
	   public function orders()	       {return $this->hasMany('App\Order')->orderBy('id','desc');}
        public function orderslimit()	{return $this->hasMany('App\Order')->orderBy('id','desc');}
        


        public function addresses()  {return $this->hasMany('App\Address')->orderBy('id','asc');}



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

    public function scopeGetAllQuery($query)
    {
        return $query
                ->join('orders' , 'accounts.id'        ,'=','orders.account_id')
                ->join('branchs', 'accounts.branch_id' ,'=', 'branchs.id')
                ->selectRaw('DATE(orders.created_at) AS `التاريخ`')
                ->selectRaw('time(orders.created_at) AS `الوقت`')
                ->selectRaw('orders.id as "رقم الطلب"')
                ->selectRaw('account_name as "اسم الحساب"')
                ->selectRaw('accounts.phone_number as "التليفون"')
                ->selectRaw('account_type as "نوع الحساب"')
                // ->selectRaw('governorate as "المحافظه"')
                // ->selectRaw('district as "حى"')
                // ->selectRaw('area as "المنطقه"')
                // ->selectRaw('address as "العنوان"')
                // ->selectRaw('branchs.name as "الفرع"')
                ->selectRaw('email as "البريد الالكترونى"')
                // ->selectRaw('order_comment as "ملاحظات على الطلب"')
                ->selectRaw('branch_comment as "ملاحظات من الفرع"')
                ->selectRaw('account_comment as "ملاحظات على الحساب"')                
                ->groupBy('orders.id');
    }
}
