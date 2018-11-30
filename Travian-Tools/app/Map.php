<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $table='plus';
    
    protected $fillable = [
        'server_id','worldid','x','y','id','vid','village','uid','player','aid','alliance','population','table_id','updatetime'
    ];
    
}
