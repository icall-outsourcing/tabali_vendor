<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Area extends Model
{
    //Main Table 
        protected $table    = 'areas';
        protected $casts    = ['subdistrict_id','name','created_by','updated_by'];
        protected $fillable = ['subdistrict_id','name','created_by','updated_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Area';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from areas'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
        function deleted_name(){ return $this->hasOne('App\User', 'id', 'deleted_by');}

        public function branch()    {return $this->hasOne('App\Branch','id');}
        public function scopeGetSearch($query,$id)    {
            return $query
                ->join('districts'   , 'districts.id'   ,'=', 'areas.district_id')
                ->join('governorates', 'governorates.id','=', 'districts.governorate_id')
                ->selectRaw("areas.id as id,concat(governorates.name,' / ',districts.name,' / ',areas.name) as name,areas.dlivery_fees as fees,areas.branch_id as branch_id")
                ->orWhereRaw("convert( areas.name        using utf8) LIKE  '%$id%'")
                ->orWhereRaw("convert( districts.name    using utf8) LIKE  '%$id%'")
                ->orWhereRaw("convert( governorates.name using utf8) LIKE  '%$id%'")

                ->groupBy('areas.id')
                ->orderBy('governorates.id','districts.id','areas.id');
    }
    public function scopeGetArea($query,$id)    {
            return $query
                ->join('districts'   , 'districts.id'   ,'=', 'areas.district_id')
                ->join('governorates', 'governorates.id','=', 'districts.governorate_id')
                ->selectRaw("areas.id as id,concat(governorates.name,' / ',districts.name,' / ',areas.name) as name,areas.dlivery_fees as fees,areas.branch_id as branch_id")
                ->WhereRaw("areas.id ='$id'")
                ->groupBy('areas.id');
    }   

}
