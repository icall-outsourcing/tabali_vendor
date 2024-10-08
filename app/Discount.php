<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //Main Table 
        protected $fillable = ['id','company_name','dicount','note'];
        protected $appends  = ['model_name'];
}
