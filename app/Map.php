<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $table='Maps';
    
    protected $fillable = [
        'map_id','server_id','status','created_at','updated_at'
    ];
    
}
