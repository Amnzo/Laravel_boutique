<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line


class Orders_model extends Model
{
    use SoftDeletes; //add this line
    protected $table='orders';
    protected $primaryKey='id';
    protected $fillable=['users_id',
        'users_email','name','address','city','state','pincode','country','mobile','shipping_charges','coupon_code','coupon_amount',
        'order_status','payment_method','grand_total'];

        public function lignes(){
            return $this->hasMany('App\Ligne','order_id');
        }
        public function user(){
            return $this->belongsTo(User::class,'users_id');
        }
        
    
}
