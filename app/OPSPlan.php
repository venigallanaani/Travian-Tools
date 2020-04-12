<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPSPlan extends Model
{
    //
    
    protected $table='offenseplans';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
