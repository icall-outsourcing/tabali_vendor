<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Printer extends Model
{
    //Main Table 
        protected $table    = 'printers';
        protected $casts    = ['printer_name','printer_key','status'];
        protected $fillable = ['printer_name','printer_key','status','branch_id','ip'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'Printer';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from printers'));}
    //Basic Realtionship
        public function users()      {return $this->belongsToMany('App\User');}
        public function sections()   {return $this->belongsToMany('App\Product');}

        public function Dbsections()   {            
            return DB::table('products')->join('printer_product', 'products.sectionid', '=', 'printer_product.product_id')->join('printers', 'printers.id', '=', 'printer_product.printer_id')->where('printers.id',$this->id)->selectRaw('products.*,printers.printer_key')->groupBy('sectionid')->get();
        }
}
