<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line


class Ligne extends Model
{
    use SoftDeletes; //add this line
    
    public function ordre(){
        return $this->belongsTo('App\Orders_model');
    }

    

    public function product()
    {
        
        return $this->belongsTo('App\Products_model','product_id','id');
       
        
        
    }


}
