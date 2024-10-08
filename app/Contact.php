<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Contact extends Model
{
    //Main Table 
        protected $table    = 'contacts';
        protected $casts    = ['contact_name','email','contact_comment','created_by','updated_by','deleted_by'];
        protected $fillable = ['contact_name','email','contact_comment','created_by','updated_by','deleted_by'];
        protected $appends  = ['model_name'];
        protected $nullable = ['email'];
        public function getModelNameAttribute(){ return 'Contact';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from contacts'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}
    //Relationship
        public function accounts()          {return $this->belongsToMany('App\Account');}
        public function phones()            {return $this->hasMany('App\Phone');}
        public function orders()            {return $this->hasMany('App\Order')->orderBy('id','desc');}
        public function orderslimit()       {return $this->hasMany('App\Order')->orderBy('id','desc');}
        public function complaintslimit()   {return $this->hasMany('App\Complaint')->orderBy('id','desc');}
        public function inquirieslimit()    {return $this->hasMany('App\Inquiry')->orderBy('id','desc');}


        

        
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