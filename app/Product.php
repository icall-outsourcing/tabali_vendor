<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Product extends Model
{
        use SoftDeletes;
        //Main Table 
        protected $dates = ['deleted_at'];
        protected $table    = 'products';
        protected $casts    = ['id','branch_id','extra','extratype','section_name','ar_name','price','available'];
        protected $fillable = ['branch_id','extra','extragroup','sectiongroup','sectionid','section_name','item_code','en_name','ar_name','description','price','available','open_at','created_by','updated_by'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Product';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from products'));}
    //Basic Realtionship
        function created_name(){ return $this->hasOne('App\User', 'id', 'created_by');}
        function updated_name(){ return $this->hasOne('App\User', 'id', 'updated_by');}
    //Relationship
        // public function branchs(){ return $this->belongsToMany('App\Branch');}
        public function branch()    {return $this->belongsTo('App\Branch');}
    //method
       

        function scopeGetSearch($query,$search = ''){
            $table  = $this->fillable;
            $count  = count($this->fillable)-1;
            $countS = count($search)-1;
            $query  = $query->Where(function ($query) use ($search,$count,$table)
            {                                                
                for ($x = 0; $x <= $count ; $x++) {
                    $query->orWhereRaw("convert( $table[$x] using utf8) LIKE  '%$search[0]%'");
                }
            });






          



            
            for ($s = 1; $s <= $countS ; $s++) {
                $query = $query->Where(function ($query) use ($search,$s,$count,$table)
                {                                                        
                    for ($x = 0; $x <= $count ; $x++) {
                        $query->orWhereRaw("convert( $table[$x] using utf8) LIKE  '%$search[$s]%'");
                    }
                });
            }
            return $query;
        }
}
