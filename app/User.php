<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRoleAndPermissionContract
{
    use Authenticatable, CanResetPassword, HasRoleAndPermission, SoftDeletes;


    //Main Table 
        protected $table    = 'users';
        protected $casts    = ['name','email','Roles_List','Permissions_List'];
        protected $fillable = ['name','print','email', 'password','created_at','updated_at','session_id','print_for_driver'];
        protected $appends  = ['model_name'];
        public function getModelNameAttribute(){ return 'User';}
        public function getTablColumns(){return DB::select( DB::raw('show full columns from users'));}

     //Basic Realtionship
        public function printers()      {return $this->belongsToMany('App\Printer');}
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
        protected $hidden = ['password', 'remember_token','deleted_at'];
    
    public function setPasswordAttribute($password)     {$this->attributes['password'] = bcrypt($password);}
    public function getRolesListAttribute($value)       {return $this->getRoles()->lists('id','slug')->toArray();}
    public function getPermissionsListAttribute($value) {return $this->getPermissions()->lists('id','slug')->toArray();}
    public function getBranchsListAttribute($value)     {return $this->getPermissions()->lists('name','id')->toArray();}


}
