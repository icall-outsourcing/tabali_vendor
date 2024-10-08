<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Inquiry extends Model
{
    //Main Table 
        protected $table    = 'inquiries';
        protected $casts    = ['id','status','inquiry_type','follow_up_phone'];
        protected $fillable = ['account_id','contact_id','follow_up_phone','status','inquiry_type','inquiry_comment','close_inquiry_comment','created_by','updated_by',];
        protected $appends  = ['model_name'];
        protected $nullable = [];
        public function getModelNameAttribute(){ return 'Inquiry';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from inquiries'));}
        

    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}


    //Relationship
        public function accounts()      {return $this->belongsToMany('App\Account');}
        public function contacts()      {return $this->belongsToMany('App\Contact');}
        
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
        public function scopeGetInquiry($query){
            return $query
                ->join('users'       , 'users.id'    ,'=', 'inquiries.created_by')
                ->join('accounts'    , 'accounts.id' ,'=', 'inquiries.account_id')
                ->join('contacts'    , 'contacts.id' ,'=','inquiries.contact_id')
                ->selectRaw('inquiries.id   as `#`')
                ->selectRaw('accounts.account_name AS `الحساب`')
                ->selectRaw('contacts.contact_name AS `اسم العميل`')
                ->selectRaw('inquiries.inquiry_type AS `نوع الأستفسار`')
                ->selectRaw('inquiries.follow_up_phone AS `رقم المتابعه`')
                ->selectRaw('inquiries.inquiry_comment AS `ملحوظه`')
                ->selectRaw('DATE(inquiries.created_at) AS `التاريخ`')
                ->selectRaw('TIME(inquiries.created_at) AS `الوقت`')
                ->groupBy('inquiries.id');
        }
}
