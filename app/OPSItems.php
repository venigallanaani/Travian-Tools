<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPSItems extends Model
{
    //
    
    protected $table='opsplan';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
