<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Complaint extends Model
{
    //Main Table 
        protected $table    = 'complaints';
        protected $casts    = ['id','contact_id','order_id','branch_id','Priority','status','complaint_type','follow_up_phone','complain_comment','close_complain_comment','created_at','created_by'];






        protected $fillable = ['Priority','status','complaint_type','follow_up_phone','complain_comment','close_complain_comment','contact_id','account_id','branch_id','order_id','created_by','updated_by'];

        protected $appends  = ['model_name'];
        protected $nullable = ['contact_id','account_id','branch_id',];
        public function getModelNameAttribute(){ return 'Complaint';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from complaints'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}


    //Relationship
        public function accounts()      {return $this->belongsToMany('App\Account');}
        public function account()      {return $this->belongsTo('App\Account');}
        public function contact()      {return $this->belongsTo('App\Contact');}
        public function branch()       {return $this->belongsTo('App\Branch');}
        public function order()       {return $this->belongsTo('App\Order');}
    //Null Able
        /**
        * Listen for save event.
        */
          public function scopeGetComplaint($query){
            return $query
                ->join('users'       , 'users.id'    ,'=', 'complaints.created_by')
                ->join('accounts'    , 'accounts.id' ,'=', 'complaints.account_id')
                ->leftjoin('branchs' , 'branchs.id'  ,'=', 'complaints.branch_id')
                ->leftjoin('orders'  , 'orders.id'    ,'=', 'complaints.order_id')
                ->join('contacts'    , 'contacts.id' ,'=','complaints.contact_id')
                ->selectRaw('complaints.id   as `#`')
                ->selectRaw('orders.id       as `رقم الاوردار`')
                ->selectRaw('orders.orderid  as `رقم الاوردار للفرع`')
                ->selectRaw('branchs.name    as `فرع`')
                ->selectRaw('accounts.account_name AS `الحساب`')
                ->selectRaw('contacts.contact_name AS `اسم العميل`')
                ->selectRaw('complaints.Priority AS `درجه الاهميه`')
                ->selectRaw('complaints.follow_up_phone AS `رقم المتابعه`')
                ->selectRaw('complaints.status AS `الحاله`')
                ->selectRaw('complaints.complaint_type AS `نوع الشكوى`')
                ->selectRaw('complaints.complain_comment AS `ملحوظه`')
                ->selectRaw('complaints.close_complain_comment AS `ملحوظه الاغلاق`')
                ->selectRaw('DATE(complaints.created_at) AS `التاريخ`')
                ->selectRaw('TIME(complaints.created_at) AS `الوقت`')
                ->groupBy('complaints.id');
        }
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
