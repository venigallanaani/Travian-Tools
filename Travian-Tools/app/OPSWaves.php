<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPSWaves extends Model
{
    //
    protected $table='offensewaves';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
