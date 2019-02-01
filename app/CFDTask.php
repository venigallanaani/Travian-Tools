<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CFDTask extends Model
{
    //   
    
    protected $table='defensetasks';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
