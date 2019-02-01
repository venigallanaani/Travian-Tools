<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $table='maps';
    
    protected $fillable = [
        'map_id','server_id','status','created_at','updated_at'
    ];
    
}
