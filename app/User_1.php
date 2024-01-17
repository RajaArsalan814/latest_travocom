<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function permissionsList(){
        $roles = $this->roles;
        $permissions = [];
        foreach ($roles as $role){
            $permissions[] = $role->permissions()->pluck('name')->implode(',');
        }
       return collect($permissions);
    }

    public function permissions(){
        $permissions = [];
        $role = $this->roles->first();
        $permissions = $role->permissions()->get();
        return $permissions;
    }

    public function isAdmin(){
       $is_admin =$this->roles()->where('name','admin')->first();
       if($is_admin != null){
           $is_admin = true;
       }else{
           $is_admin = false;
       }
       return $is_admin;
    }

    public function isAccountant(){
       $is_accountant =$this->roles()->where('name','Accounts')->first();
       if($is_accountant != null){
           $is_accountant = true;
       }else{
           $is_accountant = false;
       }
       return $is_accountant;
    }

    public function isSales(){
       $is_sales =$this->roles()->where('name','Sales')->first();
       if($is_sales != null){
           $is_sales = true;
       }else{
           $is_sales = false;
       }
       return $is_sales;
    }
    public function isStore(){
       $is_sales =$this->roles()->where('name','Store')->first();
       if($is_sales != null){
           $is_sales = true;
       }else{
           $is_sales = false;
       }
       return $is_sales;
    }

    public function isCustomer(){
       $is_sales =$this->roles()->where('name','Customer')->first();
       if($is_sales != null){
           $is_sales = true;
       }else{
           $is_sales = false;
       }
       return $is_sales;
    }

    public function isOperator(){
       $is_operator =$this->roles()->where('name','Operator')->first();
       if($is_operator != null){
           $is_operator = true;
       }else{
           $is_operator = false;
       }
       return $is_operator;
    }

    public function isMarketing(){
        $is_operator =$this->roles()->where('name','Marketing')->first();
        if($is_operator != null){
            $is_operator = true;
        }else{
            $is_operator = false;
        }
        return $is_operator;
     }
}
